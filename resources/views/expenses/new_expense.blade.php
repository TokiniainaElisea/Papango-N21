@php
    $id;
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="createExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('new_expense') }}" method="POST">
                @csrf

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center" id="createExpenseModalLabel">
                            <i class="bi bi-wallet2 text-primary me-2"></i>
                            Nouvelle dépense
                        </h5>
                        <p class="text-secondary small mb-0">
                            Enregistrez une nouvelle dépense.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Libellé --}}
                        <div class="col-12">
                            <label for="expenseLabel" class="form-label small fw-semibold text-secondary">
                                Libellé <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tag text-secondary"></i>
                                </span>
                                <input type="text"
                                    class="form-control border-start-0 @error('label') is-invalid @enderror"
                                    id="expenseLabel" name="label" value="{{ old('label') }}"
                                    placeholder="Ex : Électricité" required>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Montant --}}
                        <div class="col-12">
                            <label for="expenseAmount" class="form-label small fw-semibold text-secondary">
                                Montant <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-cash-stack text-secondary"></i>
                                </span>
                                <input type="number"
                                    class="form-control border-start-0 @error('amount') is-invalid @enderror"
                                    id="expenseAmount" name="amount" value="{{ old('amount') }}" min="0"
                                    step="1" placeholder="Ex : 50000" required>
                                <span class="input-group-text bg-body-tertiary">Ar</span>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Type --}}
                        <div class="col-12">
                            <label for="expenseType" class="form-label small fw-semibold text-secondary">
                                Type <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-diagram-3 text-secondary"></i>
                                </span>
                                <select class="form-select border-start-0 @error('type') is-invalid @enderror"
                                    id="expenseType" name="type" required>
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
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="col-12">
                            <label for="expenseNote" class="form-label small fw-semibold text-secondary">
                                Note
                                <span class="fw-normal">(optionnel)</span>
                            </label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="expenseNote" name="note" rows="3"
                                placeholder="Ajouter une remarque...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        Enregistrer
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
