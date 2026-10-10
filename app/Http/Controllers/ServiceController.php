<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Format;
use App\Models\Service;
use App\Models\Stock;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //index
    public function index(Request $request)
    {
        $services = Service::query()
            ->with(['category', 'format', 'stock'])
            ->when($request->label, fn($q, $v) => $q->where('label', 'like', "%{$v}%"))
            ->when($request->category_id, fn($q, $v) => $q->where('category_id', $v))
            ->when($request->stock_id, fn($q, $v) => $q->where('stock_id', $v))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Données pour les selects de la barre de recherche
        $categories = Category::orderBy('label')->get();
        $stocks     = Stock::orderBy('label')->get();
        $formats    = Format::orderBy('name')->get();

        return view('service.services', compact('services', 'categories', 'stocks', 'formats'));
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'       => 'required|string|max:255',
            'color'       => 'required|in:noir,couleur,non-applicable',
            'format_id'   => 'required|exists:formats,id',
            'stock_id'    => 'required|exists:stocks,id',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Service::create($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service créé avec succès.');
    }

    //update
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'label'       => 'required|string|max:255',
            'color'       => 'required|in:noir,couleur,non-applicable',
            'format_id'   => 'required|exists:formats,id',
            'stock_id'    => 'required|exists:stocks,id',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    //destroy
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Service supprimé avec succès.');
    }

    //show
    public function show(Service $service)
    {
        $service->load(['category', 'format', 'stock']);

        return view('service.show_service', compact('service'));
    }
}
