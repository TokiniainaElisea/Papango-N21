<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public ?array $selectedClient = null;

    #[On('client-selected')]
    public function selectClient(array $client): void
    {
        $this->selectedClient = $client;
    }

    public function cancelClient(): void
    {
        $this->selectedClient = null;
    }
};
?>

<div>


    {{-- SECTION 1 : CLIENT --}}

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-body-tertiary d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h2 class="h6 text-uppercase text-secondary fw-bold mb-0" style="font-size: .7rem; letter-spacing: .5px;">
                <i class="bi bi-person-vcard me-1"></i>
                Client
            </h2>

            <div class="d-flex gap-2">
                @if (!$selectedClient)
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#clientListModal">
                        <i class="bi bi-person-check me-1"></i>
                        Sélectionner un client
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#createClientModal">
                        <i class="bi bi-person-plus me-1"></i>
                        Nouveau client
                    </button>
                @else
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Client sélectionné
                    </span>
                @endif
            </div>
        </div>

        <div class="card-body">
            @if ($selectedClient)
                <div class="row g-3 align-items-center">
                    <div class="col-md-2">
                        <small class="text-secondary d-block">N° client</small>
                        <strong>{{ $selectedClient['client_number'] ?? '—' }}</strong>
                    </div>
                    <div class="col-md-2">
                        <small class="text-secondary d-block">Nom</small>
                        <strong>{{ $selectedClient['name'] ?? '' }}</strong>
                    </div>
                    <div class="col-md-2">
                        <small class="text-secondary d-block">Prénom</small>
                        <strong>{{ $selectedClient['firstname'] ?? '' }}</strong>
                    </div>
                    <div class="col-md-2">
                        <small class="text-secondary d-block">Téléphone</small>
                        <span>{{ $selectedClient['phone'] ?: '—' }}</span>
                    </div>
                    <div class="col-md-2">
                        <small class="text-secondary d-block">Ville</small>
                        <span>{{ $selectedClient['town'] ?: '—' }}</span>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" wire:click="cancelClient" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-person-x me-1"></i>
                            Retirer
                        </button>
                    </div>
                </div>
            @else
                <div class="text-center py-3">
                    <i class="bi bi-person-exclamation text-warning fs-2 d-block mb-2"></i>
                    <strong class="d-block">Aucun client sélectionné</strong>
                    <small class="text-secondary">
                        Sélectionnez un client ou créez-en un nouveau pour continuer.
                    </small>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal : liste des clients --}}
    <div class="modal fade" id="clientListModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-people text-primary me-2"></i>
                        Sélectionner un client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <livewire:activity.client-list />
                </div>
            </div>
        </div>
    </div>

    {{-- Modal : nouveau client --}}
    @include('clients.parts.new_client')


    {{-- SECTION 2 : SERVICES + PANIER --}}

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-body-tertiary">
            <h2 class="h6 text-uppercase text-secondary fw-bold mb-0" style="font-size: .7rem; letter-spacing: .5px;">
                <i class="bi bi-tools me-1"></i>
                Prestations
            </h2>
        </div>
        <div class="card-body">
            <div class="row g-4">

                {{-- Liste des services disponibles --}}
                <div class="col-12 col-lg-4">
                    <div class="card border h-100">
                        <div class="card-header bg-body-tertiary">
                            <h3 class="h6 fw-bold mb-0 d-flex align-items-center">
                                <i class="bi bi-search me-2 text-primary"></i>
                                Services disponibles
                            </h3>
                        </div>
                        <div class="card-body p-3">
                            <livewire:activity.service-list />
                        </div>
                    </div>
                </div>

                {{-- Panier + Formulaire de validation --}}
                <div class="col-12 col-lg-8">
                    <div class="card border h-100">
                        <div class="card-header bg-body-tertiary d-flex justify-content-between align-items-center">
                            <h3 class="h6 fw-bold mb-0 d-flex align-items-center">
                                <i class="bi bi-cart3 me-2 text-success"></i>
                                Panier
                            </h3>
                            <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                <i class="bi bi-cart-check me-1"></i>
                                Vente en cours
                            </span>
                        </div>
                        <div class="card-body">
                            <livewire:activity.cart-list :selected-client="$selectedClient" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
