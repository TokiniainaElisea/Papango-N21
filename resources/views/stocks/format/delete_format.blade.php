<div class="modal fade" id="deleteFormatModal{{ $format->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('formats.destroy', $format) }}" method="POST">
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
                        Voulez-vous vraiment supprimer le format
                        <strong>{{ $format->name }}</strong>
                        @if($format->dimension)
                            <span class="text-secondary">({{ $format->dimension }})</span>
                        @endif
                        ?
                        Cette action est irréversible.
                    </p>

                    {{-- Avertissement sur les stocks liés --}}
                    <div class="alert alert-warning d-flex align-items-start mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div class="small">
                            Les papiers associés à ce format
                            <strong>ne seront pas supprimés</strong>, mais perdront leur référence
                            de format. Vous pourrez leur en assigner un nouveau plus tard.
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