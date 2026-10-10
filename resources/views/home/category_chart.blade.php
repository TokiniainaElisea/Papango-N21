{{-- Carte : Catégories les plus en vogue (ce mois) --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        {{-- En-tête de la carte --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h2 class="h6 text-uppercase text-secondary fw-bold mb-1" style="font-size: .7rem; letter-spacing: .5px;">
                    <i class="bi bi-tags me-1"></i>
                    Catégories les plus en vogue
                </h2>
                <p class="text-secondary small mb-0">
                    Répartition des services vendus — {{ now()->translatedFormat('F Y') }}
                </p>
            </div>
        </div>

        {{-- Graphique ou état vide --}}
        @if (count($categoryChart['labels']) > 0)
            <div style="position: relative; height: 320px;">
                <canvas id="categoryChart"></canvas>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bar-chart text-secondary" style="font-size: 3rem;"></i>
                <p class="text-secondary mb-0 mt-3 small">
                    Aucune vente enregistrée ce mois-ci.
                </p>
            </div>
        @endif

    </div>
</div>

{{-- Chart.js (à inclure une seule fois par page) --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('categoryChart');
            if (!canvas) return;

            const labels = @json($categoryChart['labels']);
            const values = @json($categoryChart['values']);

            // Palette de couleurs (10 teintes, on prend les N premières)
            const palette = [
                'rgba(13, 110, 253, 0.75)', // bleu
                'rgba(25, 135, 84, 0.75)', // vert
                'rgba(255, 193, 7, 0.75)', // jaune
                'rgba(13, 202, 240, 0.75)', // cyan
                'rgba(220, 53, 69, 0.75)', // rouge
                'rgba(111, 66, 193, 0.75)', // violet
                'rgba(253, 126, 20, 0.75)', // orange
                'rgba(32, 201, 151, 0.75)', // teal
                'rgba(214, 51, 132, 0.75)', // rose
                'rgba(108, 117, 125, 0.75)', // gris
            ];

            const backgroundColors = labels.map((_, i) => palette[i % palette.length]);
            const borderColors = backgroundColors.map(c => c.replace('0.75', '1'));

            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1.5,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                boxHeight: 12,
                                padding: 14,
                                font: {
                                    size: 12
                                },
                                usePointStyle: true,
                                pointStyle: 'circle',
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ?
                                        ((ctx.parsed / total) * 100).toFixed(1) :
                                        0;
                                    return ` ${ctx.label} : ${ctx.parsed} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
