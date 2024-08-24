<canvas id="myChart6"></canvas>
<span class="label-text text-light">aVL</span>
<script>
    let updateInterval_avl;
    let myChart_avl;

    function updateChart_avl() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'avl',
                subCase: 'noSelect'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_avl.data.labels = res.labelloop;
                myChart_avl.data.datasets[0].data = res.dataloop;
                myChart_avl.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    const ctx6 = document.getElementById('myChart6').getContext('2d');
    myChart_avl = new Chart(ctx6, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'LEAD I',
                data: [],
                borderWidth: 1,
                borderColor: borLineColor,
                backgroundColor: 'rgba(0, 0, 0, 0.1)',
                tension: 0.2,
                pointRadius: 0
            }]
        },
        options: {
            animation: {
                duration: 0
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    min: 5000000, // ค่าต่ำสุดของแกน Y
                    max: 8500000, // ค่าสูงสุดของแกน Y

                    ticks: {
                        display: false,
                        stepSize: 1000000
                    },
                    border: {
                        // dash: [2, 4],
                    },
                    grid: {
                        color: 'white',
                        // drawOnChartArea: false,
                        lineWidth: 0.1,
                    }
                },
                x: {
                    // display: false,
                    ticks: {
                        display: false
                    },
                    border: {
                        // dash: [2, 4],
                    },
                    grid: {
                        color: function(context) {
                            // console.log(context.tick)
                            // var min = 58;
                            var min = 7;
                            var max = 449;
                            var step = 17;

                            if (context.tick.value >= min && context.tick.value <= max && (context.tick.value - min) % step === 0) {
                                return 'white';
                            } else {
                                return '';
                            }
                            // if ([58, 75, 92, 109, 126, 143, 228, 313, 398].includes(context.tick.value)) {
                            //     return 'white';
                            // } else {
                            //     return '';
                            // }
                        },
                        lineWidth: 0.1,
                    }
                }
            }
        }
    });

    updateInterval_avl = setInterval(updateChart_avl,  250);
</script>
