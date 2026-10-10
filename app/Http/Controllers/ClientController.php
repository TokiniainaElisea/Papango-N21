<?php
namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //index
    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->name, fn($q, $v) => $q->where('name', 'like', "%{$v}%"))
            ->when($request->firstname, fn($q, $v) => $q->where('firstname', 'like', "%{$v}%"))
            ->when($request->client_number, fn($q, $v) => $q->where('client_number', 'like', "%{$v}%"))
            ->when($request->phone, fn($q, $v) => $q->where('phone', 'like', "%{$v}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('clients.clients', compact('clients'));
    }

    //store
    public function store(ClientStoreRequest $request)
    {
        $client = Client::create($request->validated());
        $client_number = 'CLI-0'.$client->id;
        $client->update([
            'client_number' => $client_number
        ]);
        return back()->with('success', 'Client(e) ajouté(e) avec succès');
    }

    //update
    public function update(ClientStoreRequest $request, $id)
    {
        $client = Client::find($id);
        $client->update($request->validated());

        return back()->with('success', 'Modification(s)  effectuée(s)');
    }

    //show 
    public function show(Client $client){
        return view('clients.parts.show_client', compact('client'));
    }

    //delete
    public function delete(Client $client){
        $client->delete();
        return back()->with('success', 'Client(e) supprimé(e) avec succès');
    }
}
