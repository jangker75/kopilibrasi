<script src="{{ asset('assets/js/chart-2.7.0.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/chartjs-plugin-datalabels.min.js') }}"></script> --}}
<script>
    // BAR PENJUALAN START
    let data = {
        labels: {!! json_encode($dataBar["penjualan"]["labels"]) !!},
        datasets: [{
            label: 'Total in Rp',
            data: {!! json_encode($dataBar["penjualan"]["datas"]) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            // borderColor: [
            //     'rgba(255,99,132,1)',
            //     'rgba(54, 162, 235, 1)',
            //     'rgba(255, 206, 86, 1)',
            //     'rgba(75, 192, 192, 1)',
            //     'rgba(153, 102, 255, 1)',
            //     'rgba(255, 159, 64, 1)'
            // ],
            // borderWidth: 1
        }]
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
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
    // BAR PENJUALAN END
</script>