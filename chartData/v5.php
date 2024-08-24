<canvas id="myChart8"></canvas>
<span class="label-text text-light">V5</span>
<script>
    let updateInterval_v5;
    let myChart_v5;

    function updateChart_v5() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'v5'
            },
            success: function(data) {
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_v5.data.labels = res.labelloop;
                myChart_v5.data.datasets[0].data = res.dataloop;
                myChart_v5.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    const ctx8 = document.getElementById('myChart8').getContext('2d');
    myChart_v5 =  new Chart(ctx8, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'LEAD I',
                data: [],
                borderWidth: 1,
                borderColor:borLineColor,
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
    const updateIntervalSeconds_v5 = 3;
    updateInterval_v5 = setInterval(updateChart_v5, updateIntervalSeconds_v5 * 1000);
</script>
