<?php
namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    //index
    public function index()
    {
        $paperTypes = Type::orderBy('name')
            ->paginate(15);

        return view('stocks.type.types', compact('paperTypes'));
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Type::create($validated);

        return redirect()
            ->route('types.index')
            ->with('success', 'Type de papier créé avec succès.');
    }

    //update
    public function update(Request $request, $id)
    {
        $paperType = Type::find($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $paperType->update($validated);

        return redirect()
            ->route('types.index')
            ->with('success', 'Type de papier mis à jour avec succès.');
    }

    //destroy
    public function destroy( $id)
    {
        $paperType = Type::find($id);
        $paperType->delete();

        return redirect()
            ->route('types.index')
            ->with('success', 'Type de papier supprimé avec succès.');
    }
}
