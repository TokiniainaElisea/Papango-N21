{{-- Tableau des clients --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">N° client</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Client</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Contact</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Ville</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            {{-- Numéro client --}}
                            <td class="ps-3">
                                <span class="badge bg-body-tertiary text-body border fw-normal">
                                    {{ $client->client_number }}
                                </span>
                            </td>

                            {{-- Nom + prénom + titre --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2"
                                        style="width: 38px; height: 38px;">
                                        <span class="fw-semibold small">
                                            {{ strtoupper(substr($client->firstname, 0, 1) . substr($client->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $client->title }} {{ $client->firstname }} {{ $client->name }}
                                        </div>
                                        <div class="text-secondary small text-truncate" style="max-width: 220px;">
                                            {{ $client->adress }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Téléphone --}}
                            <td>
                                <a href="tel:{{ $client->phone }}"
                                    class="text-decoration-none link-body-emphasis d-flex align-items-center">
                                    <i class="bi bi-telephone text-secondary me-1"></i>
                                    {{ $client->phone }}
                                </a>
                            </td>

                            {{-- Ville --}}
                            <td>
                                <i class="bi bi-geo-alt text-secondary me-1"></i>
                                {{ $client->town }}
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-secondary" title="Modifier"
                                        data-bs-toggle="modal" data-bs-target="{{ '#editClientModal' . $client->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="{{ '#deleteClientModal' . $client->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                @include('clients.parts.delete_client', [
                                    'id' => 'deleteClientModal' . $client->id,
                                    'client' => $client,
                                ])

                                @include('clients.parts.edit_client', [
                                    'id' => 'editClientModal' . $client->id,
                                    'client' => $client,
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucun client trouvé.</p>
                                @if (request()->hasAny(['name', 'firstname', 'client_number', 'phone']))
                                    <a href="{{ route('clients.index') }}" class="small">
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
        @if ($clients->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $clients->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $clients->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $clients->total() }}</span>
                    clients
                </small>
                <div>
                    {{ $clients->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
