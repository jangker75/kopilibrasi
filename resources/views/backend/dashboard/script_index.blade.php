<script src="{{ asset('assets/js/chart-2.7.0.min.js') }}"></script>
<script>
    const randomNum = () => Math.floor(Math.random() * (235 - 52 + 1) + 52);
    const randomRGB = () => `rgba(${randomNum()}, ${randomNum()}, ${randomNum()}, 0.5)`;

    // BAR PENJUALAN START
    const bgColorData = (length) => {
        let listColor = []
        for (let i = 0; i < length; i++) {
            listColor.push(randomRGB())          
        }
        return listColor
    }
    let lengthData = {!! json_encode($dataBar["penjualan"]["labels"]) !!}.length
    let colorPenjualan = bgColorData(lengthData)
    
    let data = {
        labels: {!! json_encode($dataBar["penjualan"]["labels"]) !!},
        datasets: [
            {
                label: 'Penjualan',
                data: {!! json_encode($dataBar["penjualan"]["datas"]) !!},
                backgroundColor: colorPenjualan,
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
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode($dataBarMonthly["pengeluaran"]["datas"]) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
            },
            {
                label: 'Omset',
                data: {!! json_encode($dataBarMonthly["omset"]["datas"]) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
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

    //DOUGHNUT CHART START
    lengthData = {!! json_encode($dataPie["penjualan"]["datas"]) !!}.length
    var colors = bgColorData(lengthData)
    console.log(colors);
    $(".boxc").each(function(idx, obj){
        $(obj).css("background-color", colors[idx])
    })
    var dataDougnut = {
        datasets: [{
            data: {!! json_encode($dataPie["penjualan"]["datas"]) !!},
            backgroundColor: colors,
            borderColor: colors,
            borderWidth: 1,
            hoverBorderWidth: 5,
        }],
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: {!! json_encode($dataPie["penjualan"]["labels"]) !!}
    };
    var optionsDoughnut = {
        legend: {
            display: false,
        },
        segmentShowStroke: true,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 1,
        percentageInnerCutout: 50, // This is 0 for Pie charts
        animationSteps: 100,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            animateScale : true,
        },
    }
    var ctx1 = document.getElementById("doughnut_penjualan_item").getContext("2d");
    new Chart(ctx1, {
        type: 'doughnut',
        data: dataDougnut,
        options: optionsDoughnut
    });
    //DOUGHNUT CHART END
</script>