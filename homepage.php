<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SİYAS</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php
    require_once "sidebar.php";
    // require_once "database.php";
    function fetchSQLData($pdo, $sqlQuery, $columnNameId, $columnNameNickname, $columnNameAmount, $columnId, $columnNickName, $columnAmount)
    {
        $result = $pdo->query($sqlQuery);
        $data = array();

        while ($row = $result->fetch()) {
            $data[] = array(
                $columnNameId => $row[$columnId],
                $columnNameNickname => $row[$columnNickName],
                $columnNameAmount => floatval(number_format($row[$columnAmount], 2, '.', ''))
            );
        }

        return $data;
    }

    //index.php SQL SORGUSU DEĞİŞTİ
    $milking1 = "SELECT  c.id ,c.ear_tag_number, c.rfid_number, c.nick_name, t.type_name, 
    SUM(CASE WHEN m.milking_id = 1 THEN m.milk_amount ELSE 0 END) AS milk_amount1, 
    SUM(CASE WHEN m.milking_id = 2 THEN m.milk_amount ELSE 0 END) AS milk_amount2
    FROM cattle c
    JOIN milk m ON c.id = m.cattle_id
    JOIN type t ON c.type_id = t.id
    WHERE  DATE_FORMAT(m.milking_stop_time, '%d.%m.%Y') = '01.08.2024'
    GROUP BY  c.id, c.ear_tag_number, c.rfid_number, c.nick_name, t.type_name
    ORDER BY MAX(m.milking_start_time) DESC;";

    $milking1Data = fetchSQLData($pdo, $milking1, 'id', 'takma_ad', 'sagim', 'id', 'nick_name', 'milk_amount1');
    $milking1JSON = json_encode($milking1Data);
    // var_dump($milking1JSON);
    $milking2Data = fetchSQLData($pdo, $milking1, 'id', 'takma_ad', 'sagim', 'id', 'nick_name', 'milk_amount');
    $milking2JSON = json_encode($milking2Data);
    // Sağılan ineklerin dizisi oluştur
    function getMilkedCattle($cattleData)
    {
        return array_filter($cattleData, function ($cattle) {
            return $cattle['sagim'] > 0;
        });
    }

    // Sağılmayan ineklerin dizisi oluştur
    function getUnmilkedCattle($cattleData)
    {
        return array_filter($cattleData, function ($cattle) {
            return $cattle['sagim'] == 0.00;
        });
    }

    // Milking 1 için sağılan ve sağılmayan ineklerin dizilerini oluştur
    $milking1MilkedCattle = array_values(getMilkedCattle($milking1Data));
    $milking1UnmilkedCattle =  array_values(getUnmilkedCattle($milking1Data));

    // Milking 2 için sağılan ve sağılmayan ineklerin dizilerini oluştur
    $milking2MilkedCattle =  array_values(getMilkedCattle($milking2Data));
    $milking2UnmilkedCattle =  array_values(getUnmilkedCattle($milking2Data));



    // Sabah milking1'de en fazla ve en az süt veren ineklerin bulunması
    $sabahEnFazla = null;
    $sabahEnAz = null;
    foreach ($milking1Data as $cattle) {
        if ($cattle['sagim'] > 0) { // Sıfır olmayan değerleri kontrol et
            if ($sabahEnFazla === null || $cattle['sagim'] > $sabahEnFazla['sagim']) {
                $sabahEnFazla = $cattle;
            }
            if ($sabahEnAz === null || $cattle['sagim'] < $sabahEnAz['sagim'] || $sabahEnAz['sagim'] == 0) {
                $sabahEnAz = $cattle;
            }
        }
    }

    // Akşam milking2'de en fazla ve en az süt veren ineklerin bulunması
    $aksamEnFazla = null;
    $aksamEnAz = null;
    foreach ($milking2Data as $cattle) {
        if ($cattle['sagim'] > 0) { // Sıfır olmayan değerleri kontrol et
            if ($aksamEnFazla === null || $cattle['sagim'] > $aksamEnFazla['sagim']) {
                $aksamEnFazla = $cattle;
            }
            if ($aksamEnAz === null || $cattle['sagim'] < $aksamEnAz['sagim'] || $aksamEnAz['sagim'] == 0) {
                $aksamEnAz = $cattle;
            }
        }
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
                            id: item.id // Her veri noktasına cattle_id ekle
                        })),
                        color: '<?php echo $color; ?>',
                        events: {
                            click: function(event) {
                                let cattleId = event.point.id; // Tıklanan noktanın cattle_id değerini al
                                window.location.href = '<?php echo $redirectPage; ?>?cattle_id=' + cattleId; // URL'yi güncelle
                            }
                        }

                    }]
                });
            });
        </script>
    <?php
    }
    generateHighcharts('milkgraphic2', 'SABAH SAĞIMINDAKİ SAĞILAN İNEKLERİN SÜT MİKTARI', 'takma_ad', 'sagim', $milking1JSON, 'onecattlemilk.php', '#FFCF81', '#FDFFAB'); // Set color to green and background color to a light green
    generateHighcharts('milkgraphic3', 'AKŞAM SAĞIMINDAKİ SAĞILAN İNEKLERİN SÜT MİKTARI', 'takma_ad', 'sagim', $milking2JSON, 'onecattlemilk.php', '#3498db', '#cfe2f3'); // Set color to green and background color to a light green

    $sql = "SELECT type.type_name, COUNT(*) AS type_count
            FROM cattle
            INNER JOIN type ON cattle.type_id = type.id
            GROUP BY type.type_name;";
    $result = $pdo->query($sql);
    $data = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row; // Verileri diziye ekliyoruz
    }
    $dataJSON = json_encode($data);
    ?>
    <div class="container text-center" style="margin-top: 150px;">

        <div class="info1">

            <div class="flatgraphic" id="container"></div>

            <div class="text">
                <div class="date">
                    <h5 class="text-center" style=""><?php echo date("d-m-Y") . " Tarihinin Sağım Bilgileri "; ?></h5>

                </div>

                <div class="totalmilk">
                    <div class="col-6 col-sm-3" style="border: 5px solid #007bff; margin: 20px; border-radius: 15px; height: 65px;">
                        <div style="text-align: center;"><b>1. Sağım</b></div>
                        <div style="text-align: center;"></div>
                    </div>
                    <div class="symbol"><b>+</b></div>
                    <div class="col-6 col-sm-3" style="border: 5px solid #007bff; margin: 20px; border-radius: 15px; height: 65px;">
                        <div style="text-align: center;"><b>2. Sağım</b></div>
                        <div style="text-align: center;"></div>
                    </div>
                    <div class="symbol"><b>=</b></div>
                    <div class="col-6 col-sm-3" style="border: 5px solid #007bff; margin: 20px; border-radius: 15px; height: 65px;">
                        <div style="text-align: center;"><b>SONUÇ</b></div>
                        <div style="text-align: center;"></div>
                    </div>
                </div>

                <div class="cattleinfo" id="milking1Info">
                    <p>Sabah sağımında <b>sağılan</b> inek sayısı:
                        <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" onclick="showCattle('morningMilked')">
                            <span id="morningMilkedCount"><?php echo count($milking1MilkedCattle); ?></span> 
                        </a>
                    </p>
                    <p>Sabah sağımında <b>sağılmayan</b> inek sayısı:
                        <span class="cattlelink"></span>
                        <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" onclick="showCattle('morningUnmilked')">
                            <span id="morningUnmilkedCount"><?php echo count($milking1UnmilkedCattle); ?></span> 
                        </a>
                    </p>
                </div>

                <div class="cattleinfo" id="milking2Info">
                    <p>Akşam sağımında <b>sağılan</b> inek sayısı:
                        <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" onclick="showCattle('eveningMilked')">
                            <span id="eveningMilkedCount"><?php echo "0"; ?></span> 
                        </a>
                    </p>
                    <p>Akşam sağımında <b>sağılmayan</b> inek sayısı:
                        <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" onclick="showCattle('eveningUnmilked')">
                            <span id="eveningUnmilkedCount"><?php echo count($milking2UnmilkedCattle); ?></span> 
                        </a>
                    </p>
                </div>


                <!-- Offcanvas Bileşeni -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body" id="cattleList">
                        <!-- Offcanvas içeriği buraya gelecek -->
                    </div>
                </div>


                <div class="milking1">
                    <p>Sabah ki sağımda <b>EN FAZLA</b> süt veren inek :
                        <a class="link" href="https://haytek.mooo.com/sut/onecattlemilk.php?cattle_id=<?php echo $sabahEnFazla['id']; ?>"><?php echo $sabahEnFazla['takma_ad'] . " " . "( " . $sabahEnFazla['sagim'] . " L)"; ?></a>
                    </p>

                    <p>Sabah ki sağımda <b>EN AZ</b> süt veren inek :
                        <a class="link" href="https://haytek.mooo.com/sut/onecattlemilk.php?cattle_id=<?php echo $sabahEnAz['id']; ?>"><?php echo $sabahEnAz['takma_ad'] . " " . "( " . $sabahEnAz['sagim'] . " L)"; ?></a>

                    </p>
                </div>
                <div class="milking2">
                    <p>Akşam ki sağımda <b>EN FAZLA</b> süt veren inek :
                        <!-- <a class="link" href="https://haytek.mooo.com/sut/onecattlemilk.php?cattle_id=<?php echo $aksamEnFazla['id']; ?>"><?php echo $aksamEnFazla['takma_ad'] . " " . "( " . $aksamEnFazla['sagim'] . " L)"; ?></a> -->
                         Akşam sağımı yapılmamıştır

                    </p>
                    <p>Aksam ki sağımda <b>EN AZ</b> süt veren inek :
                        <!-- <a class="link" href="https://haytek.mooo.com/sut/onecattlemilk.php?cattle_id=<?php echo $aksamEnAz['id']; ?>"><?php echo $aksamEnAz['takma_ad'] . " " . "( " . $aksamEnAz['sagim'] . " L)"; ?></a> -->
                        Akşam sağımı yapılmamıştır
                    </p>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="w-100 d-none d-md-block"></div>

            <div class="col-6 col-sm-12">
                <div id="milkgraphic2" style="margin-top: 50px; border-radius: 25px;"></div>
            </div>

            <div class="w-100 d-none d-md-block"></div>

            <div class="col-6 col-sm-12">
                <div id="milkgraphic3" style="margin-top: 50px; border-radius: 25px;"></div>
            </div>

        </div>
    </div>

    <script src="https://code.highcharts.com/es5/highcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script>
        // Sabah ve akşam milking1 ve milking2 verilerini JavaScript nesnelerine dönüştür
        let milking1Data = <?php echo $milking1JSON; ?>;
        let milking2Data = <?php echo $milking2JSON; ?>;
        // milking1 ve milking2 dizilerindeki süt miktarlarını topla
        let milking1Total = milking1Data.reduce((total, current) => total + current.sagim, 0);
        let milking2Total = milking2Data.reduce((total, current) => total + current.sagim, 0);
        let total = milking1Total + milking2Total;

        // HTML'de sonuçları göstermek için ilgili divlere eriş ve değerleri doldur
        document.querySelector('.totalmilk .col-6:nth-child(1) div:nth-child(2)').innerText = milking1Total.toFixed(2)+" "+"L"; // milking1 toplamını doldur
        document.querySelector('.totalmilk .col-6:nth-child(3) div:nth-child(2)').innerText = milking2Total.toFixed(2)+" "+"L"; // milking2 toplamını doldur
        document.querySelector('.totalmilk .col-6:nth-child(5) div:nth-child(2)').innerText = total.toFixed(2)+" "+"L"; // toplam sonucu doldur
        function displayCattle(cattleArray, title) {
            let cattleList = document.getElementById('cattleList');
            let html = '<h5>' + title + '</h5>';
            console.log(cattleArray);

            if (cattleArray.length > 0) {
                html += '<ul>';
                cattleArray.forEach(function(cattle) {
                    html += '<li><a href="onecattlemilk.php?cattle_id=' + cattle.id + '">' + cattle.takma_ad + '</a></li>';
                });
                html += '</ul>';
            } else {
                html += '<p>İnek bulunamadı.</p>';
            }

            cattleList.innerHTML = html;
        }

        function showCattle(type) {
            let title = '';
            let cattleArray = [];

            switch (type) {
                case 'morningMilked':
                    title = 'Sabah Sağılan İnekler';
                    cattleArray = <?php echo json_encode($milking1MilkedCattle); ?>;
                    break;
                case 'morningUnmilked':
                    title = 'Sabah Sağılamayan İnekler';
                    cattleArray = <?php echo json_encode($milking1UnmilkedCattle); ?>;
                    break;
                case 'eveningMilked':
                    title = 'Akşam Sağılan İnekler';
                    cattleArray = <?php echo json_encode($milking2MilkedCattle); ?>;
                    break;
                case 'eveningUnmilked':
                    title = 'Akşam Sağılamayan İnekler';
                    cattleArray = <?php echo json_encode($milking2UnmilkedCattle); ?>;
                    break;
            }

            displayCattle(cattleArray, title);
        }


        // Veri seti
        let data = <?php echo $dataJSON; ?>;

        // Etiketler ve değerler listeleri oluştur
        let labels = [];
        let values = [];

        data.forEach(item => {
            labels.push(item.type_name); // Etiketleri ekle
            values.push(item.type_count); // Değerleri ekle
        });

        // Grafik oluşturma
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Çiftlikde Bulunan İnek Türleri'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Oran',
                colorByPoint: true,
                data: values.map((value, index) => ({
                    name: labels[index],
                    y: value
                }))
            }],

        });


        document.addEventListener('DOMContentLoaded', function() {
            // Tüm cattlelink sınıfına sahip öğeleri seç
            const cattleLinks = document.querySelectorAll('.cattlelink');

            // Her cattlelink öğesine tıklanma olayı ekle
            cattleLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Preview box'u aç
                    const previewBox = document.getElementById('preview-box');
                    previewBox.style.display = 'block';
                });
            });
        });

        function closePreviewBox() {
            // Preview box'u kapat
            const previewBox = document.getElementById('preview-box');
            previewBox.style.display = 'none';
        }
    </script>
</body>

</html>