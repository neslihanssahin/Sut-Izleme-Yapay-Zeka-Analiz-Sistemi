<?php
require_once "sidebar.php";
$selectedDate = $_GET['date'];

//milking2.php SQL SORGUSU DEĞİŞTİ

$sql = "SELECT 
    c.id AS cattle_id, -- Hayvanın ID'si
    c.ear_tag_number AS ear_tag_number, -- Hayvanın küpe numarası
    c.nick_name AS nick_name, -- Hayvanın takma adı
    TIME(m.milking_start_time) AS start_time2, -- Sağımın başlangıç saati
    TIME(m.milking_stop_time) AS stop_time2, -- Sağımın bitiş saati
    CONCAT(
        ABS(TIMESTAMPDIFF(MINUTE, m.milking_start_time, m.milking_stop_time)),
        'm ',
        LPAD(ABS(TIMESTAMPDIFF(SECOND, m.milking_start_time, m.milking_stop_time) % 60), 2, '0'),
        's'
    ) AS minute2, -- Sağım süresi
    m.milk_amount AS milk_amount2 -- Süt miktarı
FROM 
    milk m
JOIN 
    cattle c ON m.cattle_id = c.id
WHERE 
    m.milking_id = 2
    AND DATE(m.milking_start_time) = '$selectedDate'
ORDER BY 
    m.milking_start_time;
";

$result = $pdo->query($sql);
$milking1 = [];
$milking2 = [];
while ($row = $result->fetch()) {

    $milking2[] = [
        'cattle_id' => $row['cattle_id'],
        'ear_tag_number' => $row['ear_tag_number'],
        'nick_name' => $row['nick_name'],
        'milk_amount' => $row['milk_amount2'],
        'start_time' => $row['start_time2'],
        'end_time' => $row['stop_time2'],
        'minute' => $row['minute2'],
        'conductivity' => rand(40, 55) / 10, // Rastgele 0 veya 1 üret
        'step_count' => rand(1000, 10000), // Rastgele 1000 ile 10000 arasında bir sayı üret
    ];
}

?>
<link rel="stylesheet" href="assets/css/datemilk.css">
<div class="container text-center" style="margin-top: 120px;">

    <div class="row">

        <div class="col-8 col-sm-8" style="margin:auto;">
            <h2>2. Sağım</h2>

        </div>
        <div class="w-100 d-none d-md-block"></div>

        <div class="col-8 col-sm-6-8" style="overflow-y: scroll; height: calc(100vh - 100px); margin:auto">
            <table class="table table-striped table-hover">
                <thead style="top:0; position: sticky; z-index:0;background-color: #dee2e6;">
                    <tr>
                        <th>Takma Adı</th>
                        <th data-sort onclick="sortTable(0,this)">KÜPE</th>
                        <th data-sort onclick="sortTable(1,this)">Başlangıç Saati</th>
                        <th data-sort onclick="sortTable(3,this)">Sağım Süresi (dk)</th>
                        <th data-sort onclick="sortTable(4,this)">SÜT MİKTARI (L)</th>
                        <th>İletkenlik (mS/cm)</th>
                        <th>Adım Sayısı</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($milking2 as $data) : ?>
                        <tr>
                            <td>
                                <a href="onecattlemilk.php?cattle_id=<?php echo $data['cattle_id']; ?>">
                                    <?php echo $data['nick_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="onecattlemilk.php?cattle_id=<?php echo $data['cattle_id']; ?>">
                                    <?php echo $data['ear_tag_number']; ?>
                                </a>
                            </td>
                            <td><?php echo $data['start_time']; ?></td>
                            <td><?php echo $data['minute']; ?></td>
                            <td style="font-weight: bold; font-size:18px"><?php echo $data['milk_amount']; ?></td>
                            <td><?php echo $data['conductivity']; ?></td>
                            <td><?php echo $data['step_count']; ?></td>

                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function sortTable(n, event) {
        var table = event.closest('table'),
            tbody = table.querySelector('tbody'),
            rows = [...tbody.rows],
            hData = [...table.querySelectorAll('thead th')],
            desc = false;

        hData.forEach((head) => {
            if (head !== event) {
                head.classList.remove('asc', 'desc');
            }
        });

        desc = event.classList.contains('asc') ? true : false;
        event.classList.toggle('asc', !desc);
        event.classList.toggle('desc', desc);

        rows.sort((a, b) => {
            let x = (a.cells[n] && a.cells[n].textContent || '').trim().toLowerCase(),
                y = (b.cells[n] && b.cells[n].textContent || '').trim().toLowerCase();
            return desc ? (x < y ? 1 : -1) : (x > y ? 1 : -1);
        });

        rows.forEach((row) => {
            tbody.appendChild(row);
        });
    }
</script>