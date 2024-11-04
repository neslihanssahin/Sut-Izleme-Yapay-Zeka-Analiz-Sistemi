<?php require_once "sidebar.php"; ?>
<div class="container text-center" style="margin-top: 150px;">
    <div class="row">

        <div class="col-6 col-sm-12">
            <div id="milkgraphic1" ></div>
        </div>

        <div class="w-100 d-none d-md-block"></div>

        <div class="col-6 col-sm-12">
            <div id="milkgraphic2" style="margin-top: 50px;"></div>
        </div>

        <div class="w-100 d-none d-md-block"></div>

        <div class="col-6 col-sm-12">
            <div id="milkgraphic3" style="margin-top: 50px;"></div>
        </div>

    </div>
</div>

<script src="https://code.highcharts.com/es5/highcharts.js"></script>
<?php


    function fetchSQLData($pdo, $sqlQuery, $columnNameDate, $columnNameAmount, $columnDate, $columnAmount)
    {
        $result = $pdo->query($sqlQuery);
        $data = array();

        while ($row = $result->fetch()) {
            $data[] = array(
                $columnNameDate => $row[$columnDate],
                $columnNameAmount => floatval(number_format($row[$columnAmount], 2, '.', ''))
            );
        }
        $dataJSON = json_encode($data);

        return $dataJSON;
    }

    function generateHighcharts($chartId, $chartTitle, $xAxisCategories, $seriesName, $dataJSON, $redirectPage, $color, $backgroundColor)
    {
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let chartId = '<?php echo $chartId; ?>';
                let data = <?php echo $dataJSON; ?>;

                Highcharts.chart(chartId, {
                    accessibility: {
                        enabled: true
                    },
                    chart: {
                        type: 'line',
                        zoomType: 'xy',
                        backgroundColor: '<?php echo $backgroundColor; ?>' // Set the background color here
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: '<?php echo $chartTitle; ?>'
                    },
                    xAxis: {
                        categories: data.map(item => item.<?php echo $xAxisCategories; ?>)
                    },
                    yAxis: {
                        // Your y-axis settings here
                    },

                    series: [{
                        name: '<?php echo $seriesName; ?>',
                        data: data.map(item => ({
                            y: item.<?php echo $seriesName; ?>,
                            date: item.sagim_tarihi
                        })),
                        color: '<?php echo $color; ?>', 
                        events: {
                            click: function(event) {
                                let point = event.point;
                                let dateValue = point.date;
                                window.location.href = '<?php echo $redirectPage; ?>?date=' + dateValue;
                                getDateData(dateValue);

                                console.log("Tarih değeri: " + dateValue);
                            }
                        }
                    }]
                });
            });

            function getDateData(date) {
                let xhr = new XMLHttpRequest();
                xhr.open('GET', '<?php echo $redirectPage; ?>?date=' + date, true);
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var result = JSON.parse(this.responseText);
                    }

                };
                xhr.send();
            }
        </script>
    <?php
    }

    //totalmilk.php SQL SORGUSU DEĞİŞTİ
    $dailyMilk = "SELECT 
    DATE(m.milking_start_time) AS milking_date, 
    SUM(CASE WHEN m.milking_id = 1 THEN m.milk_amount ELSE 0 END) +
    SUM(CASE WHEN m.milking_id = 2 THEN m.milk_amount ELSE 0 END) AS total_milk
    FROM 
    milk m
    GROUP BY 
    DATE(m.milking_start_time);";
    $dailyMilkData = fetchSQLData($pdo, $dailyMilk, 'sagim_tarihi', 'toplam_sut', 'milking_date', 'total_milk');

    $milking1 = "SELECT 
    DATE(m.milking_start_time) AS milking_date, 
    SUM(CASE WHEN m.milking_id = 1 THEN m.milk_amount ELSE 0 END) AS milking1_total
    FROM 
    milk m
    GROUP BY 
    DATE(m.milking_start_time);";
    $milking1Data = fetchSQLData($pdo, $milking1, 'sagim_tarihi', 'sagim1_toplam', 'milking_date', 'milking1_total');

    $milking2 = "SELECT 
    DATE(m.milking_start_time) AS milking_date, 
    SUM(CASE WHEN m.milking_id = 2 THEN m.milk_amount ELSE 0 END) AS milking2_total
    FROM 
    milk m
  
    GROUP BY 
    DATE(m.milking_start_time);";


    $milking2Data = fetchSQLData($pdo, $milking2, 'sagim_tarihi', 'sagim2_toplam', 'milking_date', 'milking2_total');
    // var_dump($milking2Data);

    generateHighcharts('milkgraphic1', 'GÜNLÜK ÜRETİLEN SÜT MİKTARI', 'sagim_tarihi', 'toplam_sut', $dailyMilkData, 'datemilk.php', '#f39c12', '#f9ebc2'); // Set color to orange and background color to a light yellow
    generateHighcharts('milkgraphic2', 'SABAH SAĞIMINDAKİ TOPLAM SÜT MİKTARI', 'sagim_tarihi', 'sagim1_toplam', $milking1Data, 'milking1.php', '#2ecc71', '#d0f0c0'); // Set color to green and background color to a light green
    generateHighcharts('milkgraphic3', 'AKŞAM SAĞIMINDAKİ TOPLAM SÜT MİKTARI', 'sagim_tarihi', 'sagim2_toplam', $milking2Data, 'milking2.php', '#3498db', '#cfe2f3'); // Set color to blue and background color to a light blue
    
    ?>
