<?php

use Livewire\Component;
use App\Models\Client;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';

   protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Émet un événement pour transmettre le client sélectionné .
     */
    public function selectClient(int $clientId)
    {
        $client = Client::findOrFail($clientId);

        $this->dispatch(
            'client-selected',
            client: [
                'id' => $client->id,
                'client_number' => $client->client_number,
                'name' => $client->name,
                'firstname' => $client->firstname,
                'phone' => $client->phone,
                'town' => $client->town,
            ],
        );

        // Ferme le modal Bootstrap après sélection
        $this->dispatch('close-modal', id: 'clientListModal');
    }

    public function render()
    {
        $query = Client::orderBy('name', 'ASC');

        if ($this->search) {
            $query = $query->whereLike('name', '%' . $this->search . '%');
        }

        return view('components.activity.client-list', [
            'clients' => $query->paginate(5),
        ]);
    }
};
?>

<div>

    {{-- Barre de recherche --}}
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text bg-body-tertiary border-end-0">
                <i class="bi bi-search text-secondary"></i>
            </span>
            <input type="text" wire:model.live.debounce.400ms="search" class="form-control border-start-0"
                placeholder="Rechercher par nom...">
            @if ($search)
                <button type="button" wire:click="$set('search', '')" class="btn btn-outline-secondary" title="Effacer">
                    <i class="bi bi-x-lg"></i>
                </button>
            @endif
        </div>
        <div wire:loading wire:target="search" class="form-text small">
            <span class="spinner-border spinner-border-sm me-1"></span>
            Recherche...
        </div>
    </div>

    {{-- Liste des clients --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-body">
                <tr>
                    <th scope="col" class="text-secondary small text-uppercase fw-semibold">N° client</th>
                    <th scope="col" class="text-secondary small text-uppercase fw-semibold">Nom</th>
                    <th scope="col" class="text-secondary small text-uppercase fw-semibold">Téléphone</th>
                    <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr wire:key="client-{{ $client->id }}">
                        <td>
                            <span class="badge bg-body-tertiary text-body border fw-normal">
                                {{ $client->client_number }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold">
                                {{ $client->title }} {{ $client->firstname }} {{ $client->name }}
                            </div>
                            @if ($client->town)
                                <div class="text-secondary small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $client->town }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($client->phone)
                                <span class="text-body-emphasis">
                                    <i class="bi bi-telephone text-secondary me-1"></i>
                                    {{ $client->phone }}
                                </span>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button type="button" wire:click="selectClient({{ $client->id }})" data-bs-dismiss="modal"
                                class="btn btn-sm btn-primary d-flex align-items-center ms-auto">
                                <i class="bi bi-check-lg me-1"></i>
                                Sélectionner
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-secondary">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            @if ($search)
                                Aucun client ne correspond à « {{ $search }} ».
                            @else
                                Aucun client enregistré.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($clients->hasPages())
        <div class="my-2">
            {{ $clients->links() }}
        </div>
    @endif

</div>
