<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Expense;
use App\Models\Stock_movement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BilanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Déterminer la période
        [$startDate, $endDate, $periodLabel] = $this->resolvePeriod($request);

        // 2. KPIs
        $baseQuery = Activity::whereBetween('created_at', [$startDate, $endDate]);

        $revenue         = (clone $baseQuery)->sum('total_price');
        $activitiesCount = (clone $baseQuery)->count();
        $averageCart     = $activitiesCount > 0
            ? $revenue / $activitiesCount
            : 0;
        $monthlyRevenue = $this->getMonthlyRevenueChartData();

        $topServices = $this->getTopServices($startDate, $endDate, 5);

        $categoryDistribution = $this->getCategoryDistribution($startDate, $endDate);

        $totalExpenses      = $this->getTotalExpenses($startDate, $endDate);
        $totalProviderCosts = $this->getTotalProviderCosts($startDate, $endDate);
        $profit             = $revenue - ($totalExpenses + $totalProviderCosts);

        return view('bilan.index', compact(
            'startDate',
            'endDate',
            'periodLabel',
            'revenue',
            'activitiesCount',
            'averageCart',
            'averageCart',
            'monthlyRevenue',
            'categoryDistribution',
            'topServices',
            'totalExpenses',
            'totalProviderCosts',
            'profit'
        ));
    }

    /**
     * Détermine la période à partir des paramètres de la requête.
     * Par défaut : le mois en cours.
     */
    protected function resolvePeriod(Request $request): array
    {
        // Période personnalisée
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $start = Carbon::parse($request->date_from)->startOfDay();
            $end   = Carbon::parse($request->date_to)->endOfDay();

            $label = $start->isSameDay($end)
                ? $start->format('d/m/Y')
                : sprintf('%s → %s', $start->format('d/m/Y'), $end->format('d/m/Y'));

            return [$start, $end, $label];
        }

        // Période par défaut : mois en cours
        return [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth(),
            'Ce mois',
        ];
    }

    /**
     * Retourne le CA mensuel sur l'année en cours.
     * Format : ['labels' => [...], 'values' => [...]]
     */
    protected function getMonthlyRevenueChartData(): array
    {
        $year = Carbon::now()->year;

        // Récupère le CA groupé par mois
        $rows = Activity::query()
            ->whereYear('created_at', $year)
            ->select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month'); // indexé par numéro de mois (1-12)

        // Mois français (Janvier → Décembre)
        $monthNames = [
            1 => 'Jan', 2  => 'Fév', 3  => 'Mar', 4  => 'Avr',
            5 => 'Mai', 6  => 'Juin', 7 => 'Juil', 8 => 'Août',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc',
        ];

        $labels = [];
        $values = [];

        // On génère les 12 mois, même ceux sans vente (0)
        foreach ($monthNames as $num => $name) {
            $labels[] = $name;
            $values[] = (float) ($rows[$num]->revenue ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
            'year'   => $year,
            'total'  => array_sum($values),
        ];
    }

    /**
     * Retourne la répartition par catégorie sur la période donnée.
     * Format : ['labels' => [...], 'values' => [...]]
     */
    protected function getCategoryDistribution(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('activity_details')
            ->join('activities', 'activities.id', '=', 'activity_details.activity_id')
            ->join('services', 'services.id', '=', 'activity_details.service_id')
            ->join('categories', 'categories.id', '=', 'services.category_id')
            ->whereBetween('activities.created_at', [$start, $end])
            ->select(
                'categories.name as category_label',
                DB::raw('SUM(activity_details.total_line) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();

        return [
            'labels' => $rows->pluck('category_label')->toArray(),
            'values' => $rows->pluck('total_revenue')->map(fn($v) => (float) $v)->toArray(),
        ];
    }

    /**
     * Retourne le top des services vendus sur la période.
     * Trié par chiffre d'affaires décroissant.
     */
    protected function getTopServices(Carbon $start, Carbon $end, int $limit = 5)
    {
        return DB::table('activity_details')
            ->join('activities', 'activities.id', '=', 'activity_details.activity_id')
            ->whereBetween('activities.created_at', [$start, $end])
            ->select(
                'activity_details.service_label',
                'activity_details.service_id',
                DB::raw('SUM(activity_details.quantity) as total_quantity'),
                DB::raw('SUM(activity_details.total_line) as total_revenue')
            )
            ->groupBy('activity_details.service_id', 'activity_details.service_label')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get();
    }

    protected function getTotalExpenses(Carbon $start, Carbon $end): float
    {
        return (float) Expense::whereBetween('created_at', [$start, $end])
            ->sum('amount');
    }

    protected function getTotalProviderCosts(Carbon $start, Carbon $end): float
    {
        // On ne prend que les mouvements d'entrée (les sorties ont provider_price = 0)
        return (float) Stock_movement::whereBetween('created_at', [$start, $end])
            ->where('movement_type', 'entry')
            ->sum('provider_price');
    }
}
