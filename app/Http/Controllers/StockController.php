<?php
namespace App\Http\Controllers;

use App\Models\Format;
use App\Models\Provider;
use App\Models\Stock;
use App\Models\Stock_movement;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    //index
    public function index(Request $request)
    {
        $stocks = Stock::query()
            ->with(['provider', 'format', 'stock_movement', 'type'])
            ->when($request->label, fn($q, $v) => $q->where('label', 'like', "%{$v}%"))
            ->when($request->provider_id, fn($q, $v) => $q->where('provider_id', $v))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Indispensable pour le <select> des fournisseurs
        $providers = Provider::orderBy('name_provider')->get();

        return view('stocks.stocks', compact('stocks', 'providers'));
    }

    //create
    public function create()
    {
        $paperTypes = Type::orderBy('name')->get();
        $formats    = Format::orderBy('name')->get();
        $providers  = Provider::orderBy('name_provider')->get();

        return view('stocks.new_stock', compact('paperTypes', 'formats', 'providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Papier
            'label'          => 'nullable|string|max:255',
            'type_id'        => 'required|exists:types,id',
            'format_id'      => 'required|exists:formats,id',
            'provider_id'    => 'required|exists:providers,id',

            // Premier mouvement
            'movement_type'  => 'nullable|in:entry',
            'initial_stock'  => 'required|integer|min:0',
            'provider_price' => 'required|numeric|min:0',
            'entry_stock'    => 'required|date',
        ]);

        // Création
        DB::transaction(function () use ($validated) {
            $stock = Stock::create([
                'label'       => $validated['label'],
                'type_id'     => $validated['type_id'],
                'format_id'   => $validated['format_id'],
                'provider_id' => $validated['provider_id'],
            ]);

            $stock->stock_movement()->create([
                'movement_type'  => $validated['movement_type'],
                'initial_stock'  => $validated['initial_stock'],
                'in_stock'       => $validated['initial_stock'],
                'provider_price' => $validated['provider_price'],
                'entry_stock'    => $validated['entry_stock'],
            ]);
        });

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Papier créé avec succès.');
    }

    //show
    public function show(Stock $stock)
    {
        $stock->load(['type', 'format', 'provider']);

        $stock_movement = Stock_movement::where('stock_id', $stock->id)
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('stocks.show_stocks', compact('stock', 'stock_movement'));
    }

    //edit
    public function edit(Stock $stock)
    {
        $paperTypes = Type::orderBy('name')->get();
        $formats    = Format::orderBy('name')->get();
        $providers  = Provider::orderBy('name_provider')->get();

        return view('stocks.edit_stock', compact('stock', 'paperTypes', 'formats', 'providers'));
    }

    //update
    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'label'         => 'required|string|max:255',
            'paper_type_id' => 'required|exists:types,id',
            'format_id'     => 'required|exists:formats,id',
            'provider_id'   => 'required|exists:providers,id',
        ]);

        $stock->update($validated);

        return redirect()
            ->route('stocks.show', $stock)
            ->with('success', 'Article mis à jour avec succès.');
    }

    //destroy
    public function destroy(Stock $stock)
    {
        $stock->delete(); // Les mouvements liés sont supprimés automatiquement

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Article et son historique de mouvements supprimés.');
    }
}
