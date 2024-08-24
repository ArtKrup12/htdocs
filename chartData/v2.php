<canvas id="myChart7"></canvas>
<span class="label-text text-light">V2</span>
<script>
    let updateInterval_v2;
    let myChart_v2;

    function updateChart_v2() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'v2'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_v2.data.labels = res.labelloop;
                myChart_v2.data.datasets[0].data = res.dataloop;
                myChart_v2.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    const ctx7 = document.getElementById('myChart7').getContext('2d');
    myChart_v2 = new Chart(ctx7, {
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
    const updateIntervalSeconds_v2 = 3;
    updateInterval_v2 = setInterval(updateChart_v2, updateIntervalSeconds_v2 * 1000);
</script>
