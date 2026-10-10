{{-- Carte : Dernières activités --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0">

        {{-- En-tête de la carte --}}
        <div class="d-flex justify-content-between align-items-center p-4 pb-3">
            <div>
                <h2 class="h6 text-uppercase text-secondary fw-bold mb-1" style="font-size: .7rem; letter-spacing: .5px;">
                    <i class="bi bi-clock-history me-1"></i>
                    Dernières activités
                </h2>
                <p class="text-secondary small mb-0">
                    Les {{ $latestActivities->count() }} dernières ventes enregistrées.
                </p>
            </div>

            @if ($latestActivities->isNotEmpty())
                <a href="{{ route('activities.index') }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center flex-shrink-0">
                    Voir tout
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            @endif
        </div>

        {{-- Tableau ou état vide --}}
        @if ($latestActivities->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-body">
                        <tr>
                            <th scope="col" class="ps-4 text-secondary small text-uppercase fw-semibold">Référence
                            </th>
                            <th scope="col" class="text-secondary small text-uppercase fw-semibold">Client</th>
                            <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Total
                            </th>
                            <th scope="col" class="text-secondary small text-uppercase fw-semibold">Heure</th>
                            <th scope="col" class="text-end pe-4 text-secondary small text-uppercase fw-semibold">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestActivities as $activity)
                            <tr>
                                {{-- Référence --}}
                                <td class="ps-4">
                                    <a href="{{ route('activities.show', $activity) }}"
                                        class="text-decoration-none link-body-emphasis fw-semibold">
                                        {{ $activity->ref }}
                                    </a>
                                </td>

                                {{-- Client --}}
                                <td>
                                    @if ($activity->client)
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                                style="width: 28px; height: 28px;">
                                                <span class="fw-semibold" style="font-size: .7rem;">
                                                    {{ strtoupper(substr($activity->client->firstname, 0, 1) . substr($activity->client->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="text-truncate" style="max-width: 180px;">
                                                {{ $activity->client->firstname }} {{ $activity->client->name }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-secondary fst-italic small">
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

                                {{-- Heure --}}
                                <td>
                                    <div class="d-flex align-items-center text-secondary small">
                                        <i class="bi bi-clock me-1"></i>
                                        @if ($activity->created_at->isToday())
                                            {{ $activity->created_at->format('H:i') }}
                                        @elseif($activity->created_at->isYesterday())
                                            Hier {{ $activity->created_at->format('H:i') }}
                                        @else
                                            {{ $activity->created_at->format('d/m H:i') }}
                                        @endif
                                    </div>
                                </td>

                                {{-- Action --}}
                                <td class="text-end pe-4">
                                    <a href="{{ route('activities.show', $activity) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Voir le détail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt text-secondary" style="font-size: 3rem;"></i>
                <p class="text-secondary mb-1 mt-3">Aucune activité enregistrée.</p>
                <a href="{{ route('activities.create') }}" class="btn btn-sm btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i>
                    Enregistrer une vente
                </a>
            </div>
        @endif

    </div>
</div>
