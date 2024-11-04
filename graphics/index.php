<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--=============== REMIXICONS ===============-->
   <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

   <!--=============== CSS ===============-->
   <link rel="stylesheet" href="assets/css/styles.css">
   <!--=============== BOS ===============-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <title>SALİS</title>
</head>

<body>
   <?php require_once "database.php"; ?>
   <!--=============== HEADER ===============-->
   <header class="header">
      <nav class="nav container">
         <div class="nav__data">
            <a href="#" class="nav__logo">
            <!-- <img src="logo.jpg" alt="Resim açıklaması">  -->
            SİYAS
            </a>

            <div class="nav__toggle" id="nav-toggle">
               <i class="ri-menu-line nav__burger"></i>
               <i class="ri-close-line nav__close"></i>
            </div>
         </div>

         <!--=============== NAV MENU ===============-->
         <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
               <li><a href="#" class="nav__link">Ana Sayfa</a></li>

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
                        <a href="cattlemilk.php" class="dropdown__link">
                           <i class="ri-arrow-up-down-line"></i> Bireysel Süt
                        </a>
                     </li>

                     <!--=============== DROPDOWN SUBMENU ===============-->
                     <!-- <li class="dropdown__subitem">
                           <div class="dropdown__link">
                              <i class="ri-bar-chart-line"></i> Reports <i class="ri-add-line dropdown__add"></i>
                           </div>

                           <ul class="dropdown__submenu">
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-file-list-line"></i> Documents
                                 </a>
                              </li>
      
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-cash-line"></i> Payments
                                 </a>
                              </li>
      
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-refund-2-line"></i> Refunds
                                 </a>
                              </li>
                           </ul>
                        </li> -->

                  </ul>
               </li>


               <!--=============== DROPDOWN 2 ===============-->
               <li class="dropdown__item">
                  <div class="nav__link">
                     Kullanıcı <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                  </div>

                  <ul class="dropdown__menu">
                     <li>
                        <a href="#" class="dropdown__link">
                           <i class="ri-user-line"></i> Profil
                        </a>
                     </li>

                     <li>
                        <a href="#" class="dropdown__link">
                           <i class="ri-settings-2-line"></i> Ayarlar
                        </a>
                     </li>

                     <li>
                        <a href="#" class="dropdown__link">
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
   <script src="assets/js/main.js"></script>
</body>

</html>