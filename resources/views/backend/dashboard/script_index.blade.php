{{-- <script src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js') }}"></script> --}}
<script src="{{ asset('assets/js/chart-2.7.0.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-stacked100@1.0.0"></script> --}}

<script>
    // BAR PENJUALAN START
    let data = {
        labels: {!! json_encode($dataBar["penjualan"]["labels"]) !!},
        datasets: [
            {
                label: 'Total in Rp',
                data: {!! json_encode($dataBar["penjualan"]["datas"]) !!},
                // backgroundColor: 'rgba(54, 162, 235, 0.2)',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
            },
        ]
    };
    let options = {
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                gridLines: {
                    offsetGridLines: true
                }
            }],
            yAxes: [{
                ticks: {
                callback: function(value, index, values) {
                    return value.toLocaleString("id-ID",{style:"currency", currency:"IDR", minimumFractionDigits: 0});
                }
                }
            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    return tooltipItem.yLabel.toLocaleString("id-ID",{style:"currency", currency:"IDR",  minimumFractionDigits: 0});
                },
            }
        },
        plugins: [{
            datalabels: {
                color: 'black',
                display: function(context) {
                    console.log("A", context.dataset.data[context.dataIndex]);
                    return context.dataset.data[context.dataIndex] > 1;
                },
                font: {
                weight: 'bold'
                },
                formatter: Math.round
            }
        }],
        animation: {
            duration: 0,
            onComplete: function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        var data = Math.round(dataset.data[index]).toLocaleString("id-ID",{style:"currency", currency:"IDR", minimumFractionDigits: 0});
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
    }
    var ctx = document.getElementById("bar_penjualan").getContext("2d");
    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
    // BAR PENJUALAN END
    // BAR PENJUALAN MONTHLY START
    let data1 = {
        labels: {!! json_encode($dataBarMonthly["penjualan"]["labels"]) !!},
        datasets: [
            {
                label: 'Penjualan',
                data: {!! json_encode($dataBarMonthly["penjualan"]["datas"]) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)',
                //     'rgba(255, 159, 64, 0.2)'
                // ],
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode($dataBarMonthly["pengeluaran"]["datas"]) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)',
                //     'rgba(255, 159, 64, 0.2)'
                // ],
            },
            {
                label: 'Omset',
                data: {!! json_encode($dataBarMonthly["omset"]["datas"]) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                //     'rgba(255, 206, 86, 0.2)',
                //     'rgba(75, 192, 192, 0.2)',
                //     'rgba(153, 102, 255, 0.2)',
                //     'rgba(255, 159, 64, 0.2)'
                // ],
            },
        ]
    };
    var ctx1 = document.getElementById("bar_penjualan_monthly").getContext("2d");
    new Chart(ctx1, {
        type: 'bar',
        data: data1,
        options: options
    });
    //BAR PENJUALAN MONTHLY END
</script>