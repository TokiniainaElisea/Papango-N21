{{-- Tableau du stock --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Papier</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Format</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Fournisseur</th>
                        <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Stock</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                        <tr>
                            {{-- Label du papier --}}
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $stock->label }}</div>
                            </td>

                            {{-- Format --}}
                            <td>
                                @if ($stock->format)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-aspect-ratio me-1"></i>{{ $stock->format->name }}
                                    </span>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Fournisseur --}}
                            <td>
                                @if ($stock->provider)
                                    <a href="{{ route('providers.show', $stock->provider) }}"
                                        class="text-decoration-none link-body-emphasis d-flex align-items-center">
                                        <i class="bi bi-truck text-secondary me-1"></i>
                                        {{ $stock->provider->name_provider }}
                                    </a>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Stock total (somme de in_stock) --}}
                            <td class="text-end">
                                @php
                                    $total = $stock->stock_movement->sum('in_stock');
                                @endphp
                                @if ($total > 0)
                                    <span
                                        class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                        <i class="bi bi-box-seam me-1"></i>{{ number_format($total, 0, ',', ' ') }}
                                    </span>
                                @else
                                    <span
                                        class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Rupture
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('stocks.show', $stock) }}" class="btn btn-info"
                                        title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('stocks.edit', $stock) }}" class="btn btn-secondary"
                                        title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="#deleteStockModal{{ $stock->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            @include('stocks.delete_stock', ['stock' => $stock])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucun papier trouvé.</p>
                                @if (request()->hasAny(['label', 'provider_id']))
                                    <a href="{{ route('stocks.index') }}" class="small">
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
        @if ($stocks->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $stocks->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $stocks->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $stocks->total() }}</span>
                    papiers
                </small>
                <div>
                    {{ $stocks->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
