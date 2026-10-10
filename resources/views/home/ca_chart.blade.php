    {{-- Carte : Évolution du CA (30 derniers jours) --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            {{-- En-tête de la carte --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h2 class="h6 text-uppercase text-secondary fw-bold mb-1"
                        style="font-size: .7rem; letter-spacing: .5px;">
                        <i class="bi bi-graph-up-arrow me-1"></i>
                        Évolution du chiffre d'affaires
                    </h2>
                    <p class="text-secondary small mb-0">
                        30 derniers jours
                    </p>
                </div>

                {{-- Total de la période (petit badge à droite) --}}
                @php
                    $periodTotal = array_sum($revenueChart['values']);
                @endphp
                <div class="text-end">
                    <div class="text-secondary small">Total période</div>
                    <div class="fw-semibold">
                        {{ number_format($periodTotal, 0, ',', ' ') }} Ar
                    </div>
                </div>
            </div>

            {{-- Graphique --}}
            <div style="position: relative; height: 320px;">
                <canvas id="revenueChart"></canvas>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const canvas = document.getElementById('revenueChart');
                if (!canvas) return;

                const labels = @json($revenueChart['labels']);
                const values = @json($revenueChart['values']);

                const ctx = canvas.getContext('2d');

                // Dégradé vertical sous la courbe
                const gradient = ctx.createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, 'rgba(13, 110, 253, 0.25)');
                gradient.addColorStop(1, 'rgba(13, 110, 253, 0.02)');

                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'CA (Ar)',
                            data: values,
                            borderColor: 'rgb(13, 110, 253)',
                            backgroundColor: gradient,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointRadius: 2,
                            pointHoverRadius: 6,
                            pointBackgroundColor: 'rgb(13, 110, 253)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 1.5,
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
                                callbacks: {
                                    label: (ctx) => {
                                        return ` CA : ${ctx.parsed.y.toLocaleString('fr-FR')} Ar`;
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
                                        size: 11
                                    },
                                    color: '#6c757d',
                                    maxRotation: 0,
                                    autoSkipPadding: 20,
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
                                        // Affichage compact : 15000 → 15k
                                        if (value >= 1000) return (value / 1000) + 'k';
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
