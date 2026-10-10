<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Impression')</title>

    {{-- Bootstrap --}}
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            background: #f8f9fa;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            font-size: 14px;
            color: #212529;
            padding: 30px 15px;
        }

        /* Feuille A4 simulée à l'écran */
        .invoice-sheet {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 45px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
            border-radius: 4px;
        }

        /* En-tête facture */
        .invoice-header {
            border-bottom: 2px solid #212529;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .invoice-brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .invoice-ref {
            font-size: 26px;
            font-weight: 700;
            color: #0d6efd;
        }

        /* Sections */
        .section-title {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 10px;
        }

        /* Tableau */
        .invoice-table th {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 8px;
        }

        .invoice-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        /* Totaux */
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .total-row.grand-total {
            border-top: 2px solid #212529;
            margin-top: 10px;
            padding-top: 14px;
            font-size: 1.25rem;
            font-weight: 700;
        }

        /* Barre d'actions (masquée à l'impression) */
        .actions-bar {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        /* Impression */
        @media print {
            body {
                background: white;
                padding: 0;
                font-size: 12px;
            }

            .invoice-sheet {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
                padding: 20px 25px;
            }

            .actions-bar,
            .no-print {
                display: none !important;
            }

            .invoice-ref {
                color: #000 !important;
            }

            .invoice-table th {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tr {
                page-break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 15mm;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- Barre d'actions (non imprimée) --}}
    <div class="actions-bar">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>

        <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" onclick="window.print()">
            <i class="bi bi-printer me-1"></i>
            Imprimer
        </button>
    </div>

    <div class="invoice-sheet">

        {{-- ============================================================ --}}
        {{-- EN-TÊTE --}}
        {{-- ============================================================ --}}
        <div class="invoice-header d-flex justify-content-between align-items-start">
            <div>
                <div class="invoice-brand">
                    <i class="bi bi-grid-1x2-fill text-primary me-2"></i>
                    Manda Service Copie
                </div>
            </div>

            <div class="text-end">
                <div class="section-title mb-1">Facture</div>
                <div class="invoice-ref">{{ $activity->ref }}</div>
                <div class="text-secondary small mt-1">
                    Date :
                    <strong>{{ \Carbon\Carbon::parse($activity->sold_at)->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- INFOS CLIENT + PAIEMENT --}}
        {{-- ============================================================ --}}
        <div class="row mb-4">
            {{-- Client --}}
            <div class="col-7">
                <div class="section-title">Client</div>

                @if ($activity->client)
                    <div class="fw-semibold">
                        {{ $activity->client->title }}
                        {{ $activity->client->firstname }}
                        {{ $activity->client->name }}
                    </div>
                    <div class="text-secondary small">
                        N° {{ $activity->client->client_number }}
                    </div>
                    @if ($activity->client->phone)
                        <div class="text-secondary small">
                            <i class="bi bi-telephone me-1"></i>{{ $activity->client->phone }}
                        </div>
                    @endif
                    @if ($activity->client->adress)
                        <div class="text-secondary small">
                            <i class="bi bi-house me-1"></i>{{ $activity->client->adress }}
                            @if ($activity->client->town)
                                , {{ $activity->client->town }}
                            @endif
                        </div>
                    @elseif($activity->client->town)
                        <div class="text-secondary small">
                            <i class="bi bi-geo-alt me-1"></i>{{ $activity->client->town }}
                        </div>
                    @endif
                @else
                    <div class="fw-semibold">Client de passage</div>
                    <div class="text-secondary small">Aucune fiche client associée</div>
                @endif
            </div>

            {{-- Paiement --}}
            <div class="col-5 text-end">
                <div class="section-title">Mode de paiement</div>
                @php
                    $paymentLabels = [
                        'espece' => 'Espèces',
                        'mvola' => 'MVola',
                        'airtel_money' => 'Airtel Money',
                        'orange_money' => 'Orange Money',
                    ];
                @endphp
                <div class="fw-semibold">
                    {{ $paymentLabels[$activity->payment_method] ?? '—' }}
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TABLEAU DES PRESTATIONS --}}
        {{-- ============================================================ --}}
        <div class="section-title">Détail des prestations</div>

        <table class="table invoice-table mb-4">
            <thead>
                <tr>
                    <th>Service</th>
                    <th class="text-end">Prix unit.</th>
                    <th class="text-center">Qté</th>
                    <th class="text-end">Remise</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activity->details as $detail)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $detail->service_label }}</div>
                            @if ($detail->service?->format)
                                <div class="text-secondary" style="font-size: .75rem;">
                                    <i class="bi bi-aspect-ratio me-1"></i>{{ $detail->service->format->name }}
                                    @if ($detail->service->format->dimension)
                                        ({{ $detail->service->format->dimension }})
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="text-end">{{ number_format($detail->unit_price, 0, ',', ' ') }} Ar</td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-end">
                            @if ($detail->discount > 0)
                                <span class="text-warning">-{{ number_format($detail->discount, 0) }}%</span>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold">
                            {{ number_format($detail->total_line, 0, ',', ' ') }} Ar
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ============================================================ --}}
        {{-- TOTAUX --}}
        {{-- ============================================================ --}}
        <div class="row justify-content-end">
            <div class="col-12 col-md-6">
                @php
                    $subtotal = $activity->details->sum(fn($d) => $d->unit_price * $d->quantity);
                    $totalDiscount = $subtotal - $activity->total_price;
                @endphp

                <div class="total-row">
                    <span class="text-secondary">Sous-total</span>
                    <span class="fw-semibold">{{ number_format($subtotal, 0, ',', ' ') }} Ar</span>
                </div>

                @if ($totalDiscount > 0)
                    <div class="total-row">
                        <span class="text-secondary">Remises</span>
                        <span class="fw-semibold text-warning">
                            - {{ number_format($totalDiscount, 0, ',', ' ') }} Ar
                        </span>
                    </div>
                @endif

                <div class="total-row grand-total">
                    <span>Total</span>
                    <span>{{ number_format($activity->total_price, 0, ',', ' ') }} Ar</span>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- PAPIER CONSOMMÉ --}}
        {{-- ============================================================ --}}
        @php
            $paperConsumption = [];
            foreach ($activity->details as $detail) {
                $stock = $detail->service?->stock;
                if (!$stock) {
                    continue;
                }

                if (!isset($paperConsumption[$stock->id])) {
                    $paperConsumption[$stock->id] = [
                        'label' => $stock->label,
                        'format' => $stock->format?->name,
                        'quantity' => 0,
                    ];
                }
                $paperConsumption[$stock->id]['quantity'] += $detail->quantity;
            }
        @endphp

        {{-- ============================================================ --}}
        {{-- NOTE --}}
        {{-- ============================================================ --}}
        @if ($activity->note)
            <div class="mt-4 pt-3 border-top">
                <div class="section-title">Note</div>
                <p class="mb-0 small" style="white-space: pre-line;">{{ $activity->note }}</p>
            </div>
        @endif

        {{-- ============================================================ --}}
        {{-- PIED DE PAGE --}}
        {{-- ============================================================ --}}
        <div class="mt-5 pt-4 border-top text-center text-secondary small">
            <div>
                Merci de votre confiance.
            </div>
            <div class="mt-1">
                Document généré le {{ now()->format('d/m/Y à H:i') }}
            </div>
        </div>

    </div>

</body>

</html>
