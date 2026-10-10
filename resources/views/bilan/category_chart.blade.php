{{-- Carte : Répartition par catégorie --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        {{-- En-tête --}}
        <div class="mb-3">
            <h2 class="h6 text-uppercase text-secondary fw-bold mb-1"
                style="font-size: .7rem; letter-spacing: .5px;">
                <i class="bi bi-tags me-1"></i>
                Répartition par catégorie
            </h2>
            <p class="text-secondary small mb-0">
                Chiffre d'affaires généré par catégorie — {{ $periodLabel }}
            </p>
        </div>

        @if(count($categoryDistribution['labels']) > 0)
            <div style="position: relative; height: 320px;">
                <canvas id="categoryDistributionChart"></canvas>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-pie-chart text-secondary" style="font-size: 3rem;"></i>
                <p class="text-secondary mb-0 mt-3 small">
                    Aucune vente sur cette période.
                </p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('categoryDistributionChart');
        if (!canvas) return;

        const labels = @json($categoryDistribution['labels']);
        const values = @json($categoryDistribution['values']);

        const palette = [
            'rgba(13, 110, 253, 0.75)',
            'rgba(25, 135, 84, 0.75)',
            'rgba(255, 193, 7, 0.75)',
            'rgba(13, 202, 240, 0.75)',
            'rgba(220, 53, 69, 0.75)',
            'rgba(111, 66, 193, 0.75)',
            'rgba(253, 126, 20, 0.75)',
            'rgba(32, 201, 151, 0.75)',
            'rgba(214, 51, 132, 0.75)',
            'rgba(108, 117, 125, 0.75)',
        ];

        const backgroundColors = labels.map((_, i) => palette[i % palette.length]);
        const borderColors     = backgroundColors.map(c => c.replace('0.75', '1'));

        const total = values.reduce((a, b) => a + b, 0);

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
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            padding: 14,
                            font: { size: 12 },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            generateLabels: (chart) => {
                                const data = chart.data;
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    const pct = total > 0
                                        ? ((value / total) * 100).toFixed(1)
                                        : 0;
                                    return {
                                        text: `${label}  (${pct}%)`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        strokeStyle: data.datasets[0].borderColor[i],
                                        lineWidth: 1.5,
                                        pointStyle: 'circle',
                                        hidden: false,
                                        index: i,
                                    };
                                });
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.85)',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 },
                        callbacks: {
                            label: (ctx) => {
                                const value = ctx.parsed;
                                const pct = total > 0
                                    ? ((value / total) * 100).toFixed(1)
                                    : 0;
                                return ` ${value.toLocaleString('fr-FR')} Ar (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush