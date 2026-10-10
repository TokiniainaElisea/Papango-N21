{{-- Tableau des activités --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Référence</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Client</th>
                        <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Total</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Date</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            {{-- Référence --}}
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                         style="width: 36px; height: 36px;">
                                        <i class="bi bi-receipt small"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $activity->ref }}</span>
                                </div>
                            </td>

                            {{-- Client --}}
                            <td>
                                @if($activity->client)
                                    <a href="{{ route('clients.show', $activity->client) }}"
                                       class="text-decoration-none link-body-emphasis d-flex align-items-center">
                                        <i class="bi bi-person text-secondary me-1"></i>
                                        {{ $activity->client->firstname }} {{ $activity->client->name }}
                                    </a>
                                @else
                                    <span class="text-secondary fst-italic">
                                        <i class="bi bi-person-dash me-1"></i>
                                        Client de passage
                                    </span>
                                @endif
                            </td>

                            {{-- Total --}}
                            <td class="text-end">
                                <span class="fw-semibold">
                                    {{ number_format($activity->total_price, 0, ',', ' ') }}
                                </span>
                                <span class="text-secondary small">Ar</span>
                            </td>

                            {{-- Date --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-event text-secondary me-1"></i>
                                    <span>{{ \Carbon\Carbon::parse($activity->sold_at)->format('d/m/Y') }}</span>
                                </div>
                                <div class="text-secondary small">
                                    {{ $activity->created_at?->format('H:i') }}
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <a href="{{ route('activities.show', $activity) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Voir le détail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucune activité trouvée.</p>
                                @if(request()->hasAny(['ref', 'client_name', 'date_from', 'date_to']))
                                    <a href="{{ route('activities.index') }}" class="small">
                                        Réinitialiser les filtres
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($activities->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $activities->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $activities->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $activities->total() }}</span>
                    activités
                </small>
                <div>
                    {{ $activities->links() }}
                </div>
            </div>
        @endif

    </div>
</div>