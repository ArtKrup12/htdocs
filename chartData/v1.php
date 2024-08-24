<canvas id="myChart3"></canvas>
<span class="label-text text-light">V1</span>
<script>
    let updateInterval_v1;
    let myChart_v1;

    function updateChart_v1() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'v1'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_v1.data.labels = res.labelloop;
                myChart_v1.data.datasets[0].data = res.dataloop;
                myChart_v1.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    const ctx3 = document.getElementById('myChart3').getContext('2d');
    myChart_v1 = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'LEAD I',
                data: [0],
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

                    ticks: {
                        display: false
                    },
                    border: {
                        dash: [2, 4],
                    },
                    // grid: {
                    //     color: 'white',
                    //     // drawOnChartArea: false,
                    //     lineWidth: 0.1,
                    //     border: {
                    //         dash: [2, 4],
                    //     },
                    // }
                },
                x: {
                    // display: false,
                    ticks: {
                        display: false
                    },
                    border: {
                        dash: [2, 4],
                    },
                    // grid: {
                    //     color: 'white',
                    //     lineWidth: 0.1,
                    //
                    // }
                }
            }
        }
    });

    const updateIntervalSeconds_v1 = 3;
    updateInterval_v1 = setInterval(updateChart_v1, updateIntervalSeconds_v1 * 1000);
</script>