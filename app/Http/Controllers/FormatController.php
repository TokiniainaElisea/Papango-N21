<?php
namespace App\Http\Controllers;

use App\Models\Format;
use Illuminate\Http\Request;

class FormatController extends Controller
{
    //index
    public function index()
    {
        $formats = Format::orderBy('name')
            ->paginate(15);
        return view('stocks.format.format', compact('formats'));
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:formats,name',
            'dimension' => 'nullable|string|max:255',
        ]);

        Format::create($validated);

        return redirect()
            ->route('formats.index')
            ->with('success', 'Format créé avec succès.');
    }

    //update
    public function update(Request $request, Format $format)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:formats,name,' . $format->id,
            'dimension' => 'nullable|string|max:255',
        ]);

        $format->update($validated);

        return redirect()
            ->route('formats.index')
            ->with('success', 'Format mis à jour avec succès.');
    }

    //delete
    public function destroy(Format $format)
    {
        $format->delete();

        return redirect()
            ->route('formats.index')
            ->with('success', 'Format supprimé avec succès.');
    }
}
