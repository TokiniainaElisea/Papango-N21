<div class="modal fade" id="deleteStockModal{{ $stock->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('stocks.destroy', $stock) }}" method="POST">
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

                    <p class="mb-3">
                        Voulez-vous vraiment supprimer 
                        <strong>{{ $stock->label }}</strong> ?
                        Cette action est irréversible.
                    </p>

                    {{-- Résumé du papier --}}
                    <div class="bg-body-tertiary rounded-3 p-3 mb-3">
                        <div class="row g-2 small">
                            <div class="col-6 text-secondary">Type :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $stock->type?->name ?? '—' }}
                            </div>

                            <div class="col-6 text-secondary">Format :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $stock->format?->name ?? '—' }}
                                @if($stock->format?->dimension)
                                    <span class="text-secondary small">({{ $stock->format->dimension }})</span>
                                @endif
                            </div>

                            <div class="col-6 text-secondary">Fournisseur :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $stock->provider?->name_provider ?? '—' }}
                            </div>

                            <div class="col-6 text-secondary">Mouvements :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $stock->stock_movement->count() }}
                            </div>
                        </div>
                    </div>

                    {{-- Avertissement : suppression des mouvements --}}
                    @if($stock->stock_movement->count() > 0)
                        <div class="alert alert-danger d-flex align-items-start mb-0" role="alert">
                            <i class="bi bi-exclamation-octagon-fill me-2 mt-1"></i>
                            <div class="small">
                                <strong>Attention :</strong> cet aricle a
                                <strong>{{ $stock->stock_movement->count() }}</strong>
                                mouvement(s) de stock enregistré(s). En supprimant cet article,
                                <strong>tout son historique de mouvements sera également supprimé</strong>.
                                Cette action ne peut pas être annulée.
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <div class="small">
                                Aucun mouvement enregistré.
                                La suppression n'aura pas d'impact sur l'historique.
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Pied --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Supprimer définitivement
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>