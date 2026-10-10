@extends('layout')

@section('content')
<div class="container p-">

    {{-- En-tête de navigation --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
            <i class="bi bi-patch-check-fill me-1"></i> Version 1.0.0
        </span>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-12 col-xl-10">

            {{-- Hero Section / Carte Principale --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-body-tertiary">
                <div class="card-body p-4 p-md-5 text-center position-relative">
                    
                    {{-- Logo / Icône avec effet de halo --}}
                    <div class="mb-3 d-inline-block position-relative">
                        <div class="p-3 bg-white rounded-4 shadow-sm border d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <img src="{{ asset('icon.png') }}" alt="Papango N21" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                        </div>
                    </div>

                    <h1 class="display-6 fw-bold  mb-2">Papango N21</h1>
                    <p class="lead text-primary fw-medium mb-3">Solution globale de gestion pour centres multiservices</p>

                    <p class="text-secondary mx-auto mb-4" style="max-width: 680px; font-size: 0.95rem; line-height: 1.6;">
                        Une plateforme complète conçue pour piloter efficacement l'activité au quotidien : de la vente de prestations (impressions, saisie, photocopies) jusqu'au contrôle du stock de papier, du suivi client/fournisseur et de la tenue du bilan financier.
                    </p>

                    {{-- Badges d'aperçu rapide --}}
                    <div class="d-flex flex-wrap justify-content-center gap-2 pt-2">
                        <span class="badge bg-white text-secondary border px-3 py-2 rounded-3 fw-normal">
                            <i class="bi bi-receipt text-primary me-1"></i> Facturation & Ventes
                        </span>
                        <span class="badge bg-white text-secondary border px-3 py-2 rounded-3 fw-normal">
                            <i class="bi bi-box-seam text-primary me-1"></i> Stock Papier FIFO
                        </span>
                        <span class="badge bg-white text-secondary border px-3 py-2 rounded-3 fw-normal">
                            <i class="bi bi-graph-up-arrow text-primary me-1"></i> Bilan & Graphiques
                        </span>
                    </div>

                </div>
            </div>

            {{-- Grille des Fonctionnalités Clés --}}
            <div class="mb-4">
                <h2 class="h6 text-uppercase text-secondary fw-bold mb-3 tracking-wider" style="letter-spacing: 0.8px;">
                    <i class="bi bi-grid-fill me-2 text-primary"></i> Modules & Fonctionnalités
                </h2>

                <div class="row g-3">
                    
                    {{-- Module 1 : Ventes & Services --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <div class="rounded-3 bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="bi bi-journal-text fs-4"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-2">Saisie & Prestations</h3>
                                <p class="text-secondary small mb-0">
                                    Enregistrement rapide des travaux (photocopies, impressions, saisies, tirages). Calcul direct des remises, marges et montants nets.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Module 2 : Factures & Dépenses --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <div class="rounded-3 bg-success-subtle text-success d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="bi bi-file-earmark-spreadsheet fs-4"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-2">Facturation & Dépenses</h3>
                                <p class="text-secondary small mb-0">
                                    Génération instantanée de factures clients, gestion des dépenses courantes et suivi précis de la trésorerie au quotidien.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Module 3 : Stock Papier --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <div class="rounded-3 bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="bi bi-layers fs-4"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-2">Gestion du Stock</h3>
                                <p class="text-secondary small mb-0">
                                    Suivi du papier par format, type et fournisseur. Décrémentation automatique FIFO et alertes de stock critique.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Module 4 : Clients & Fournisseurs --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <div class="rounded-3 bg-info-subtle text-info d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-2">Répertoire Tiers</h3>
                                <p class="text-secondary small mb-0">
                                    Fiches détaillées pour vos clients et fournisseurs avec historique d'achats, coordonnées et solde des comptes.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Module 5 : Dashboard & Bilan --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <div class="rounded-3 bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="bi bi-speedometer2 fs-4"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-2">Dashboard & Bilan</h3>
                                <p class="text-secondary small mb-0">
                                    Indicateurs clés de performance : chiffre d'affaires, panier moyen, récapitulatif des recettes et bilans synthétiques.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Module 6 : Sécurité & Stabilité --}}
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <div class="rounded-3 bg-indigo-subtle text-primary d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="bi bi-shield-check fs-4"></i>
                                </div>
                                <h3 class="h6 fw-bold mb-2">Mode Hors-Ligne & Bureau</h3>
                                <p class="text-secondary small mb-0">
                                    Déploiement en application de bureau autonome garantissant rapidité, confidentialité et continuité de service.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Spécifications Techniques & Crédits --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">

                    <h2 class="h6 text-uppercase text-secondary fw-bold mb-4" style="letter-spacing: 0.8px;">
                        <i class="bi bi-cpu me-2 text-primary"></i> Spécifications & Architecture
                    </h2>

                    <div class="row g-3">

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="p-3 bg-body-tertiary rounded-3 h-100 border-0">
                                <div class="text-secondary small mb-1">Architecture</div>
                                <div class="fw-semibold ">Native Desktop</div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="p-3 bg-body-tertiary rounded-3 h-100 border-0">
                                <div class="text-secondary small mb-1">Compatibilité</div>
                                <div class="fw-semibold ">Windows / Linux</div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="p-3 bg-body-tertiary rounded-3 h-100 border-0">
                                <div class="text-secondary small mb-1">Développeur</div>
                                <div class="fw-semibold ">Tokiniaina</div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="p-3 bg-body-tertiary rounded-3 h-100 border-0">
                                <div class="text-secondary small mb-1">Licence</div>
                                <div class="fw-semibold ">Propriétaire</div>
                            </div>
                        </div>

                    </div>

                    {{-- Badges de la Stack Technique --}}
                    <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="text-secondary small fw-medium">Technologies utilisées :</span>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-body text-body  border"><i class="bi bi-code-square me-1 text-danger"></i> Laravel</span>
                            <span class="badge bg-body text-body  border"><i class="bi bi-lightning-charge me-1 text-warning"></i> Livewire</span>
                            <span class="badge bg-body text-body  border"><i class="bi bi-bootstrap me-1 text-primary"></i> Bootstrap 5</span>
                            <span class="badge bg-body text-body  border"><i class="bi bi-laptop me-1 text-info"></i> NativePHP</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer / Copyright --}}
            <div class="text-center text-secondary small py-2">
                <p class="mb-0">
                    &copy; {{ now()->year }} <strong>Papango N21</strong> — Développé avec passion par <strong>Tokiniaina</strong>.
                </p>
            </div>

        </div>
    </div>

</div>
@endsection