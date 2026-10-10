<div class="row g-3 mb-4">

    {{-- CA du jour --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-success-subtle text-success-emphasis d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px;">
                        <i class="bi bi-cash-coin fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        Aujourd'hui
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ number_format($todayRevenue ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">CA du jour (Ar)</div>
            </div>
        </div>
    </div>

    {{-- Nombre de ventes --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px;">
                        <i class="bi bi-receipt fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        Aujourd'hui
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ $todaySalesCount ?? 0 }}
                </div>
                <div class="text-secondary small">Ventes du jour</div>
            </div>
        </div>
    </div>

    {{-- Panier moyen --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-info-subtle text-info-emphasis d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px;">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        Aujourd'hui
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ number_format($todayAverageCart ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">Panier moyen (Ar)</div>
            </div>
        </div>
    </div>

    {{-- Clients du jour --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px;">
                        <i class="bi bi-people fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        Aujourd'hui
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ $todayClientsCount ?? 0 }}
                </div>
                <div class="text-secondary small">Clients servis</div>
            </div>
        </div>
    </div>

    {{-- Stock bas --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px;">
                        <i class="bi bi-exclamation-triangle fs-5"></i>
                    </div>
                    @if(($lowStockCount ?? 0) > 0)
                        <a href="{{ route('stocks.index') }}"
                           class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-normal text-decoration-none small">
                            Voir
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle fw-normal small">
                            OK
                        </span>
                    @endif
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ $lowStockCount ?? 0 }}
                </div>
                <div class="text-secondary small">Papiers en stock bas</div>
            </div>
        </div>
    </div>

</div>

