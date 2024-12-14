<div>
    <!-- Dropdown untuk memilih tahun -->
    <div class="mb-4">
        <label for="tahun" class="block text-sm font-medium text-gray-700">Pilih Tahun:</label>
        <select id="tahun" wire:model="tahun" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @foreach($daftarTahun as $tahunOption)
            <option value="{{ $tahunOption }}">{{ $tahunOption }}</option>
            @endforeach
        </select>
        <p>Tahun yang dipilih: {{ $tahun }}</p>
    </div>

    <button id="loadDataButton" wire:click="loadData">Perbarui Data</button>

    <!-- Elemen Chart -->
    <div class="chart-container mt-4" style="position: relative; height:50vh; width:100%;">
        <div id="chartData"
            data-labels="{{ json_encode(array_keys($data)) }}"
            data-values="{{ json_encode(array_values($data)) }}">
        </div>
        <canvas id="transaksiChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const updateChart = () => {
            const chartData = document.getElementById('chartData');
            const ctx = document.getElementById('transaksiChart')?.getContext('2d');

            const chartContainer = document.querySelector('.chart-container');
            
            const resizeObserver = new ResizeObserver(() => {
                if (window.myChart) {
                    window.myChart.resize();
                }
            });
            resizeObserver.observe(chartContainer);

            if (!chartData || !ctx) {
                console.error('Chart elements not found.');
                return;
            }

            const labels = JSON.parse(chartData.getAttribute('data-labels') || '[]');
            const values = JSON.parse(chartData.getAttribute('data-values') || '[]');

            if (window.myChart) {
                window.myChart.data.labels = labels;
                window.myChart.data.datasets[0].data = values;

                window.myChart.update();
            } else {
                
                window.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Harga Transaksi',
                            data: values,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            tension: 0.1,
                            fill: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                            }
                        },
                    }
                });
            }
        };
        
        const button = document.getElementById('loadDataButton');
        if (button) {
            button.addEventListener('click', () => {
                setTimeout(() => {
                    updateChart();
                }, 500);
            });
        }
        
        updateChart();
    });
</script>