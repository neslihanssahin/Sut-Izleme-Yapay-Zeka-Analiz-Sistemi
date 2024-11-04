<?php
// require_once "database.php";
require_once "sidebar.php";

$typesql = "SELECT type_name FROM type;";
$typeresult = $pdo->query($typesql);
$typedata = array();

while ($row = $typeresult->fetch(PDO::FETCH_ASSOC)) {
    $typedata[] = $row; // Verileri diziye ekliyoruz
}
//sql değişti
$sql = "SELECT 
    c.id AS cattle_id, 
    c.ear_tag_number, 
    c.rfid_number, 
    c.nick_name, 
    c.date_of_birth,
    c.photo,
    c.mother_tag_number,
    c.father_tag_number, 
    t.type_name AS type_name,
    mt.type_name AS mother_type_name,
    ft.type_name AS father_type_name,
    AVG(m.milk_amount) AS ortmilk
FROM 
    cattle c
LEFT JOIN 
    milk m ON c.id = m.cattle_id
JOIN 
    type t ON c.type_id = t.id
LEFT JOIN 
    type mt ON c.mother_type_id = mt.id
LEFT JOIN 
    type ft ON c.father_type_id = ft.id
WHERE 
    c.death_date IS NULL
GROUP BY 
    c.id
ORDER BY 
    ortmilk DESC;";
$result = $pdo->query($sql);
$data = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Calculate age
    $birthDate = new DateTime($row['date_of_birth']);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    $row['age'] = $age; // Add age to row data
    $data[] = $row; // Verileri diziye ekliyoruz
}
?>

