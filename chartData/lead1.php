<canvas id="myChart1"></canvas>
<span class="label-text text-light">LEAD I</span>
<script>
    let updateInterval_lead1;
    let myChart_lead1;
    // Function สำหรับดึงข้อมูลและอัปเดตแผนภูมิ
    function updateChart_lead1() {
        $.ajax({
            url: '/api/getData.php',
            method: 'POST',
            data:{
                case:'lead1',
                subCase: 'noSelect'
            },
            success: function(data) {
                // ปรับปรุงข้อมูลแผนภูมิ
                let res = JSON.parse(data)
                // console.log(res.labelloop)
                myChart_lead1.data.labels = res.labelloop; // x axis
                myChart_lead1.data.datasets[0].data = res.dataloop; // y axis
                myChart_lead1.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }


    const ctx1 = document.getElementById('myChart1').getContext('2d');
    // const borLineColor = '#BD242A'
    myChart_lead1 =  new Chart(ctx1, {
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

    updateInterval_lead1 = setInterval(updateChart_lead1, 250);
</script>
