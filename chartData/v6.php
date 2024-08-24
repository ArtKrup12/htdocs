<canvas id="myChart12"></canvas>
<span class="label-text text-light">V6</span>
<script>
    let updateInterval_v6;
    let myChart_v6;

    function updateChart_v6() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'v6'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_v6.data.labels = res.labelloop;
                myChart_v6.data.datasets[0].data = res.dataloop;
                myChart_v6.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    const ctx12 = document.getElementById('myChart12').getContext('2d');
    myChart_v6 =     new Chart(ctx12, {
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
    const updateIntervalSeconds_v6 = 3;
    updateInterval_v6 = setInterval(updateChart_v6, updateIntervalSeconds_v6 * 1000);
</script>