<link rel="stylesheet" href="assets/css/cattlelist.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<style>
    .icon-container {
        display: flex;
        justify-content: flex-start;
        margin-right: 150px;
        margin-top: 20px;
    }

    .icon-container i {
        cursor: pointer;
        font-size: 36px;
        margin-left: 20px;
        transition: color 0.3s ease;
    }

    .icon-container i:hover {
        color: blue;
    }

    .preview-box .actions {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .preview-box .actions button {
        margin-left: 10px;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .preview-box .actions .delete {
        background-color: red;
        color: white;
    }

    .preview-box .actions .update {
        background-color: green;
        color: white;
    }

    .preview-box .actions button:hover {
        opacity: 0.8;
    }

    .preview-box .icon {
        cursor: pointer;
    }

    .preview-box.show {
        display: block;
    }

    .shadow.show {
        display: block;
    }

    .preview-box,
    .shadow {
        display: none;
    }

    .photo {
        padding: 10px;
        margin: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        overflow: hidden;
        width: 300px;
        height: 300px;
    }

    .photo img {
        width: 100%;
        height: 100%;
    }

    .cattleinfo {
        margin: 20px;
        width: 100%;
        height: 100%;
    }

    .fixed-button {
        border-radius: 50px;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
</style>
<div class="wrapper">
    <div class="icon-container">
        <i class="ri-list-unordered" id="listView"></i>
        <i class="ri-grid-fill" id="gridView"></i>
    </div>
    <!-- filter Items -->
    <nav>
        <div class="items">
            <span class="item active" data-name="all">Hepsini Sırala</span>
            <?php foreach ($typedata as $cattle) : ?>
                <span class="item" data-name="<?php echo $cattle['type_name']; ?>"><?php echo $cattle['type_name']; ?></span>
            <?php endforeach; ?>
        </div>
    </nav>

    <!-- filter Images -->
    <div class="gallery">
        <?php foreach ($data as $cattle) : ?>
            <div class="image" data-name="<?php echo $cattle['type_name']; ?>" data-cattle_id="<?php echo $cattle['cattle_id']; ?>" data-nick_name="<?php echo $cattle['nick_name']; ?>" data-ear_tag_number="<?php echo $cattle['ear_tag_number']; ?>" data-rfid_number="<?php echo $cattle['rfid_number']; ?>" data-type="<?php echo $cattle['type_name']; ?>" data-date_of_birth="<?php echo $cattle['date_of_birth']; ?>" data-age="<?php echo $cattle['age']; ?>" data-mother="<?php echo $cattle['mother_tag_number']; ?>" data-mother_type="<?php echo $cattle['mother_type_name']; ?>" data-father="<?php echo $cattle['father_tag_number']; ?>" data-father_type="<?php echo $cattle['father_type_name']; ?>">
                <span>
                    
                        <?php if (!empty($cattle['photo'])) : ?>
                            <img  src="<?php echo $cattle['photo']; ?>" alt="">
                        <?php else : ?>
                            <img src="assets/img/photo/photo.png" alt="">
                        <?php endif; ?>
                   
                </span>
                <h4><?php echo $cattle['nick_name']; ?></h4>
                <h5><?php echo $cattle['ear_tag_number']; ?></h5>
                <p>Ortalama Süt Miktarı: <b style="color: red;"><?php echo number_format($cattle['ortmilk'], 2); ?>L</b> </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- fullscreen img preview box -->
<div class="preview-box" style="width: 1500px; height: 700px;">
    <input type="hidden" id="cattle_id" />
    <div class="details">
        <span class="title">Hayvan Irk: <p></p></span>
        <span class="icon fas fa-times"></span>
    </div>
    <div class="info" style="display: flex;">
        <div class="photo">
            <img src="" alt="">
        </div>
        <div class="cattleinfo">
            <h3>Hayvan Bilgileri</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Küpe No:</strong><span id="ear_tag_number"></span></li>
                <li class="list-group-item"><strong>RFID No:</strong> <span id="rfid_number"></span></li>
                <li class="list-group-item"><strong>Takma Ad:</strong> <span id="nick_name"></span></li>
                <li class="list-group-item"><strong>Irk:</strong> <span id="type_name"></span></li>
                <li class="list-group-item"><strong>Doğum Tarihi:</strong> <span id="date_of_birth"></span></li>
                <li class="list-group-item"><strong>Yaş:</strong> <span id="age"></span></li>
                <li class="list-group-item"><strong>Annesının Küpe No:</strong> <span id="mother_tag_number"></span></li>
                <li class="list-group-item"><strong>Annesinin Irk:</strong> <span id="mother_type_id"></span></li>
                <li class="list-group-item"><strong>Babasının Küpe No:</strong> <span id="father_tag_number"></span></li>
                <li class="list-group-item"><strong>Babasının Irk:</strong> <span id="father_type_id"></span></li>
            </ul>
        </div>
    </div>

    <div class="button" style="display: flex;">
        <div class="col-4" style="margin:20px;padding: 25px; ">
            <div class="actions">
                <button class="update" style="width: 170px;">Güncelle</button>
            </div>
        </div>
        <div class="col-4" style="margin:20px;padding: 25px; ">
            <div class="actions">
                <button class="delete" style="width: 170px;">Sil</button>
            </div>
        </div>
    </div>

</div>

<div class="shadow"></div>

<div class="fixed-button" id="toggleAccordion">
    <strong>+</strong>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/cattlelist.js"></script>

<script>
    $(document).ready(function() {
        $("#toggleAccordion").click(function() {
            window.location.href = 'cattleadd.php';
        });
        // Separate click event handlers for listView and gridView icons
        $('#listView').click(function() {
            window.location.href = 'cattlelist.php';
        });
        $('#gridView').click(function() {
            window.location.href = 'cattlegrid.php';
        });

        $('.image').click(function() {
            // Retrieve data attributes from the clicked element
            var cattle_id = $(this).data('cattle_id');
            var nick_name = $(this).data('nick_name');
            var ear_tag_number = $(this).data('ear_tag_number');
            var rfid_number = $(this).data('rfid_number');
            var type = $(this).data('type');
            var date_of_birth = $(this).data('date_of_birth');
            var age = $(this).data('age');
            var mother_tag_number = $(this).data('mother');
            var mother_type_id = $(this).data('mother_type');
            var father_tag_number = $(this).data('father');
            var father_type_id = $(this).data('father_type');
            // Update the content of the preview box
            $('.preview-box .details p').text(type);
            $('.preview-box  .photo img').attr('src', $(this).find('img').attr('src'));
            $('#ear_tag_number').text(ear_tag_number);
            $('#rfid_number').text(rfid_number);
            $('#nick_name').text(nick_name);
            $('#type_name').text(type);
            $('#date_of_birth').text(date_of_birth);
            $('#age').text(age);
            $('#mother_tag_number').text(mother_tag_number);
            $('#mother_type_id').text(mother_type_id);
            $('#father_tag_number').text(father_tag_number);
            $('#father_type_id').text(father_type_id);

            // Store cattle_id in a hidden field
            $('#cattle_id').val(cattle_id);

            // Show the preview box and shadow
            $('.preview-box').addClass('show');
            $('.shadow').addClass('show');
        });

        $('.preview-box .icon').click(function() {
            $('.preview-box').removeClass('show');
            $('.shadow').removeClass('show');
        });

        $('.shadow').click(function() {
            $('.preview-box').removeClass('show');
            $('.shadow').removeClass('show');
        });

        $('.delete').click(function() {
            var cattle_id = $('#cattle_id').val();
            window.location.href = 'delete.php?id=' + cattle_id;
        });

        $('.update').click(function() {
            var cattle_id = $('#cattle_id').val();
            window.location.href = 'update.php?id=' + cattle_id;
        });
    });
</script>