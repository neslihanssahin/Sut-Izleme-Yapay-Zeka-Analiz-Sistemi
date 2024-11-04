<?php
include 'database.php'; // Veritabanı bağlantısını dahil et
session_start(); // Start the session

$message = "";

// Giriş işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
	$username = $_POST['login-username'];
	$password = $_POST['login-password'];

	try {
		$sql = "SELECT password FROM information WHERE username = :username";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row['password'] === $password) {
				// Başarılı giriş, kullanıcıyı yönlendir
				$_SESSION['username'] = $username; // Store username in session
				header("Location: homepage.php");
				exit;
			} else {
				$message = "Şifre yanlış!";
			}
		} else {
			$message = "Kullanıcı adı bulunamadı!";
		}
	} catch (PDOException $e) {
		$message = "Sorgu hatası: " . $e->getMessage();
	}
}

// Kayıt işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
	$username = $_POST['signup-username'];
	$name = $_POST['signup-name'];
	$surname = $_POST['signup-surname'];
	$password = $_POST['signup-password'];
	$passwordConfirm = $_POST['signup-password-confirm'];

	if ($password === $passwordConfirm) {
		try {
			$sql = "INSERT INTO information (username, name, surname, password) VALUES (:username, :name, :surname, :password)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':surname', $surname);
			$stmt->bindParam(':password', $password);
			$stmt->execute();

			$message = "Kayıt başarılı!";
		} catch (PDOException $e) {
			$message = "Kayıt hatası: " . $e->getMessage();
		}
	} else {
		$message = "Şifreler eşleşmiyor!";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login / Sign Up</title>
	<style>
		*,
		*::before,
		*::after {
			box-sizing: border-box;
		}

		body {
			margin-top: 10px;
			font-family: Roboto, -apple-system, 'Helvetica Neue', 'Segoe UI', Arial, sans-serif;
			background: #fff;
		}

		.container {
			display: flex;
			justify-content: space-between;
			/* Divler arasında boşluk bırakır */
			width: 100%;
			/* Konteynerin tam genişliği */
		}


		.forms-section {
			flex: 1;
			/* Daha genişlik sağlayacak şekilde ayarlayın */
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			margin-top: -30px;
			;
		}

		.section-title {
			font-size: 30px;
			letter-spacing: 1px;
			color: #587bf7;
		}

		.forms {
			display: flex;
			flex-direction: row;
			align-items: flex-start;
			width: 100%;
			/* Formun tam genişlikte olmasını sağlar */
		}

		.form-wrapper {
			flex: 1;
			/* Her bir form wrapper genişlik alır */
			max-width: 400px;
			/* Formların maksimum genişliği */
			margin: 0 auto;
			/* Merkeze hizalama */
		}

		.form {
			overflow: hidden;
			padding: 30px 25px;
			border-radius: 5px;
			background-color: #fff;
		}

		.form-wrapper.is-active {
			animation: showLayer .3s ease-in forwards;
		}

		@keyframes showLayer {
			50% {
				z-index: 1;
			}

			100% {
				z-index: 1;
			}
		}

		@keyframes hideLayer {
			0% {
				z-index: 1;
			}

			49.999% {
				z-index: 1;
			}
		}

		.switcher {
			position: relative;
			cursor: pointer;
			display: block;
			margin-right: auto;
			margin-left: auto;
			padding: 0;
			text-transform: uppercase;
			font-family: inherit;
			font-size: 16px;
			letter-spacing: .5px;
			color: #999;
			background-color: transparent;
			border: none;
			outline: none;
			transform: translateX(0);
			transition: all .3s ease-out;
		}

		.form-wrapper.is-active .switcher-login {
			color: #587bf7;
			transform: translateX(90px);
		}

		.form-wrapper.is-active .switcher-signup {
			color: #587bf7;
			transform: translateX(-90px);
		}

		.underline {
			position: absolute;
			bottom: -5px;
			left: 0;
			overflow: hidden;
			pointer-events: none;
			width: 100%;
			height: 2px;
		}

		.underline::before {
			content: '';
			position: absolute;
			top: 0;
			left: inherit;
			display: block;
			width: inherit;
			height: inherit;
			background-color: currentColor;
			transition: transform .2s ease-out;
		}

		.switcher-login .underline::before {
			transform: translateX(101%);
		}

		.switcher-signup .underline::before {
			transform: translateX(-101%);
		}

		.form-wrapper.is-active .underline::before {
			transform: translateX(0);
		}

		.form {
			overflow: hidden;
			min-width: 260px;
			margin-top: 50px;
			padding: 30px 25px;
			border-radius: 5px;
			transform-origin: top;
		}

		.form-login {
			animation: hideLogin .3s ease-out forwards;
		}

		.form-wrapper.is-active .form-login {
			animation: showLogin .3s ease-in forwards;
		}

		@keyframes showLogin {
			0% {
				background: #dde4fa;
				transform: translate(40%, 10px);
			}

			50% {
				transform: translate(0, 0);
			}

			100% {
				background-color: #fff;
				transform: translate(35%, -20px);
			}
		}

		@keyframes hideLogin {
			0% {
				background-color: #fff;
				transform: translate(35%, -20px);
			}

			50% {
				transform: translate(0, 0);
			}

			100% {
				background: #dde4fa;
				transform: translate(40%, 10px);
			}
		}

		.form-signup {
			animation: hideSignup .3s ease-out forwards;
		}

		.form-wrapper.is-active .form-signup {
			animation: showSignup .3s ease-in forwards;
		}

		@keyframes showSignup {
			0% {
				background: #dde4fa;
				transform: translate(-40%, 10px) scaleY(.8);
			}

			50% {
				transform: translate(0, 0) scaleY(.8);
			}

			100% {
				background-color: #fff;
				transform: translate(-35%, -20px) scaleY(1);
			}
		}

		@keyframes hideSignup {
			0% {
				background-color: #fff;
				transform: translate(-35%, -20px) scaleY(1);
			}

			50% {
				transform: translate(0, 0) scaleY(.8);
			}

			100% {
				background: #dde4fa;
				transform: translate(-40%, 10px) scaleY(.8);
			}
		}

		.form fieldset {
			position: relative;
			opacity: 0;
			margin: 0;
			padding: 0;
			border: 0;
			transition: all .3s ease-out;
		}

		.form-login fieldset {
			transform: translateX(-50%);
		}

		.form-signup fieldset {
			transform: translateX(50%);
		}

		.form-wrapper.is-active fieldset {
			opacity: 1;
			transform: translateX(0);
			transition: opacity .4s ease-in, transform .35s ease-in;
		}

		.form legend {
			position: absolute;
			overflow: hidden;
			width: 1px;
			height: 1px;
			clip: rect(0 0 0 0);
		}

		.input-block {
			margin-bottom: 20px;
		}

		.input-block label {
			font-size: 14px;
			color: #a1b4b4;
		}

		.input-block input {
			display: block;
			width: 100%;
			margin-top: 8px;
			padding-right: 15px;
			padding-left: 15px;
			font-size: 16px;
			line-height: 40px;
			color: #3b4465;
			background: #eef9fe;
			border: 1px solid #dde4fa;
			border-radius: 2px;
		}

		.form [type='submit'] {
			opacity: 0;
			display: block;
			min-width: 120px;
			margin: 30px auto 10px;
			font-size: 18px;
			line-height: 40px;
			border-radius: 25px;
			border: none;
			transition: all .3s ease-out;
		}

		.form-wrapper.is-active .form [type='submit'] {
			opacity: 1;
			transform: translateX(0);
			transition: all .4s ease-in;
		}

		.btn-login {
			color: #fbfdff;
			background: #587bf7;
			transform: translateX(-30%);
		}

		.btn-signup {
			color: #587bf7;
			background: #fbfdff;
			box-shadow: inset 0 0 0 2px #587bf7;
			transform: translateX(30%);
		}

		.message {
			color: red;
			font-size: 14px;
			margin-top: 15px;
		}


		.about {
			flex: 1;
			/* .about elemanının genişliği, .forms-section ile uyumlu olmalı */
			margin-right: 20px;
			/* İki bölüm arasındaki boşluk */
			position: relative;
			width: 60%;
			/* Genişliği artırmak için %60 */
			height: 100vh;
			/* Sayfanın yüksekliği kadar yükseklik */
			overflow: hidden;
			/* Fotoğraf alanı dışına taşan kısımları gizler */
		}

		.about-photo {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			/* Ortalamak için */
			width: 80%;
			height: auto;
			object-fit: cover;
			border-radius: 8px;
		}
		.about a {
            display: block; /* Linkin tüm resmi kaplamasını sağlar */
            text-decoration: none; /* Link altını çizer */
        }
        
	</style>

</head>

<body>
	<div class="container">
		<div class="about">
			<a href="homePage.php">
				<img src="assets/img2/ana2.png" alt="Description of photo" class="about-photo">
			</a>
		</div>

		<section class="forms-section">
			<h1 class="section-title">HOŞGELDİNİZ</h1>
			<div class="forms">
				<div class="form-wrapper is-active">
					<button type="button" class="switcher switcher-login">
						GİRİŞ YAP
						<span class="underline"></span>
					</button>
					<form class="form form-login" method="POST">
						<fieldset>
							<legend>Please, enter your username and password for login.</legend>
							<div class="input-block">
								<label for="login-username">Kullanıcı Adı</label>
								<input id="login-username" name="login-username" type="text" required>
							</div>
							<div class="input-block">
								<label for="login-password">Şifre</label>
								<input id="login-password" name="login-password" type="password" required>
							</div>
						</fieldset>
						<button type="submit" name="login" class="btn-login">Giriş Yap</button>
						<div id="message" class="message"><?php echo htmlspecialchars($message); ?></div>
					</form>
				</div>
				<div class="form-wrapper">
					<button type="button" class="switcher switcher-signup">
						KAYIT OL
						<span class="underline"></span>
					</button>
					<form class="form form-signup" method="POST">
						<fieldset>
							<legend>Please, enter your details for sign up.</legend>
							<div class="input-block">
								<label for="signup-username">Kullanıcı Adı</label>
								<input id="signup-username" name="signup-username" type="text" required>
							</div>
							<div class="input-block">
								<label for="signup-name">İsim</label>
								<input id="signup-name" name="signup-name" type="text" required>
							</div>
							<div class="input-block">
								<label for="signup-surname">Soyisim</label>
								<input id="signup-surname" name="signup-surname" type="text">
							</div>
							<div class="input-block">
								<label for="signup-password">Şifre</label>
								<input id="signup-password" name="signup-password" type="password" required>
							</div>
							<div class="input-block">
								<label for="signup-password-confirm">Şifre Tekrarı</label>
								<input id="signup-password-confirm" name="signup-password-confirm" type="password" required>
							</div>
						</fieldset>
						<button type="submit" name="signup" class="btn-signup"> KAYIT OL
						</button>
					</form>
				</div>
			</div>
		</section>
	</div>



	<script>
		const switchers = [...document.querySelectorAll('.switcher')]

		switchers.forEach(item => {
			item.addEventListener('click', function() {
				switchers.forEach(item => item.parentElement.classList.remove('is-active'))
				this.parentElement.classList.add('is-active')
			})
		})
	</script>
</body>

</html>