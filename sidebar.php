<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--=============== REMIXICONS ===============-->
   <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

   <!--=============== CSS ===============-->
   <link rel="stylesheet" href="assets/css/sidebar.css">
   <!--=============== BOS ===============-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- Highcharts kütüphanesi -->
   <script src="https://code.highcharts.com/highcharts.js"></script>

   <title>SİYAS</title>
</head>

<body>
   <?php require_once "database.php"; ?>
   <!--=============== HEADER ===============-->
   <header class="header">
      <nav class="nav container">
         <div class="nav__data">
            <a href="homepage.php" class="nav__logo" style="text-decoration: none;">
               <!-- <img src="logo.jpg" alt="Resim açıklaması">  -->
               SİYAS (Süt İzleme ve Yapay Zeka Analiz Sistemi)
            </a>

            <div class="nav__toggle" id="nav-toggle">
               <i class="ri-menu-line nav__burger"></i>
               <i class="ri-close-line nav__close"></i>
            </div>
         </div>

         <!--=============== NAV MENU ===============-->
         <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
               <li><a href="homepage.php" class="nav__link" style="text-decoration: none;">Ana Sayfa</a></li>

               <li><a href="cattlegrid.php" class="nav__link" style="text-decoration: none;">Hayvan Listele</a></li>


               <!--=============== DROPDOWN 1 ===============-->
               <li class="dropdown__item" style=" top:0; position: sticky; z-index:1;">
                  <div class="nav__link">
                     Süt Verim Raporu<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                  </div>

                  <ul class="dropdown__menu">
                     <li>
                        <a href="totalmilk.php" class="dropdown__link">
                           <i class="ri-bar-chart-fill"></i></i> Toplu Süt
                        </a>
                     </li>

                     <li>
                        <a href="cattlesmilk.php" class="dropdown__link">
                           <i class="ri-arrow-up-down-line"></i> Bireysel Süt
                        </a>
                     </li>
                  </ul>
               </li>


               <!--=============== DROPDOWN 2 ===============-->
               <li class="dropdown__item">
                  <div class="nav__link">
                     Kullanıcı <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                  </div>

                  <ul class="dropdown__menu">
                     <li>
                        <a href="editPage.php" class="dropdown__link">
                           <i class="ri-user-line"></i> Profil
                        </a>
                     </li>

                     <li>
                        <a href="index.php" class="dropdown__link">
                           <i class="ri-settings-2-line"></i> Hakkında
                        </a>
                     </li>

                     <li>
                        <a href="#" class="dropdown__link" id="logout-link">
                           <i class="ri-logout-circle-r-line"></i> Çıkış Yap
                        </a>
                     </li>
                  </ul>
               </li>
            </ul>
         </div>
      </nav>
   </header>

   <!--=============== MAIN JS ===============-->
   <script src="assets/js/sidebar.js"></script>

   <script>
      document.getElementById('logout-link').addEventListener('click', function(event) {
         event.preventDefault(); // Linkin varsayılan davranışını engelle

         var xhr = new XMLHttpRequest();
         xhr.open("GET", "logout.php", true);
         xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
               if (xhr.status === 200) {
                  // Çıkış yapıldıktan sonra yönlendirme
                  window.location.href = "loginPage.php";
               } else {
                  console.error('Çıkış yapma işlemi başarısız oldu.');
               }
            }
         };
         xhr.send();
      });
   </script>
</body>

</html>