{{-- Modal de suppression du service #{{ $service->id }} --}}
<div class="modal fade" id="deleteServiceModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('services.destroy', $service) }}" method="POST">
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
                        Voulez-vous vraiment supprimer le service
                        <strong>{{ $service->label }}</strong> ?
                        Cette action est irréversible.
                    </p>

                    {{-- Résumé du service --}}
                    <div class="bg-body-tertiary rounded-3 p-3 mb-3">
                        <div class="row g-2 small">
                            <div class="col-6 text-secondary">Catégorie :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $service->category?->name ?? '—' }}
                            </div>

                            <div class="col-6 text-secondary">Couleur :</div>
                            <div class="col-6 text-end fw-semibold">
                                @if($service->color === 'couleur')
                                    Couleur
                                @elseif($service->color === 'non-applicable')
                                    Non applicable
                                @else
                                    Noir & blanc
                                @endif
                            </div>

                            <div class="col-6 text-secondary">Format :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $service->format?->name ?? '—' }}
                            </div>

                            <div class="col-6 text-secondary">Papier :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ $service->stock?->label ?? '—' }}
                            </div>

                            <div class="col-6 text-secondary">Prix :</div>
                            <div class="col-6 text-end fw-semibold">
                                {{ number_format($service->price, 0, ',', ' ') }} Ar
                            </div>
                        </div>
                    </div>

                    {{-- Avertissement --}}
                    <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div class="small">
                            La suppression de ce service est <strong>définitive</strong>.
                            Les ventes déjà enregistrées (si elles existent) ne seront pas
                            impactées, mais vous ne pourrez plus le proposer à vos clients.
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