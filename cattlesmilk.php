<?php
require_once "sidebar.php";
///cattlesmilk.php sql değiştirildi
$sql = "SELECT 
    c.id AS cattle_id, 
    c.ear_tag_number, 
    c.rfid_number, 
    c.nick_name, 
    c.date_of_birth,
    t.type_name AS type_name,
    AVG(m.milk_amount) AS ortmilk
FROM 
    cattle c
LEFT JOIN 
    milk m ON c.id = m.cattle_id
JOIN 
    type t ON c.type_id = t.id
GROUP BY 
    c.id
ORDER BY 
    ortmilk DESC;
";
$result = $pdo->query($sql);
$data = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
  $data[] = $row; // Verileri diziye ekliyoruz
}
$dataJSON = json_encode($data);
?>
<script src="https://code.highcharts.com/es5/highcharts.js"></script>

<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-9 col-sm-12">
      <div id="cattle" style="height:1800px;">
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    let chartId = 'cattle';
    let data = <?php echo $dataJSON; ?>;

    Highcharts.chart(chartId, {
      accessibility: {
        enabled: true
      },
      chart: {
        type: 'bar', 
        zoomType: 'xy',
      },
      credits: {
        enabled: false
      },
      title: {
        text: 'Ortalama Süt Miktarı ve Küpe Numarası' 
      },
      xAxis: {
        categories: data.map(item =>  item.nick_name ) 
      },
      yAxis: {
        title: {
          text: 'Ortalama Süt Miktarı' 
        }
      },
      plotOptions: {
        bar: {
          pointWidth: 30,
          pointPadding: 0.1,
          groupPadding: 0.2,
          events: {
            click: function(event) {
              // Tıklanan çubunun indeksini alın
              let index = event.point.index;
              // Veriden cattle_id değerini alın
              let cattleId = data[index].cattle_id;
              window.location.href = 'onecattlemilk.php?cattle_id=' + cattleId;
            }
          }
        }
      },

      series: [{
        name: 'Ortalama Süt Miktarı', // Seri adı değiştirildi
        data: data.map(item => parseFloat(item.ortmilk)), // Veri alımı değiştirildi
        color: '#7cb5ec' // Renk eklendi
      },
    ]
    });
  });
</script>