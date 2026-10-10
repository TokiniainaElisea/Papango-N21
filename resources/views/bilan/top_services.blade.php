{{-- Carte : Top services --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0">

        {{-- En-tête --}}
        <div class="p-4 pb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="h6 text-uppercase text-secondary fw-bold mb-1" style="font-size: .7rem; letter-spacing: .5px;">
                    <i class="bi bi-trophy me-1"></i>
                    Top services
                </h2>
                <p class="text-secondary small mb-0">
                    Les prestations les plus rentables — {{ $periodLabel }}
                </p>
            </div>
        </div>

        @if ($topServices->isNotEmpty())
            @php
                $maxRevenue = $topServices->sum('total_revenue');
            @endphp

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-body">
                        <tr>
                            <th scope="col" class="ps-4 text-secondary small text-uppercase fw-semibold"
                                style="width: 40px;">#</th>
                            <th scope="col" class="text-secondary small text-uppercase fw-semibold">Service</th>
                            <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Quantité
                            </th>
                            <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">CA</th>
                            <th scope="col" class="text-end pe-4 text-secondary small text-uppercase fw-semibold"
                                style="width: 200px;">Part</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topServices as $index => $service)
                            <tr>
                                {{-- Rang --}}
                                <td class="ps-4">
                                    @if ($index === 0)
                                        <span
                                            class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-bold"
                                            style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            1
                                        </span>
                                    @elseif($index === 1)
                                        <span class="badge bg-body-tertiary text-body border fw-bold"
                                            style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            2
                                        </span>
                                    @elseif($index === 2)
                                        <span class="badge bg-body-tertiary text-body border fw-bold"
                                            style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;">
                                            3
                                        </span>
                                    @else
                                        <span class="text-secondary fw-semibold small ps-2">
                                            {{ $index + 1 }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Service --}}
                                <td>
                                    <div class="fw-semibold">{{ $service->service_label }}</div>
                                    @if ($service->service_id)
                                        <div class="small">
                                            <a href="{{ route('services.show', $service->service_id) }}"
                                                class="text-decoration-none link-secondary">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>
                                                Voir le service
                                            </a>
                                        </div>
                                    @endif
                                </td>

                                {{-- Quantité --}}
                                <td class="text-end">
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        {{ number_format($service->total_quantity, 0, ',', ' ') }} vendus
                                    </span>
                                </td>

                                {{-- CA --}}
                                <td class="text-end fw-semibold">
                                    {{ number_format($service->total_revenue, 0, ',', ' ') }}
                                    <span class="text-secondary small">Ar</span>
                                </td>

                                {{-- Barre de part --}}
                                <td class="text-end pe-4">
                                    @php
                                        $percent = $maxRevenue > 0 ? ($service->total_revenue / $maxRevenue) * 100 : 0;
                                    @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"
                                                aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="text-secondary small" style="min-width: 42px; text-align: right;">
                                            {{ number_format($percent, 0) }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-trophy text-secondary" style="font-size: 3rem;"></i>
                <p class="text-secondary mb-0 mt-3 small">
                    Aucune vente sur cette période.
                </p>
            </div>
        @endif

    </div>
</div>
