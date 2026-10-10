<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProviderStoreRequest;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    //index
    public function index(Request $request)
    {
        $providers = Provider::query()
            ->when($request->name_provider, fn($q, $v) => $q->where('name_provider', 'like', "%{$v}%"))
            ->when($request->mail, fn($q, $v) => $q->where('mail', 'like', "%{$v}%"))
            ->when($request->phone, fn($q, $v) => $q->where('phone', 'like', "%{$v}%"))
            ->when($request->town, fn($q, $v) => $q->where('town', 'like', "%{$v}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('providers.providers', compact('providers'));
    }

    //store
    public function store(ProviderStoreRequest $request)
    {
        Provider::create($request->validated());
        return back()->with('success', 'Nouveau fournisseur ajouté');
    }

    //update
    public function update(ProviderStoreRequest $request, $id){
        $provider = Provider::find($id);
        $provider->update($request->validated());

        return back()->with('success', 'Modification(s) effectué(e)');
    }

    //show
    public function show(Provider $provider){
        return view('providers.parts.show_provider', compact('provider'));
    }

    //delete
    public function delete(Provider $provider){
        $provider->delete();
        return back()->with('success', 'Le fournisseur a bien été supprimé');
    }
}
