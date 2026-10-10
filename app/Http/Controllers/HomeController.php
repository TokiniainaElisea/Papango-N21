<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    //last activities
    /**
     * Retourne les dernières activités (pour le dashboard).
     */
    protected function getLatestActivities(int $limit = 8)
    {
        return Activity::query()
            ->with('client')
            ->latest() // trie par created_at DESC
            ->limit($limit)
            ->get();
    }

    //CA journalier
    protected function getDailyRevenueChartData(): array
    {
        $start = Carbon::today()->subDays(29);
        $end   = Carbon::today()->endOfDay();

        $rows = Activity::query()
            ->whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $labels = [];
        $values = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $key = $date->format('Y-m-d');

            $labels[] = $date->format('d/m');
            $values[] = (float) ($rows[$key]->revenue ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
    //category chart
    protected function getCategoryChartData(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfMonth   = Carbon::now()->endOfMonth()->toDateTimeString();

        // On récupère les catégories avec le total des quantités vendues ce mois
        $rows = DB::table('activity_details')
            ->join('activities', 'activities.id', '=', 'activity_details.activity_id')
            ->join('services', 'services.id', '=', 'activity_details.service_id')
            ->join('categories', 'categories.id', '=', 'services.category_id')
            ->whereBetween('activities.created_at', [$startOfMonth, $endOfMonth])
            ->select(
                'categories.name as category_label',
                DB::raw('SUM(activity_details.quantity) as total_quantity')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_quantity')
            ->limit(6)
            ->get();

        return [
            'labels' => $rows->pluck('category_label')->toArray(),
            'values' => $rows->pluck('total_quantity')->map(fn($v) => (int) $v)->toArray(),
        ];
    }
    //index
    public function index()
    {
        $today = Carbon::today();

        // 1. CA du jour (somme des total_price des activités du jour)
        $todayRevenue = Activity::whereDate('created_at', $today)
            ->sum('total_price');

        // 2. Nombre de ventes du jour
        $todaySalesCount = Activity::whereDate('created_at', $today)->count();

        // 3. Panier moyen du jour
        $todayAverageCart = $todaySalesCount > 0
            ? $todayRevenue / $todaySalesCount
            : 0;

        // 4. Clients servis aujourd'hui (clients distincts dans les activités du jour)
        $todayClientsCount = Activity::whereDate('created_at', $today)
            ->whereNotNull('client_id')
            ->distinct('client_id')
            ->count('client_id');

        // 5. Papiers en stock bas
        //    On considère un papier en stock bas si son stock total <= un seuil (ex: 100)
        $lowStockThreshold = 100;

        $lowStockCount = Stock::query()
            ->withSum('stock_movement as total_stock', 'in_stock')
            ->get()
            ->filter(fn($stock) => ($stock->total_stock ?? 0) <= $lowStockThreshold)
            ->count();

        $categoryChart = $this->getCategoryChartData();

        $revenueChart = $this->getDailyRevenueChartData();

        $latestActivities = $this->getLatestActivities(8);

        return view('home.index', compact(
            'todayRevenue',
            'todaySalesCount',
            'todayAverageCart',
            'todayClientsCount',
            'lowStockCount',
            'categoryChart',
            'revenueChart', 
            'latestActivities'
        ));
    }
}
