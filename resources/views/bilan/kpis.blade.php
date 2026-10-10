{{-- KPIs de la période --}}
<div class="row g-3 mb-4">

    {{-- LIGNE 1 : CA, Activités, Panier moyen --}}

    {{-- Chiffre d'affaires --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-success-subtle text-success-emphasis d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-cash-coin fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        {{ $periodLabel }}
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ number_format($revenue ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">Chiffre d'affaires (Ar)</div>
            </div>
        </div>
    </div>

    {{-- Nombre d'activités --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-receipt fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        {{ $periodLabel }}
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ $activitiesCount ?? 0 }}
                </div>
                <div class="text-secondary small">Activités enregistrées</div>
            </div>
        </div>
    </div>

    {{-- Panier moyen --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-info-subtle text-info-emphasis d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        {{ $periodLabel }}
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ number_format($averageCart ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">Panier moyen (Ar)</div>
            </div>
        </div>
    </div>

    {{-- LIGNE 2 : Dépenses, Coûts fournisseur, Bénéfice --}}

    {{-- Total des dépenses --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-danger-subtle text-danger-emphasis d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-wallet2 fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        {{ $periodLabel }}
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ number_format($totalExpenses ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">Dépenses (Ar)</div>
            </div>
        </div>
    </div>

    {{-- Coûts fournisseur (achat de stock) --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-truck fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        {{ $periodLabel }}
                    </span>
                </div>
                <div class="fs-3 fw-bold lh-1 mb-1">
                    {{ number_format($totalProviderCosts ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">Coûts fournisseur (Ar)</div>
            </div>
        </div>
    </div>

    {{-- Bénéfice --}}
    <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="rounded-3 {{ ($profit ?? 0) >= 0 ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }} d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">
                        <i class="bi {{ ($profit ?? 0) >= 0 ? 'bi-graph-up-arrow' : 'bi-graph-down-arrow' }} fs-5"></i>
                    </div>
                    <span class="badge bg-body-tertiary text-secondary border fw-normal small">
                        {{ $periodLabel }}
                    </span>
                </div>
                <div
                    class="fs-3 fw-bold lh-1 mb-1 {{ ($profit ?? 0) >= 0 ? 'text-success-emphasis' : 'text-danger-emphasis' }}">
                    {{ number_format($profit ?? 0, 0, ',', ' ') }}
                </div>
                <div class="text-secondary small">
                    Bénéfice (Ar)
                    @if (($profit ?? 0) < 0)
                        <i class="bi bi-exclamation-triangle-fill text-danger ms-1"
                            title="Les charges dépassent le chiffre d'affaires sur cette période"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
