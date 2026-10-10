@php
    $id;
    $expense;
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            {{-- En-tête --}}
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title d-flex align-items-center" id="editExpenseModalLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Modifier la dépense
                    </h5>
                    <p class="text-secondary small mb-0">
                        Modifiez les informations de cette dépense.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            {{-- Formulaire --}}
            <form id="editExpenseForm" method="POST" action="{{ route('update_expense', $expense) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Libellé --}}
                        <div class="col-12">
                            <label for="editExpenseLabel" class="form-label small fw-semibold text-secondary">
                                Libellé <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tag text-secondary"></i>
                                </span>
                                <input type="text" value="{{ $expense->label }}" class="form-control border-start-0"
                                    id="editExpenseLabel" name="label" required>
                            </div>
                        </div>

                        {{-- Montant --}}
                        <div class="col-12">
                            <label for="editExpenseAmount" class="form-label small fw-semibold text-secondary">
                                Montant <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-cash-stack text-secondary"></i>
                                </span>
                                <input type="number" class="form-control border-start-0" id="editExpenseAmount"
                                    name="amount" min="0" step="1" required
                                    value="{{ $expense->amount }}">
                                <span class="input-group-text bg-body-tertiary">Ar</span>
                            </div>
                        </div>

                        {{-- Type --}}
                        <div class="col-12">
                            <label for="editExpenseType" class="form-label small fw-semibold text-secondary">
                                Type <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-diagram-3 text-secondary"></i>
                                </span>
                                <select class="form-select border-start-0" id="editExpenseType" name="type" required>

                                    <option value="{{ $expense->type }}">
                                        {{ $expense->type }}
                                    </option>
                                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>
                                        Sélectionner un type
                                    </option>

                                    <option value="Salaire" {{ old('type') == 'Salaire' ? 'selected' : '' }}>
                                        Salaire
                                    </option>

                                    <option value="Transport" {{ old('type') == 'Transport' ? 'selected' : '' }}>
                                        Transport
                                    </option>

                                    <option value="Jirama" {{ old('type') == 'Jirama' ? 'selected' : '' }}>
                                        Jirama
                                    </option>

                                    <option value="Internet" {{ old('type') == 'Internet' ? 'selected' : '' }}>
                                        Internet
                                    </option>

                                    <option value="Loyer" {{ old('type') == 'Loyer' ? 'selected' : '' }}>
                                        Loyer
                                    </option>

                                    <option value="IRSA" {{ old('type') == 'IRSA' ? 'selected' : '' }}>
                                        IRSA
                                    </option>

                                    <option value="Autre" {{ old('type') == 'Autre' ? 'selected' : '' }}>
                                        Autre
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="col-12">
                            <label for="editExpenseNote" class="form-label small fw-semibold text-secondary">
                                Note
                                <span class="fw-normal">(optionnel)</span>
                            </label>
                            <textarea class="form-control" id="editExpenseNote" name="note" rows="3" placeholder="Ajouter une remarque...">{{ $expense->note }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Pied --}}
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-check-lg me-1"></i>
                        Enregistrer les modifications
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
