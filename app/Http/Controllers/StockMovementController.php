<?php
namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Stock_movement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    //index
    public function index(Stock $_stock)
    {
        // Le stock concerné
        $stock = Stock::with(['type', 'format', 'provider'])
            ->findOrFail($_stock->id);

        // Les mouvements paginés
        $movements = Stock_movement::where('stock_id', $stock->id)
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        // Stats calculées séparément (requêtes agrégées, pas de chargement complet)
        $totalStock = Stock_movement::where('stock_id', $stock->id)->sum('in_stock');
        $totalCount = Stock_movement::where('stock_id', $stock->id)->count();
        $lastPrice  = Stock_movement::where('stock_id', $stock->id)
            ->orderByDesc('entry_stock')
            ->value('provider_price');

        $lastMovement = Stock_movement::where('stock_id', $stock->id)
            ->orderByDesc('created_at')
            ->first();
        $lastMovementId = $lastMovement?->id;

        return view('stocks.movement.movement', compact(
            'stock',
            'movements',
            'totalStock',
            'totalCount',
            'lastPrice',
            'lastMovementId'
        ));
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_id'       => 'required',
            'movement_type'  => 'required|in:entry,exit',
            'initial_stock'  => 'required|integer|min:1',
            'provider_price' => 'required|numeric|min:0',
            'entry_stock'    => 'required|date',
        ]);

        $stock = Stock::findOrFail($validated['stock_id']);

        // Stock actuel = in_stock du dernier mouvement
        $previousStock = Stock_movement::where('stock_id', $stock->id)
            ->orderByDesc('created_at')
            ->value('in_stock') ?? 0;

        // Vérification : pas de sortie supérieure au stock actuel
        if ($validated['movement_type'] === 'exit' && $validated['initial_stock'] > $previousStock) {
            return back()
                ->withErrors(['initial_stock' => "Stock insuffisant. Stock actuel : {$previousStock} unités."])
                ->withInput();
        }

        // Calcul du nouveau in_stock
        $newInStock = $validated['movement_type'] === 'entry'
            ? $validated['initial_stock']
            : -$validated['initial_stock'];

        Stock_movement::create([
            'stock_id'       => $stock->id,
            'movement_type'  => $validated['movement_type'],
            'initial_stock'  => $validated['initial_stock'],
            'in_stock'       => $newInStock,
            'provider_price' => $validated['provider_price'],
            'entry_stock'    => $validated['entry_stock'],
        ]);

        return redirect()
            ->route('stocks-movement.index', ['_stock' => $stock])
            ->with('success', 'Mouvement enregistré avec succès.');
    }

    public function destroy(Stock_movement $movement)
    {
        // Vérifier que c'est bien le dernier mouvement du stock
        $lastId = Stock_movement::where('stock_id', $movement->stock_id)
            ->orderByDesc('created_at')
            ->value('id');

        if ($movement->id !== $lastId) {
            return back()->with('error', 'Seul le dernier mouvement peut être supprimé.');
        }

        $stockId = $movement->stock_id;
        $movement->delete();

        return back()->with('success', 'Mouvement supprimé avec succès.');
    }
}
