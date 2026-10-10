{{-- Carte : Évolution du CA mensuel (année en cours) --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        {{-- En-tête de la carte --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h2 class="h6 text-uppercase text-secondary fw-bold mb-1" style="font-size: .7rem; letter-spacing: .5px;">
                    <i class="bi bi-graph-up-arrow me-1"></i>
                    Évolution du chiffre d'affaires
                </h2>
                <p class="text-secondary small mb-0">
                    Répartition mensuelle — {{ $monthlyRevenue['year'] }}
                </p>
            </div>

            {{-- Total annuel --}}
            <div class="text-end">
                <div class="text-secondary small">Total annuel</div>
                <div class="fw-semibold">
                    {{ number_format($monthlyRevenue['total'], 0, ',', ' ') }} Ar
                </div>
            </div>
        </div>

        {{-- Graphique --}}
        <div style="position: relative; height: 340px;">
            <canvas id="monthlyRevenueChart"></canvas>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('monthlyRevenueChart');
            if (!canvas) return;

            const labels = @json($monthlyRevenue['labels']);
            const values = @json($monthlyRevenue['values']);

            const ctx = canvas.getContext('2d');

            // Dégradé vertical sous la courbe
            const gradient = ctx.createLinearGradient(0, 0, 0, 340);
            gradient.addColorStop(0, 'rgba(25, 135, 84, 0.25)');
            gradient.addColorStop(1, 'rgba(25, 135, 84, 0.02)');

            // Mois courant (pour mettre en évidence le point actuel)
            const currentMonthIndex = {{ now()->month - 1 }};

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'CA (Ar)',
                        data: values,
                        borderColor: 'rgb(25, 135, 84)',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointRadius: (ctx) => {
                            return ctx.dataIndex === currentMonthIndex ? 7 : 3;
                        },
                        pointHoverRadius: 7,
                        pointBackgroundColor: (ctx) => {
                            return ctx.dataIndex === currentMonthIndex ?
                                'rgb(25, 135, 84)' :
                                '#fff';
                        },
                        pointBorderColor: 'rgb(25, 135, 84)',
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                            padding: 12,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                title: (items) => {
                                    // Affiche le nom complet du mois
                                    const fullMonths = [
                                        'Janvier', 'Février', 'Mars', 'Avril',
                                        'Mai', 'Juin', 'Juillet', 'Août',
                                        'Septembre', 'Octobre', 'Novembre', 'Décembre'
                                    ];
                                    return fullMonths[items[0].dataIndex];
                                },
                                label: (ctx) => {
                                    const value = ctx.parsed.y;
                                    return value > 0 ?
                                        ` CA : ${value.toLocaleString('fr-FR')} Ar` :
                                        ' Aucune vente ce mois';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                color: '#6c757d',
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#6c757d',
                                callback: (value) => {
                                    if (value >= 1_000_000) return (value / 1_000_000) + 'M';
                                    if (value >= 1_000) return (value / 1_000) + 'k';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
