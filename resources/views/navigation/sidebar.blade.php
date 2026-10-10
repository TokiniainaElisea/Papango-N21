<aside class="row bg-body-tertiary p-1 border border-top-0" style="width: 180px; min-height:100vh;">

    <ul class="nav nav-pills flex-column gap-1">
        <!-- Section Principal -->
        <li class="nav-item">
            <small class="text-uppercase   fw-bold px-3 d-block mt-2 mb-1"
                style="font-size: .7rem; letter-spacing: .5px;">
                Principal
            </small>
        </li>
        <li class="nav-item">
            <a href="{{ route('home.index') }}"
                class=" nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('home*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                Accueil
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('activities.index') }}"
                class=" nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('activities*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-receipt me-2"></i>
                Activités
            </a>
        </li>

        <!-- Section Gestion -->
        <li class="nav-item">
            <small class="text-uppercase   fw-bold px-3 d-block mt-3 mb-1"
                style="font-size: .7rem; letter-spacing: .5px;">
                Gestion
            </small>
        </li>
        <li class="nav-item">
            <a href="{{ route('stocks.index') }}"
                class=" nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('stocks*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-stack me-2"></i>
                Stock
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('services.index') }}"
                class=" nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('services*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-tools me-2"></i>
                Services
            </a>
        </li>

        <!-- Section Finance -->
        <li class="nav-item">
            <small class="text-uppercase   fw-bold px-3 d-block mt-3 mb-1"
                style="font-size: .7rem; letter-spacing: .5px;">
                Finance
            </small>
        </li>
        <li class="nav-item">
            <a href="{{ route('expenses') }}"
                class=" nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('expense*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-coin me-2"></i>
                Dépenses
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bilan.index') }}"
                class=" nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('bilan*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-bar-chart-line me-2"></i>
                Bilan
            </a>
        </li>

        <!-- Section Relations -->
        <li class="nav-item">
            <small class="text-uppercase fw-bold px-3 d-block mt-3 mb-1"
                style="font-size: .7rem; letter-spacing: .5px;">
                Relations
            </small>
        </li>
        <li class="nav-item">
            <a href="{{ route('clients.index') }}"
                class="nav-link text-decoration-none link-body-emphasis d-flex align-items-center rounded-3 {{ request()->routeIs('clients*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-people me-2"></i>
                Clients
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('providers.index') }}"
                class="nav-link text-decoration-none link-body-emphasis text-decoration-none link-body-emphasis  d-flex align-items-center rounded-3 {{ request()->routeIs('providers*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-truck me-2"></i>
                Fournisseurs
            </a>
        </li>
        <!-- Section Autre -->
        <li class="nav-item">
            <small class="text-uppercase fw-bold px-3 d-block mt-3 mb-1"
                style="font-size: .7rem; letter-spacing: .5px;">
                Autre
            </small>
        </li>

        <li class="nav-item">
            <a href="{{ route('preferences.about') }}"
                class="nav-link text-decoration-none link-body-emphasis text-decoration-none link-body-emphasis  d-flex align-items-center rounded-3 {{ request()->routeIs('preferences*') ? 'active bg-primary' : '' }}">
                <i class="bi bi-info-circle me-2"></i>
                À propos
            </a>

        </li>

        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link text-decoration-none link-body-emphasis text-decoration-none link-body-emphasis  d-flex align-items-center rounded-3">
                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                </button>
            </form>
        </li>
    </ul>

</aside>
