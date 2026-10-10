{{-- Modal de suppression du mouvement #{{ $movement->id }} --}}
<div class="modal fade" id="deleteMovementModal{{ $movement->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('stock-movements.destroy', $movement) }}" method="POST">
                @csrf
                @method('DELETE')

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                        Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">

                    {{-- Résumé du mouvement à supprimer --}}
                    <div class="bg-body-tertiary rounded-3 p-3 mb-3">
                        <div class="row g-2 small">
                            <div class="col-6 text-secondary">Date :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ \Carbon\Carbon::parse($movement->entry_stock)->format('d/m/Y') }}
                            </div>

                            <div class="col-6 text-secondary">Type :</div>
                            <div class="col-6 text-end">
                                @if($movement->movement_type === 'entry')
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                        Entrée
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">
                                        Sortie
                                    </span>
                                @endif
                            </div>

                            <div class="col-6 text-secondary">Quantité :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ number_format($movement->initial_stock, 0, ',', ' ') }} unités
                            </div>

                            <div class="col-6 text-secondary">Prix fournisseur :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ number_format($movement->provider_price, 0, ',', ' ') }} Ar
                            </div>
                        </div>
                    </div>

                    <p class="mb-3">
                        Voulez-vous vraiment supprimer ce mouvement ?
                        Cette action est irréversible.
                    </p>

                    {{-- Avertissement : impact sur le stock --}}
                    <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div class="small">
                            La suppression de ce mouvement <strong>recalculera le stock actuel</strong> :
                            @if($movement->movement_type === 'entry')
                                le stock diminuera de
                                <strong>{{ number_format($movement->initial_stock, 0, ',', ' ') }}</strong>
                                unités.
                            @else
                                le stock augmentera de
                                <strong>{{ number_format($movement->initial_stock, 0, ',', ' ') }}</strong>
                                unités.
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Pied --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Supprimer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>