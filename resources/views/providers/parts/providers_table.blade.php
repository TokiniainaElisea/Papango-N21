{{-- Tableau des fournisseurs --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Fournisseur</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Email</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Téléphone</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Contact</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($providers as $provider)
                        <tr>
                            {{-- Nom du fournisseur --}}
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $provider->name_provider }}</div>
                            </td>

                            {{-- Email --}}
                            <td>
                                @if ($provider->mail)
                                    <a href="mailto:{{ $provider->mail }}"
                                        class="text-decoration-none link-body-emphasis d-flex align-items-center">
                                        <i class="bi bi-envelope text-secondary me-1"></i>
                                        {{ $provider->mail }}
                                    </a>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Téléphone --}}
                            <td>
                                @if ($provider->phone)
                                    <a href="tel:{{ $provider->phone }}"
                                        class="text-decoration-none link-body-emphasis d-flex align-items-center">
                                        <i class="bi bi-telephone text-secondary me-1"></i>
                                        {{ $provider->phone }}
                                    </a>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Contact --}}
                            <td>
                                @if ($provider->name_contact)
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                            style="width: 32px; height: 32px;">
                                            <i class="bi bi-person small"></i>
                                        </div>
                                        <span>{{ $provider->name_contact }}</span>
                                    </div>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('providers.show', $provider) }}" class="btn btn-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-secondary" title="Modifier"
                                        data-bs-toggle="modal" data-bs-target="#editProviderModal{{ $provider->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="#deleteProviderModal{{ $provider->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>

                            @include('providers.parts.edit_provider', [
                                'id' => $provider->id,
                                'provider' => $provider 
                            ])

                            @include('providers.parts.delete_provider', [
                                'id' => $provider->id,
                                'provider' => $provider
                            ])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucun fournisseur trouvé.</p>
                                @if (request()->hasAny(['name_provider', 'mail', 'phone', 'town']))
                                    <a href="{{ route('providers.index') }}" class="small">
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
        @if ($providers->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $providers->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $providers->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $providers->total() }}</span>
                    fournisseurs
                </small>
                <div>
                    {{ $providers->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
