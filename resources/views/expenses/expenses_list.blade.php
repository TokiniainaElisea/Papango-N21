<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        {{-- En-tête de la carte --}}
        <div class="p-4 pb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 text-uppercase text-secondary fw-bold mb-1" style="font-size: .7rem; letter-spacing: .5px;">
                    <i class="bi bi-wallet2 me-1"></i>
                    Liste des dépenses
                </h2>
                <p class="text-secondary small mb-0">
                    Historique des dépenses enregistrées.
                </p>
            </div>

            <span class="badge bg-body-tertiary text-body border fw-normal">
                {{ $expenses->count() }} dépense(s)
            </span>
        </div>

        @if ($expenses->isEmpty())

            <div class="text-center py-5">
                <i class="bi bi-wallet2 fs-1 text-secondary d-block mb-2"></i>
                <p class="text-secondary mb-1">Aucune dépense enregistrée.</p>
                <small class="text-secondary">
                    Commencez par ajouter une nouvelle dépense.
                </small>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-body">
                        <tr>
                            <th scope="col" class="ps-4 text-secondary small text-uppercase fw-semibold">Dépense</th>
                            <th scope="col" class="text-secondary small text-uppercase fw-semibold">Type</th>
                            <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Montant
                            </th>
                            <th scope="col" class="text-secondary small text-uppercase fw-semibold">Note</th>
                            <th scope="col" class="text-end pe-4 text-secondary small text-uppercase fw-semibold">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                {{-- Libellé --}}
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                            style="width: 36px; height: 36px;">
                                            <i class="bi bi-receipt small"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $expense->label }}</div>
                                            <div class="text-secondary small">#{{ $expense->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Type --}}
                                <td>
                                    @if ($expense->type)
                                        <span class="badge bg-body-tertiary text-body border fw-normal">
                                            {{ $expense->type }}
                                        </span>
                                    @else
                                        <span class="text-secondary">—</span>
                                    @endif
                                </td>

                                {{-- Montant --}}
                                <td class="text-end">
                                    <span class="fw-semibold text-danger-emphasis">
                                        - {{ number_format($expense->amount, 0, ',', ' ') }}
                                        <span class="text-secondary small">Ar</span>
                                    </span>
                                </td>

                                {{-- Note --}}
                                <td>
                                    @if ($expense->note)
                                        <span class="text-secondary d-inline-block text-truncate"
                                            style="max-width: 250px;" title="{{ $expense->note }}">
                                            {{ $expense->note }}
                                        </span>
                                    @else
                                        <span class="text-secondary">—</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-end pe-4">
                                    <div class="" role="group">

                                        {{-- Modifier --}}
                                        <button type="button" class="btn btn-secondary btn-sm" title="Modifier"
                                            data-bs-toggle="modal"
                                            data-bs-target="{{ '#editExpenseModal' . $expense->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        {{-- Supprimer --}}
                                        <form action="{{ route('expense_destroy', $expense) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Voulez-vous vraiment supprimer cette dépense ?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                                @include('expenses.edit_expense', [
                                    'id' => 'editExpenseModal' . $expense->id,
                                    'expense' => $expense,
                                ])
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($expenses->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                    <small class="text-secondary">
                        Affichage de
                        <span class="fw-semibold">{{ $expenses->firstItem() }}</span>
                        à
                        <span class="fw-semibold">{{ $expenses->lastItem() }}</span>
                        sur
                        <span class="fw-semibold">{{ $expenses->total() }}</span>
                        dépenses
                    </small>
                    <div>
                        {{ $expenses->links() }}
                    </div>
                </div>
            @endif

        @endif

    </div>
</div>
