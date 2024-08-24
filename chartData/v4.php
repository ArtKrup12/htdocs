<canvas id="myChart4"></canvas>
<span class="label-text text-light">V4</span>
<script>

    let updateInterval_v4;
    let myChart_v4;

    function updateChart_v4() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'v4'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_v4.data.labels = res.labelloop;
                myChart_v4.data.datasets[0].data = res.dataloop;
                myChart_v4.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    const ctx4 = document.getElementById('myChart4').getContext('2d');
    myChart_v4 = new Chart(ctx4, {
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

    const updateIntervalSeconds_v4 = 3;
    updateInterval_v4 = setInterval(updateChart_v4, updateIntervalSeconds_v4 * 1000);
</script>