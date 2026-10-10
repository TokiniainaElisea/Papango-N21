<?php
namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Client;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //index
    public function index(Request $request)
    {
        $activities = Activity::query()
            ->with(['client', 'details']) // chargement des relations pour éviter le N+1
            ->when($request->ref, fn($q, $v) => $q->where('ref', 'like', "%{$v}%"))
            ->when($request->client_name, function ($q, $v) {
                $q->whereHas('client', function ($sub) use ($v) {
                    $sub->where('name', 'like', "%{$v}%")
                        ->orWhere('firstname', 'like', "%{$v}%");
                });
            })
            ->when($request->date_from, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($request->date_to, fn($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('activity.activities', compact('activities'));
    }

    //create
    public function create()
    {
        $clients = Client::paginate(10);
        return view('activity.new.new_activity', );
    }

    //show
    public function show(Activity $activity)
    {
        $activity->load([
            'client',
            'details.service', // charge aussi le service lié (utile pour le lien)
        ]);

        return view('activity.show_activity', compact('activity'));
    }

    //print
    public function print(Activity $activity)
    {
        $activity->load([
            'client',
            'details.service.stock.format',
        ]);

        return view('activity.activity_invoice', compact('activity'));
    }
}
