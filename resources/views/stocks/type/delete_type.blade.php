<div class="modal fade" id="deletePaperTypeModal{{ $type->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow text-start">

            <form action="{{ route('types.destroy', $type->id) }}" method="POST">
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
                        Voulez-vous vraiment supprimer le type
                        <strong>{{ $type->name }}</strong> ?
                        Cette action est irréversible.
                    </p>

                    {{-- Avertissement sur les stocks liés --}}
                    <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div class="small">
                            Les papiers associés à ce type
                            <strong>ne seront pas supprimés</strong>, mais perdront leur référence
                            de type. Vous pourrez leur en assigner un nouveau plus tard.
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