<?php
namespace App\Http\Controllers;

use App\Http\Requests\ExpensesCreateRequest;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expense;

class ExpensesController extends Controller
{


    public function index(ExpensesRequest $request)
    {
        $expenses = Expense::query();

        // Recherche par libellé
        if ($request->filled('label')) {

            $expenses->where(
                'label',
                'like',
                '%' . $request->label . '%'
            );

        }

        // Filtre par type
        if ($request->filled('type')) {

            $expenses->where(
                'type',
                $request->type
            );

        }

        // Date de début
        if ($request->filled('begin')) {

            $expenses->whereDate(
                'created_at',
                '>=',
                $request->begin
            );

        }

        // Date de fin
        if ($request->filled('ending')) {

            $expenses->whereDate(
                'created_at',
                '<=',
                $request->ending
            );

        }

        $expenses = $expenses
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('expenses.expenses', [
            'expenses' => $expenses,
        ]);
    }
    
    //new expense
    public function new_expense(ExpensesCreateRequest $request){
        $credentials = $request->validated();

        Expense::create($credentials);

        return to_route('expenses')->with('success', 'Nouvelle dépense ajoutée');
    }

    //destroy expense
    public function expense_destroy(Expense $expense){
        //je recharge au cas où
        Expense::destroy($expense->id);

        return to_route('expenses')->with('success', 'Dépense supprimée avec succès');
    }

    public function update_expense(ExpensesCreateRequest $request, Expense $expense){
        $credentials = $request->validated();

        //on recharge au cas où
        $_expense = Expense::find($expense->id);

        $_expense->update($credentials);

        return to_route('expenses')->with('success', 'Dépense modifiée');
    }
}
