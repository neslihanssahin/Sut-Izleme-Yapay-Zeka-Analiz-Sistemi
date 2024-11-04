<?php
session_start(); // Oturum yönetimini başlat
include 'database.php'; // Veritabanı bağlantısını dahil et
include 'sidebar.php'; 


$feedback = ''; // Geri bildirim mesajı için değişken

if (!isset($_SESSION['username'])) {
    header("Location: loginPage.php"); // Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
    exit;
}

$current_username = $_SESSION['username'];
$is_edit_mode = isset($_POST['edit_mode']) ? true : false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_new_password = $_POST['confirm_password'] ?? '';

        try {
            $sql = "SELECT password FROM information WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $current_username);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $stored_password = $user['password'];

                if ($current_password === $stored_password) {
                    if ($new_password === $confirm_new_password) {
                        $sql = "UPDATE information SET password = :new_password WHERE username = :username";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':new_password', $new_password);
                        $stmt->bindParam(':username', $current_username);
                        $stmt->execute();
                        $feedback = "Şifre başarıyla güncellendi.";
                        header("Location: editPage.php"); 
                        exit;
                    } else {
                        $feedback = "Yeni şifreler uyuşmuyor.";
                    }
                } else {
                    $feedback = "Mevcut şifre yanlış.";
                }
            } else {
                $feedback = "Kullanıcı bulunamadı.";
            }
        } catch (PDOException $e) {
            $feedback = "Sorgu hatası: " . htmlspecialchars($e->getMessage());
        }
    }

    if (isset($_POST['update_info'])) {
        $new_username = $_POST['username'] ?? '';
        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $farm_name = $_POST['farm_name'] ?? '';

        try {
            $sql = "UPDATE information SET username = :new_username, name = :name, surname = :surname, farm_name = :farm_name WHERE username = :current_username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':new_username', $new_username);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':farm_name', $farm_name);
            $stmt->bindParam(':current_username', $current_username);
            $stmt->execute();

            $_SESSION['username'] = $new_username;
            $feedback = "Bilgiler başarıyla güncellendi.";
            header("Location: editPage.php"); 
            exit;
        } catch (PDOException $e) {
            $feedback = "Sorgu hatası: " . htmlspecialchars($e->getMessage());
        }
    }
}

try {
    $sql = "SELECT * FROM information WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $current_username);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $name = htmlspecialchars($user['name']);
        $surname = htmlspecialchars($user['surname']);
        $username = htmlspecialchars($user['username']);
        $farm_name = htmlspecialchars($user['farm_name']);
    } else {
        $feedback = "<p>Kullanıcı bilgileri bulunamadı.</p>";
    }
} catch (PDOException $e) {
    $feedback = "Sorgu hatası: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 120px;
            background-color: #fff;
            margin-bottom: 30px; 
        }
        .avatar {
            width: 200px;
            height: 200px;
        }
        .editable {
            display: none;
        }
        .edit-mode .editable {
            display: block;
        }
        .edit-mode .read-only {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container bootstrap snippets bootdey">
        <h1 style="color:#587bf7">Profili Düzenle</h1>
        <hr>
        <?php if (!empty($feedback)): ?>
            <div class="alert alert-info"><?php echo $feedback; ?></div>
        <?php endif; ?>
        <div class="row">
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center">
                    <img src="assets\img2\profile.jpg" class="avatar img-circle img-thumbnail" alt="avatar">
                    
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <h3 style="color:#587bf7">Kullanıcı Bilgileri</h3>

                <form class="form-horizontal <?php echo $is_edit_mode ? 'edit-mode' : ''; ?>" role="form" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Kullanıcı Adı:</label>
                        <div class="col-lg-8">
                            <input class="form-control read-only" type="text" value="<?php echo htmlspecialchars($username); ?>" readonly>
                            <input class="form-control editable" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">İsim:</label>
                        <div class="col-lg-8">
                            <input class="form-control read-only" type="text" value="<?php echo htmlspecialchars($name); ?>" readonly>
                            <input class="form-control editable" type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Soyisim:</label>
                        <div class="col-lg-8">
                            <input class="form-control read-only" type="text" value="<?php echo htmlspecialchars($surname); ?>" readonly>
                            <input class="form-control editable" type="text" name="surname" value="<?php echo htmlspecialchars($surname); ?>"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Çiftlik Adı:</label>
                        <div class="col-lg-8">
                            <input class="form-control read-only" type="text" value="<?php echo htmlspecialchars($farm_name); ?>" readonly>
                            <input class="form-control editable" type="text" name="farm_name" value="<?php echo htmlspecialchars($farm_name); ?>"><br>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <?php if (!$is_edit_mode): ?>
                            <button type="submit" name="edit_mode" value="true" class="btn btn-info">Düzenle</button>
                        <?php else: ?>
                            <button type="submit" name="update_info" class="btn btn-success">Kaydet</button>
                            <a href="editPage.php" class="btn btn-danger" >İptal</a>
                        <?php endif; ?>
                    </div>
                </form>

                <h4 class="font-weight-bold py-3 mb-4" style="color:#587bf7">Şifre Değiştir</h4>
                 
                <form class="form-horizontal" role="form" method="POST">
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Mevcut Şifre:</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" name="current_password" required><br>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Yeni Şifre:</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label">Yeni Şifre (Tekrar):</label>
                        <div class="col-lg-8">
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" name="change_password" class="btn btn-info">Şifreyi Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
