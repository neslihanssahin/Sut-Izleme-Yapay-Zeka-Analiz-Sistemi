<?php
require_once "sidebar.php";

// cattle_id parametresini alıyoruz
$cattle_id = isset($_GET['cattle_id']) ? $_GET['cattle_id'] : 'Cattle ID belirtilmemiş';

// Veritabanından tarih bilgilerini çek
$sql = "SELECT DISTINCT DATE_FORMAT(milking_start_time, '%d.%m.%Y') AS milking_date 
        FROM milk 
        WHERE cattle_id = :cattle_id
        ORDER BY ABS(DATEDIFF(milking_start_time, CURDATE())) ASC"; // Tarihi bugünün tarihine en yakın olandan en uzağa sırala

$stmt = $pdo->prepare($sql);
$stmt->execute(['cattle_id' => $cattle_id]);
$dateList = $stmt->fetchAll(PDO::FETCH_COLUMN);

// JavaScript'e aktarılacak olan tarih listesini JSON formatına çevir
$dateListJSON = json_encode($dateList);

$sql2 = "SELECT 
            milk_amount1,
            milk_amount2,
            (milk_amount1 + milk_amount2) AS total_amount
        FROM 
            milk 
        WHERE 
            cattle_id = :cattle_id";

//onecattlemilk.php sorgu değişti
$sql="SELECT 
    m.cattle_id,
    DATE(m.milking_start_time) AS milking_date,
    SUM(CASE WHEN m.milking_id = 1 THEN m.milk_amount ELSE 0 END) AS milk_amount1,
    SUM(CASE WHEN m.milking_id = 2 THEN m.milk_amount ELSE 0 END) AS milk_amount2,
    SUM(CASE WHEN m.milking_id = 1 THEN m.milk_amount ELSE 0 END) + 
    SUM(CASE WHEN m.milking_id = 2 THEN m.milk_amount ELSE 0 END) AS total_amount
FROM 
    milk m
WHERE
   cattle_id = :cattle_id
GROUP BY 
    m.cattle_id, DATE(m.milking_start_time)
ORDER BY 
    m.cattle_id, milking_date;
";




$stmt = $pdo->prepare($sql);
$stmt->execute(['cattle_id' => $cattle_id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$milkAmount1Array = [];
$milkAmount2Array = [];
$milkTotalArray = [];

foreach ($result as $row) {
    $milkAmount1Array[] = $row['milk_amount1'];
    $milkAmount2Array[] = $row['milk_amount2'];
    $milkTotalArray[] = $row['total_amount'];
}

// $milkAmount1Array, $milkAmount2Array ve $milkTotalArray şimdi istediğiniz verileri içeriyor



// En büyük ve en küçük değerleri bulun
$maxMilkValue = max($milkTotalArray);
$minMilkValue = min($milkTotalArray);

// En büyük ve en küçük değerlere sahip olan günleri bulun
$maxMilkKey = array_search($maxMilkValue, $milkTotalArray);
$minMilkKey = array_search($minMilkValue, $milkTotalArray);

// En büyük ve en küçük değere sahip olan günlerin tarihlerini alın
$maxMilkDate = $dateList[$maxMilkKey];
$minMilkDate = $dateList[$minMilkKey];

// JavaScript tarafına aktarmak için JSON formatına çevir
$milkAmount1JSON = json_encode($milkAmount1Array);
$milkAmount2JSON = json_encode($milkAmount2Array);
$milkTotalJSON = json_encode($milkTotalArray);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bireysel Süt Takibi </title>

    <!-- Highcharts kütüphanesinin CSS dosyası -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/9.3.1/css/highcharts.min.css">
    <!-- Özel CSS -->
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #container-wrapper {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            /* Yalnızca dikey kaydırma */

        }

        #container {
            width: 100%;
            min-height: 2500px;
            /* İstediğiniz yükseklikte */

        }

        #maxValue {
            margin-bottom: 10px;
            background-color: greenyellow;
            width: 130px;
            height: 50px;
            text-align: center;
            position: fixed;
            top: 40%;
            right: 20px;

        }

        #minValue {
            margin-bottom: 10px;
            background-color: #FAAB78;
            width: 130px;
            height: 50px;
            text-align: center;
            position: fixed;
            top: 50%;
            right: 20px;
        }
    </style>
</head>

<body>

    <!-- Grafik için bir konteyner -->
    <div class="container">
        <div class="row">
            <div class="col-9 col-sm-12">
                <div id="container" style="margin-top: 120px;"></div>
                <!-- Max ve Min değerleri gösteren div'ler -->
                <div id="maxValue"></div>
                <div id="minValue"></div>
            </div>
        </div>
    </div>
    </div>



    <!-- Highcharts kütüphanesinin JS dosyası -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- jQuery kütüphanesinin JS dosyası (Highcharts gereksinimi) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // PHP'den gelen tarih listesini JavaScript tarafına aktar
        var dateList = <?php echo $dateListJSON; ?>;
        var milkAmount1 = <?php echo $milkAmount1JSON; ?>;
        var milkAmount2 = <?php echo $milkAmount2JSON; ?>;
        var milkTotal = <?php echo $milkTotalJSON; ?>;

        // milkAmount1 verilerini döngü ile data1 içine ekleyin
        var seriesData1 = [];
        for (var i = 0; i < milkAmount1.length; i++) {
            seriesData1.push(parseFloat(milkAmount1[i]));
        }

        // milkAmount2 verilerini döngü ile data2 içine ekleyin
        var seriesData2 = [];
        for (var i = 0; i < milkAmount2.length; i++) {
            seriesData2.push(parseFloat(milkAmount2[i]));
        }

        // milkTotal verilerini döngü ile data3 içine ekleyin
        var seriesData3 = [];
        for (var i = 0; i < milkTotal.length; i++) {
            seriesData3.push(parseFloat(milkTotal[i]));
        }

        // Max ve Min değerleri div'lere yazdırın
        document.getElementById("maxValue").innerHTML = "Max: " + <?php echo $maxMilkValue ?> + " litre <br>  Tarih: " + "<?php echo $maxMilkDate ?>";
        document.getElementById("minValue").innerHTML = "Min: " + <?php echo $minMilkValue ?> + " litre <br> Tarih: " + "<?php echo $minMilkDate ?>";

        // Grafik oluşturma kodu
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Bireysel Süt Takip Grafiği',
                align: 'left'
            },
            xAxis: {
                categories: dateList,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                max: 100, // Y ekseni sınırları
                title: {
                    text: 'Sağım Miktarı',
                    align: 'high'
                }
            },
            tooltip: {
                valueSuffix: 'L'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: '1.Sağım',
                data: seriesData1,
                color: '#7cb5ec'
            }, {
                name: '2.Sağım',
                data: seriesData2,
                color: '#90ed7d'
            }, {
                name: 'Toplam (Süt)',
                data: seriesData3,
                color: '#f7a35c'
            }]
        });
    </script>


</body>

</html>