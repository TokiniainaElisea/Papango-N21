<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Service</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Format</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Catégorie</th>
                        <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Prix</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            {{-- Nom + couleur --}}
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 {{ $service->color === 'couleur' ? 'bg-info-subtle text-info-emphasis' : 'bg-body-tertiary text-secondary' }} d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                         style="width: 36px; height: 36px;">
                                        <i class="bi bi-tools small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $service->label }}</div>
                                        <div class="small">
                                            @if($service->color === 'couleur')
                                                <span class="text-info-emphasis">
                                                    <i class="bi bi-palette me-1"></i>Couleur
                                                </span>
                                            @elseif ($service->color=='noir')
                                                <span class="text-secondary">
                                                    <i class="bi bi-circle-half me-1"></i>Noir & blanc
                                                </span>
                                            @else
                                                <span class="text-secondary">
                                                    <i class="bi bi-x me-1"></i>{{ $service->color }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Format --}}
                            <td>
                                @if($service->format)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-aspect-ratio me-1"></i>{{ $service->format->name }}
                                    </span>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Catégorie --}}
                            <td>
                                @if($service->category)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-tags me-1"></i>{{ $service->category->name }}
                                    </span>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Prix --}}
                            <td class="text-end">
                                <span class="fw-semibold">
                                    {{ number_format($service->price, 0, ',', ' ') }}
                                </span>
                                <span class="text-secondary small">Ar</span>
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('services.show', $service) }}"
                                       class="btn btn-info"
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-secondary"
                                            title="Modifier"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editServiceModal{{ $service->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-danger"
                                            title="Supprimer"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteServiceModal{{ $service->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            @include('service.delete_service', ['service' => $service])
                            @include('service.edit_service', ['service' => $service])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucun service trouvé.</p>
                                @if(request()->hasAny(['label', 'category_id', 'stock_id']))
                                    <a href="{{ route('services.index') }}" class="small">
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
        @if($services->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $services->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $services->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $services->total() }}</span>
                    services
                </small>
                <div>
                    {{ $services->links() }}
                </div>
            </div>
        @endif

    </div>
</div>