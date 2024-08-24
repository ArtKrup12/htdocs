<canvas id="myChart5"></canvas>
<span class="label-text text-light">LEAD II</span>
<script>

    let updateInterval_lead2;
    let myChart_lead2;

    function updateChart_lead2() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'lead2',
                subCase: 'noSelect'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_lead2.data.labels = res.labelloop;
                myChart_lead2.data.datasets[0].data = res.dataloop;
                myChart_lead2.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    const ctx5 = document.getElementById('myChart5').getContext('2d');
    myChart_lead2 = new Chart(ctx5, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'LEAD II',
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
                    min: 11000000, // ค่าต่ำสุดของแกน Y
                    max: 14500000, // ค่าสูงสุดของแกน Y

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

    updateInterval_lead2 = setInterval(updateChart_lead2,250);
</script>