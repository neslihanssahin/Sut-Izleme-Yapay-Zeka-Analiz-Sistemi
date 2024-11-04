<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SİYAS</title>
  <meta name="description" content="">
  <meta name="keywords" content="">



  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">



  <style>
    .slider {
      width: 1100px;
      height: 500px;
      overflow: hidden;
      position: relative;
      margin: auto;
    }

    .slides {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.5s ease-in-out;
    }

    .slide {
      min-width: 100%;
      height: 100%;
      box-sizing: border-box;
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      /* Kırpma olmadan resmi sığdırır */

    }

    .center-text {
      text-align: center;
      display: block;
      /* <i> etiketi inline olarak varsayılan, bunu block yaparak hizalamayı sağlar */
      width: 100%;
      /* Genişliği %100 yaparak tüm satırı kaplar */
      margin-bottom: 50px;
    }

    .icon-box img {
      width: 40px;
      /* İkon genişliği */
      height: 40px;
      /* İkon yüksekliği */
      object-fit: cover;
      /* Resimleri ikon boyutuna uygun şekilde kırpar */
      display: block;
      margin-right: 10px;
      /* İkon ile başlık arasında boşluk */
    }

    .slider {
      width: 1100px;
      height: 500px;
      overflow: hidden;
      position: relative;
      margin: auto;
    }

    .slides {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.5s ease-in-out;
    }

    .slide {
      min-width: 100%;
      height: 100%;
      box-sizing: border-box;
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      /* Kırpma olmadan resmi sığdırır */
    }

    .dots {
      text-align: center;
      position: absolute;
      width: 100%;
      bottom: 0px;
    }
    .dot {
      display: inline-block;
      width: 10px;
      height: 10px;
      margin: 0 5px;
      background-color: #bbb;
      border-radius: 50%;
      cursor: pointer;
    }

    .dot.active {
      background-color: #717171;
    }
    
:root {
  --default-font: "Roboto",  system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  --heading-font: "Raleway",  sans-serif;
  --nav-font: "Poppins",  sans-serif;
}

/* Global Colors - The following color variables are used throughout the website. Updating them here will change the color scheme of the entire website */
:root { 
  --background-color: #ffffff; /* Background color for the entire website, including individual sections */
  --default-color: #212529; /* Default color used for the majority of the text content across the entire website */
  --heading-color: #2d465e; /* Color for headings, subheadings and title throughout the website */
  --accent-color: #5777ba; /* Accent color that represents your brand on the website. It's used for buttons, links, and other elements that need to stand out */
  --surface-color: #ffffff; /* The surface color is used as a background of boxed elements within sections, such as cards, icon boxes, or other elements that require a visual separation from the global background. */
  --contrast-color: #ffffff; /* Contrast color for text, ensuring readability against backgrounds of accent, heading, or default colors. */
}

/* Nav Menu Colors - The following color variables are used specifically for the navigation menu. They are separate from the global colors to allow for more customization options */
:root {
  --nav-color: #212529;  /* The default color of the main navmenu links */
  --nav-hover-color: #5777ba; /* Applied to main navmenu links when they are hovered over or active */
  --nav-mobile-background-color: #ffffff; /* Used as the background color for mobile navigation menu */
  --nav-dropdown-background-color: #ffffff; /* Used as the background color for dropdown items that appear when hovering over primary navigation items */
  --nav-dropdown-color: #212529; /* Used for navigation links of the dropdown items in the navigation menu. */
  --nav-dropdown-hover-color: #5777ba; /* Similar to --nav-hover-color, this color is applied to dropdown navigation links when they are hovered over. */
}

.light-background {
  --background-color: #f2f5fb;
  --surface-color: #ffffff;
}

.dark-background {
  --background-color: #060606;
  --default-color: #ffffff;
  --heading-color: #ffffff;
  --surface-color: #252525;
  --contrast-color: #ffffff;
}

/* Smooth scroll */
:root {
  scroll-behavior: smooth;
}

/*--------------------------------------------------------------
# General Styling & Shared Classes
--------------------------------------------------------------*/
body {
  color: var(--default-color);
  background-color: var(--background-color);
  font-family: var(--default-font);
}

a {
  color: #587bf7;
  text-decoration: none;
  transition: 0.3s;
}

a:hover {
  color: color-mix(in srgb, #587bf7, transparent 25%);
  text-decoration: none;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  color: var(--heading-color);
  font-family: var(--heading-font);
}
.header {
  color: var(--default-color);
  background-color: var(--background-color);
  padding: 15px 0;
  transition: all 0.5s;
  z-index: 997;
}

.header .logo {
  line-height: 1;
}

.header .logo img {
  max-height: 36px;
  margin-right: 8px;
}

.header .logo h1 {
  font-size: 30px;
  margin: 0;
  font-weight: 400;
  color: var(--heading-color);
}

.header .btn-getstarted,
.header .btn-getstarted:focus {
  color: var(--contrast-color);
  background: #587bf7;
  font-size: 14px;
  padding: 8px 25px;
  margin: 0 0 0 30px;
  border-radius: 50px;
  transition: 0.3s;
}

.header .btn-getstarted:hover,
.header .btn-getstarted:focus:hover {
  color: var(--contrast-color);
  background: color-mix(in srgb, #587bf7, transparent 15%);
}

@media (max-width: 1200px) {
  .header .logo {
    order: 1;
  }

  .header .btn-getstarted {
    order: 2;
    margin: 0 15px 0 0;
    padding: 6px 15px;
  }

  .header .navmenu {
    order: 3;
  }
}

.scrolled .header {
  box-shadow: 0px 0 18px rgba(0, 0, 0, 0.1);
}

/* Navmenu - Desktop */
@media (min-width: 1200px) {
  .navmenu {
    padding: 0;
  }

  .navmenu ul {
    margin: 0;
    padding: 0;
    display: flex;
    list-style: none;
    align-items: center;
  }

  .navmenu li {
    position: relative;
  }

  .navmenu a,
  .navmenu a:focus {
    color: var(--nav-color);
    padding: 18px 15px;
    font-size: 16px;
    font-family: var(--nav-font);
    font-weight: 400;
    display: flex;
    align-items: center;
    justify-content: space-between;
    white-space: nowrap;
    transition: 0.3s;
  }

  .navmenu a i,
  .navmenu a:focus i {
    font-size: 12px;
    line-height: 0;
    margin-left: 5px;
    transition: 0.3s;
  }

  .navmenu li:last-child a {
    padding-right: 0;
  }

  .navmenu li:hover>a,
  .navmenu .active,
  .navmenu .active:focus {
    color: #587bf7;
  }

  .navmenu .dropdown ul {
    margin: 0;
    padding: 10px 0;
    background: var(--nav-dropdown-background-color);
    display: block;
    position: absolute;
    visibility: hidden;
    left: 14px;
    top: 130%;
    opacity: 0;
    transition: 0.3s;
    border-radius: 4px;
    z-index: 99;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1);
  }

  .navmenu .dropdown ul li {
    min-width: 200px;
  }

  .navmenu .dropdown ul a {
    padding: 10px 20px;
    font-size: 15px;
    text-transform: none;
    color: var(--nav-dropdown-color);
  }

  .navmenu .dropdown ul a i {
    font-size: 12px;
  }

  .navmenu .dropdown ul a:hover,
  .navmenu .dropdown ul .active:hover,
  .navmenu .dropdown ul li:hover>a {
    color: #587bf7;
  }

  .navmenu .dropdown:hover>ul {
    opacity: 1;
    top: 100%;
    visibility: visible;
  }

  .navmenu .dropdown .dropdown ul {
    top: 0;
    left: -90%;
    visibility: hidden;
  }

  .navmenu .dropdown .dropdown:hover>ul {
    opacity: 1;
    top: 0;
    left: -100%;
    visibility: visible;
  }
}

/* Navmenu - Mobile */
@media (max-width: 1199px) {
  .mobile-nav-toggle {
    color: var(--nav-color);
    font-size: 28px;
    line-height: 0;
    margin-right: 10px;
    cursor: pointer;
    transition: color 0.3s;
  }

  .navmenu {
    padding: 0;
    z-index: 9997;
  }

  .navmenu ul {
    display: none;
    list-style: none;
    position: absolute;
    inset: 60px 20px 20px 20px;
    padding: 10px 0;
    margin: 0;
    border-radius: 6px;
    background-color: var(--nav-mobile-background-color);
    overflow-y: auto;
    transition: 0.3s;
    z-index: 9998;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.1);
  }

  .navmenu a,
  .navmenu a:focus {
    color: var(--nav-dropdown-color);
    padding: 10px 20px;
    font-family: var(--nav-font);
    font-size: 17px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: space-between;
    white-space: nowrap;
    transition: 0.3s;
  }

  .navmenu a i,
  .navmenu a:focus i {
    font-size: 12px;
    line-height: 0;
    margin-left: 5px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: 0.3s;
    background-color: color-mix(in srgb, #587bf7, transparent 90%);
  }

  .navmenu a i:hover,
  .navmenu a:focus i:hover {
    background-color: #587bf7;
    color: var(--contrast-color);
  }

  .navmenu a:hover,
  .navmenu .active,
  .navmenu .active:focus {
    color: #587bf7;
  }

  .navmenu .active i,
  .navmenu .active:focus i {
    background-color: #587bf7;
    color: var(--contrast-color);
    transform: rotate(180deg);
  }

  .navmenu .dropdown ul {
    position: static;
    display: none;
    z-index: 99;
    padding: 10px 0;
    margin: 10px 20px;
    background-color: var(--nav-dropdown-background-color);
    border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
    box-shadow: none;
    transition: all 0.5s ease-in-out;
  }

  .navmenu .dropdown ul ul {
    background-color: rgba(33, 37, 41, 0.1);
  }

  .navmenu .dropdown>.dropdown-active {
    display: block;
    background-color: rgba(33, 37, 41, 0.03);
  }

  .mobile-nav-active {
    overflow: hidden;
  }

  .mobile-nav-active .mobile-nav-toggle {
    color: #fff;
    position: absolute;
    font-size: 32px;
    top: 15px;
    right: 15px;
    margin-right: 0;
    z-index: 9999;
  }

  .mobile-nav-active .navmenu {
    position: fixed;
    overflow: hidden;
    inset: 0;
    background: rgba(33, 37, 41, 0.8);
    transition: 0.3s;
  }

  .mobile-nav-active .navmenu>ul {
    display: block;
  }
}

/*--------------------------------------------------------------
# Global Footer
--------------------------------------------------------------*/
.footer {
  color: var(--default-color);
  background-color: var(--background-color);
  font-size: 14px;
  position: relative;
}

.footer .footer-newsletter {
  background-color: color-mix(in srgb, var(--default-color), transparent 97%);
  padding: 50px 0;
}

.footer .footer-newsletter h4 {
  font-size: 24px;
}

.footer .footer-newsletter .newsletter-form {
  margin-top: 30px;
  margin-bottom: 15px;
  padding: 6px 8px;
  position: relative;
  border-radius: 4px;
  background-color: var(--surface-color);
  border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
  box-shadow: 0px 2px 25px rgba(0, 0, 0, 0.1);
  display: flex;
  transition: 0.3s;
  border-radius: 50px;
}

.footer .footer-newsletter .newsletter-form:focus-within {
  border-color: #587bf7;
}

.footer .footer-newsletter .newsletter-form input[type=email] {
  border: 0;
  padding: 4px;
  width: 100%;
  background-color: var(--surface-color);
  color: var(--default-color);
}

.footer .footer-newsletter .newsletter-form input[type=email]:focus-visible {
  outline: none;
}

.footer .footer-newsletter .newsletter-form input[type=submit] {
  border: 0;
  font-size: 16px;
  padding: 0 20px;
  margin: -7px -8px -7px 0;
  background: #587bf7;
  color: var(--contrast-color);
  transition: 0.3s;
  border-radius: 50px;
}

.footer .footer-newsletter .newsletter-form input[type=submit]:hover {
  background: color-mix(in srgb, #587bf7, transparent 20%);
}

.footer .footer-top {
  padding-top: 50px;
}



.footer h4 {
  font-size: 16px;
  font-weight: bold;
  position: relative;
  padding-bottom: 12px;
}

.footer .footer-links {
  margin-bottom: 30px;
}

.footer .footer-links ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer .footer-links ul i {
  margin-right: 3px;
  font-size: 12px;
  line-height: 0;
  color: #587bf7;
}

.footer .footer-links ul li {
  padding: 10px 0;
  display: flex;
  align-items: center;
}

.footer .footer-links ul li:first-child {
  padding-top: 0;
}

.footer .footer-links ul a {
  display: inline-block;
  color: color-mix(in srgb, var(--default-color), transparent 20%);
  line-height: 1;
}

.footer .footer-links ul a:hover {
  color: #587bf7;
}

.footer .footer-about a {
  color: var(--heading-color);
  font-size: 24px;
  font-weight: 600;
  font-family: var(--heading-font);
}

.footer .footer-contact p {
  margin-bottom: 5px;
}

.footer .copyright {
  padding: 25px 0;
  border-top: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);
}

.footer .copyright p {
  margin-bottom: 0;
}

.footer .credits {
  margin-top: 6px;
  font-size: 13px;
}

/*--------------------------------------------------------------
# Scroll Top Button
--------------------------------------------------------------*/
.scroll-top {
  position: fixed;
  visibility: hidden;
  opacity: 0;
  right: 15px;
  bottom: 15px;
  z-index: 99999;
  background-color: #587bf7;
  width: 40px;
  height: 40px;
  border-radius: 4px;
  transition: all 0.4s;
}

.scroll-top i {
  font-size: 24px;
  color: var(--contrast-color);
  line-height: 0;
}

.scroll-top:hover {
  background-color: color-mix(in srgb, #587bf7, transparent 20%);
  color: var(--contrast-color);
}

.scroll-top.active {
  visibility: visible;
  opacity: 1;
}

/*--------------------------------------------------------------
# Disable aos animation delay on mobile devices
--------------------------------------------------------------*/
@media screen and (max-width: 768px) {
  [data-aos-delay] {
    transition-delay: 0 !important;
  }
}

/*--------------------------------------------------------------
# Global Page Titles & Breadcrumbs
--------------------------------------------------------------*/
.page-title {
  color: var(--default-color);
  background-color: var(--background-color);
  padding: 20px 0;
  position: relative;
}

.page-title h1 {
  font-size: 28px;
  font-weight: 700;
  margin: 0;
}

.page-title .breadcrumbs ol {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  padding: 0 0 10px 0;
  margin: 0;
  font-size: 14px;
  font-weight: 400;
}

.page-title .breadcrumbs ol li+li {
  padding-left: 10px;
}

.page-title .breadcrumbs ol li+li::before {
  content: "/";
  display: inline-block;
  padding-right: 10px;
  color: color-mix(in srgb, var(--default-color), transparent 70%);
}

/*--------------------------------------------------------------
# Global Sections
--------------------------------------------------------------*/
section,
.section {
  color: var(--default-color);
  background-color: var(--background-color);
  padding: 60px 0;
  scroll-margin-top: 90px;
  overflow: clip;
}

@media (max-width: 1199px) {

  section,
  .section {
    scroll-margin-top: 66px;
  }
}

/*--------------------------------------------------------------
# Global Section Titles
--------------------------------------------------------------*/
.section-title {
  text-align: center;
  padding-bottom: 60px;
  position: relative;
}

.section-title h2 {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 15px;
}

.section-title p {
  margin-bottom: 0;
}

/*--------------------------------------------------------------
# Hero Section
--------------------------------------------------------------*/
.hero {
  width: 100%;
  min-height: 70vh;
  position: relative;
  padding: 120px 0 60px 0;
  display: flex;
  align-items: center;
}

.hero h2 {
  margin: 0;
  font-size: 48px;
  font-weight: 700;
  line-height: 56px;
}

.hero p {
  color: color-mix(in srgb, var(--default-color), transparent 30%);
  margin: 5px 0 10px 0;
  font-size: 20px;
  font-weight: 400;
}

.hero .download-btn {
  color: var(--contrast-color);
  background: color-mix(in srgb, var(#587bf7) 90%, black 50%);
  font-family: var(--heading-font);
  font-weight: 500;
  font-size: 15px;
  padding: 8px 30px 10px 30px;
  border-radius: 3px;
  transition: 0.5s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero .download-btn+.download-btn {
  margin-left: 20px;
}

.hero .download-btn:hover {
  background: #587bf7;
  color: var(--contrast-color);
}

.hero .download-btn i {
  font-size: 16px;
  line-height: 0;
  margin-right: 8px;
}

@media (max-width: 768px) {
  .hero h2 {
    font-size: 28px;
    line-height: 36px;
  }

  .hero p {
    font-size: 18px;
    line-height: 24px;
    margin-bottom: 30px;
  }

  .hero .download-btn {
    font-size: 14px;
    padding: 8px 20px 10px 20px;
  }
}

/*--------------------------------------------------------------
# About Section
--------------------------------------------------------------*/
.about ul {
  list-style: none;
  padding: 0;
}

.about ul li {
  padding-bottom: 5px;
  display: flex;
  align-items: center;
}

.about ul i {
  font-size: 20px;
  padding-right: 4px;
  color: #587bf7;
}

.about .read-more {
  background: #587bf7;
  color: var(--contrast-color);
  font-family: var(--heading-font);
  font-weight: 500;
  font-size: 16px;
  letter-spacing: 1px;
  padding: 10px 28px;
  border-radius: 5px;
  transition: 0.3s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.about .read-more i {
  font-size: 18px;
  margin-left: 5px;
  line-height: 0;
  transition: 0.3s;
}

.about .read-more:hover {
  background: color-mix(in srgb, #587bf7, transparent 20%);
}

.about .read-more:hover i {
  transform: translate(5px, 0);
}

/*--------------------------------------------------------------
# Features Section
--------------------------------------------------------------*/
.features .icon-box {
  display: flex;
}

.features .icon-box h4 {
  font-size: 20px;
  font-weight: 700;
  margin: 0 0 10px 0;
}

.features .icon-box i {
  font-size: 44px;
  line-height: 44px;
  color: #587bf7;
  margin-right: 15px;
}

.features .icon-box p {
  font-size: 15px;
  color: color-mix(in srgb, var(--default-color), transparent 30%);
  margin-bottom: 0;
}

/*--------------------------------------------------------------
# Feature Details Section
--------------------------------------------------------------*/
.feature-details .features-item {
  color: color-mix(in srgb, var(--default-color), transparent 20%);
}

.feature-details .features-item+.features-item {
  margin-top: 100px;
}

@media (max-width: 640px) {
  .feature-details .features-item+.features-item {
    margin-top: 40px;
  }
}

.feature-details .features-item h3 {
  font-weight: 700;
  font-size: 26px;
}

.feature-details .features-item ul {
  list-style: none;
  padding: 0;
}

.feature-details .features-item ul li {
  padding-bottom: 10px;
  display: flex;
  align-items: center;
}

.feature-details .features-item ul li:last-child {
  padding-bottom: 0;
}

.feature-details .features-item ul i {
  font-size: 20px;
  padding-right: 4px;
  color: #587bf7;
}

.feature-details .features-item p:last-child {
  margin-bottom: 0;
}

/*--------------------------------------------------------------
# Gallery Section
--------------------------------------------------------------*/


  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top"style="background-color: #F2F5FB;">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">SİYAS</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Ana Sayfa</a></li>
          <li><a href="#about">Hakkında</a></li>
          <li><a href="#features">Özellikler</a></li>
          <li><a href="#gallery">Galeri</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="loginPage.php">Giriş Yap</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section" style="margin-top: -70px;">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/img2/ana2.png" class="img-fluid animated" alt="">
          </div>
          <div class="col-lg-6  d-flex flex-column justify-content-center text-center text-md-start" data-aos="fade-in">
            <h2>SÜT İZLEME VE YAPAY ZEKA ANALİZ SİSTEMİ</h2>
            <p>Dijitalleşen Çiftlikler, Karlı ve Verimli Hayvancılık </p>
            <div class="d-flex mt-4 justify-content-center justify-content-md-start">

            </div>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Hakkında</h2>
        <p>Geleneksel Yöntemlerin Ötesinde: SİYAS</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p>
              Teknolojiyi Tarım ve Hayvancılıkla Buluşturan Bir Ekip
              Projelerimiz, tarım ve hayvancılık sektörlerinde teknolojinin potansiyelini en üst düzeye çıkarmak ve bu
              alanlarda dönüşüm sağlamak amacıyla oluşturulmuştur.
              Amacımız, sektördeki geleneksel yöntemlerin ötesine geçerek, modern teknolojileri entegre ederek
              verimlilik, kalite ve sürdürülebilirlik sağlamak ve çiftçilere yenilikçi çözümler sunmaktır.
            </p>

          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <p>Ekip üyelerimiz, bu vizyonu gerçekleştirmek için alanlarında derin bilgi ve deneyime sahip
              profesyonellerden oluşmaktadır. Her bir üye, farklı uzmanlık alanlarıyla projelerimize değer katmakta ve
              bu sayede tarım ve hayvancılığın geleceğini şekillendirmekteyiz. </p>
            <a href="loginPage.php" class="read-more"><span>Daha fazla</span><i class="bi bi-arrow-right"></i></a>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Özellikler</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">

          <div class="col-xl-5 d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img2/1.png" class="img-fluid" alt="" style="margin-top: -40px;">
          </div>

          <div class="col-xl-7 d-flex" data-aos="fade-up" data-aos-delay="200">

            <div class="row align-self-center gy-5">

              <div class="col-md-6 icon-box" >
                <img src="assets/img2/rfid_5331700.png" alt="">
                <div>
                  <h4>Otomatik Kimliklendirme ve Süt Takibi</h4>
                  <p>RFID etiketleri ile büyükbaş hayvanlar otomatik olarak kimliklendirilir.
                    Sağım sistemi entegre RFID okuyucular, süt verilerini otomatik olarak toplar ve merkezi veri
                    tabanına kaydeder.</p>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6 icon-box">
                <img src="assets/img2/internet-things_11931415.png" alt="">
                <div>
                  <h4>Web ve Mobil Erişim</h4>
                  <p>PHP ile geliştirilmiş kullanıcı dostu web arayüzü üzerinden süt verileri ve hayvan bilgileri
                    görüntülenir.Uygulama, mobil ve web platformlarda erişilebilir, grafiklerle süt verim raporları
                    sunar.</P>

                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6 icon-box">
                <img src="assets/img2/artificial-intelligence_4616790.png" alt="">
                <div>
                  <h4>Chatbot Entegrasyonu</h4>
                  <p>Chatbot, süt üretimi ve diğer çiftlik bilgileri hakkında hızlı ve doğru cevaplar sağlar.</p>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6 icon-box">
                <img src="assets/img2/chart_6117361.png" alt="">
                <div>
                  <h4>Grafiklerle Verimlilik İzleme</h4>
                  <p>Süt verileri günlük ve dönemsel olarak grafiklerle sunulur.
                    Grafikler, süt miktarlarını kolayca izlemeyi sağlar ve veri trendlerini görselleştirir.</p>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6 icon-box">
                <img src="assets/img2/meat_14317226.png" alt="">
                <div>
                  <h4>Hayvan Bilgi Yönetimi</h4>
                  <p>Hayvan bilgileri kart veya liste şeklinde görüntülenir.
                    Hayvan bilgileri güncellenebilir ve silinebilir, yeni hayvanlar eklenebilir.</p>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6 icon-box">
                <img src="assets/img2/iot_6090969.png" alt="">
                <div>
                  <h4>IoT, MQTT Protokolü ve Veri Yönetimi</h4>
                  <p>Süt verileri ESP32 mikro denetleyici ve Raspberry Pi ile toplanır, MQTT protokolü ile veri tabanına
                    iletilir. MySQL veritabanında süt, RFID ve hayvan bilgileri saklanır. Günlük süt verileri
                    grafiklerle sunulur; grafiklere tıklanarak detaylar görüntülenebilir.</p>
                </div>
              </div><!-- End Feature Item -->

            </div>

          </div>

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Feature Details Section -->
    <section id="feature-details" class="feature-details section">

      <div class="container">

        <div class="row gy-4 align-items-center features-item" style="background-color: #F2F5FB;">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/img2/otomatik-kimliklendirme.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
            <h3>Otomatik Kimliklendirme ve Süt Takibi</h3>
            <p class="fst-italic">
              RFID etiketleri kullanarak büyükbaş hayvanların otomatik kimliklendirilmesi sağlanır. Her hayvana özel
              olarak tanımlanmış RFID etiketleri, hayvanın kimliğini anında ve güvenilir bir şekilde tanımlar. Bu
              etiketler, sağım sistemine entegre edilmiş RFID okuyucular tarafından okunur. Sağım sırasında, RFID
              okuyucular hayvanların etiketlerini tarar ve süt verilerini otomatik olarak toplar. Toplanan veriler,
              merkezi bir veri tabanına anlık olarak kaydedilir ve analiz edilmek üzere depolanır. Bu sistem, süt
              verimliliğini ve hayvan sağlığını izlemek için kapsamlı bir veri sağlar, böylece çiftçilere daha iyi
              yönetim ve karar verme imkanları sunar. Ayrıca, sistemin otomatik doğası, manuel veri girişi ihtiyacını
              ortadan kaldırır ve insan hatasını en aza indirir.
            </p>
            <ul>
              <li><i class="bi bi-check"></i><span> Otomatik Kimliklendirme</span></li>
              <li><i class="bi bi-check"></i> <span>Süt Verilerinin Otomatik Toplanması</span>
              </li>
              <li><i class="bi bi-check"></i> <span>Gerçek Zamanlı İzleme</span></li>
            </ul>
          </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
          <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img2/chatbot.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7 order-2 order-md-1" data-aos="fade-up" data-aos-delay="200">
            <h3>Chatbot Entegrasyonu</h3>
            <p class="fst-italic">
              Chatbot, süt üretimi ve diğer çiftlik bilgileri hakkında hızlı ve doğru cevaplar sağlar. Kullanıcılar,
              chatbot aracılığıyla sorularını anında sorabilir ve ihtiyaç duydukları bilgilere hızlıca ulaşabilirler.
              Chatbot, sistem verilerini kullanarak çiftlik yönetimi ile ilgili çeşitli konularda yardımcı olur ve
              süreçleri daha verimli hale getirir. Ayrıca, sıkça sorulan sorulara otomatik yanıtlar vererek, çiftlik
              personelinin zamanını tasarruf sağlar.
            </p>
            <ul>
              <li><i class="bi bi-check"></i><span> Hızlı ve Doğru Bilgi Sağlama</span></li>
              <li><i class="bi bi-check"></i> <span>Kullanıcı Sorgularına Anlık Yanıt</span>
              </li>
              <li><i class="bi bi-check"></i> <span>Verimlilik Artışı</span></li>
            </ul>
          </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item" style="background-color: #F2F5FB;">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out">
            <img src="assets/img2/hayvan-bilgi-yonetimi.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7" data-aos="fade-up">
            <h3>Hayvan Bilgi Yönetimi</h3>
            <p>Hayvan bilgileri kart veya liste şeklinde görüntülenir. Bu özellik sayesinde, kullanıcılar hayvanların
              bilgilerini kolayca takip edebilir ve yönetebilir. Hayvan bilgileri güncellenebilir, silinebilir ve yeni
              hayvanlar eklenebilir. Böylece, hayvan yönetimi daha düzenli ve etkili bir şekilde gerçekleştirilebilir.
              Kullanıcılar, hayvanların sağlık durumu, süt verimliliği ve diğer önemli bilgilerini düzenli olarak takip
              edebilirler.</p>
            <ul>
              <li><i class="bi bi-check"></i> <span>Bilgi Görüntüleme</span></li>
              <li><i class="bi bi-check"></i><span>Güncelleme ve Silme</span>
              </li>
              <li><i class="bi bi-check"></i> <span>Yeni Hayvan Ekleme</span>
              </li>
            </ul>
          </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item" >
          <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out">
            <img src="assets/img2/grafiklerle-verimlilik.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7 order-2 order-md-1" data-aos="fade-up">
            <h3>Grafiklerle Verimlilik İzleme</h3>
            <p class="fst-italic">
              Süt verileri, günlük ve dönemsel olarak grafiklerle sunulur. Ana sayfa, çiftlik ve günlük süt miktarları
              hakkında bilgi sağlar. Grafikler, hangi ineklerin sağıldığını, süt miktarlarını, en az ve en çok süt veren
              inekleri gösterir. Sabah ve akşam sağım verileri, görsel grafiklerle sunulur ve kullanıcılar, bu
              grafiklerdeki verilere tıklayarak detaylı inceleme sayfalarına yönlendirilir.
            </p>
            <ul>
              <li><i class="bi bi-check"></i> <span>Günlük ve Dönemsel Grafikler</span></li>
              <li><i class="bi bi-check"></i><span>Sabah ve Akşam Sağım Grafikleri</span>
              </li>
              <li><i class="bi bi-check"></i> <span>Bireysel İnceleme</span>
              </li>
            </ul>
          </div>

        </div><!-- Features Item -->
        <!-- Features Item -->

        <div class="row gy-4 align-items-center features-item" style="background-color: #F2F5FB;">
          <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out">
            <img src="assets/img2/web-mobile2.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7" data-aos="fade-up">
            <h3>Web ve Mobil Erişim</h3>
            <p>PHP ile geliştirilmiş kullanıcı dostu web arayüzü üzerinden süt verileri ve hayvan bilgileri
              görüntülenir. Uygulama, hem mobil hem de web platformlarda erişilebilir ve grafiklerle süt verim raporları
              sunar. Bu özellik, kullanıcıların herhangi bir cihazdan süt üretim verilerine ve hayvan bilgilerine
              kolayca erişmelerini sağlar.</p>
            <ul>
              <li><i class="bi bi-check"></i> <span>Kullanıcı Dostu Web Arayüzü</span></li>
              <li><i class="bi bi-check"></i><span>Mobil ve Web Platform Erişimi</span>
              </li>
              <li><i class="bi bi-check"></i> <span>Grafiklerle Verim Raporları</span>
              </li>
            </ul>
          </div>
        </div><!-- Features Item -->
        <!-- Features Item -->

        <div class="row gy-4 align-items-center features-item" >
          <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out">
            <img src="assets/img2/ıot.png" class="img-fluid" alt="">
          </div>
          <div class="col-md-7 order-2 order-md-1" data-aos="fade-up">
            <h3>IoT, MQTT Protokolü ve Veri Yönetimi</h3>
            <p class="fst-italic">
              Süt ölçüm verileri, ESP32 mikro denetleyici ve Raspberry Pi kullanılarak toplanır ve MQTT protokolü ile
              veri tabanına iletilir. Bu süreç, manuel işlemleri otomatikleştirir, verimliliği artırır ve hata riskini
              azaltır. Veritabanı yönetimi için MySQL kullanılır; süt verileri, RFID bilgileri ve hayvan bilgileri
              burada depolanır. Günlük süt verileri grafiklerle sunulur ve bu grafiklere tıklanarak detaylı bilgi elde
              edilebilir.
            </p>
            <ul>
              <li><i class="bi bi-check"></i> <span>Otomatik Veri Toplama</span></li>
              <li><i class="bi bi-check"></i><span>Veri Depolama ve Yönetimi</span>
              </li>
              <li><i class="bi bi-check"></i> <span>Veri Güncellemeleri ve Senkronizasyon</span>
              </li>
            </ul>
          </div>

        </div><!-- Features Item -->

      </div>

    </section><!-- /Feature Details Section -->

    <!-- Gallery Section -->
    <section id="gallery">
      <h2 style="text-align: center;" class="gallery" >Galeri</h2>
      <i class="center-text">Projelerimizi ve çalışmalarımızı görsellerle keşfedin. Her fotoğraf, yenilikçi
        çözümlerimizi
        ve katkılarımızı yansıtır.</i>
      <div class="slider">
        <div class="slides">
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik1.jpg" alt="Image 1"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik2.jpg" alt="Image 2"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik3.jpg" alt="Image 3"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik4.jpg" alt="Image 4"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik5.jpg" alt="Image 5"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik6.webp" alt="Image 6"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik7.jpg" alt="Image 7"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik8.jpg" alt="Image 8"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik9.webp" alt="Image 9"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik10.jpg" alt="Image 11"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik11.jpg" alt="Image 12"></div>
          <div class="slide"><img src="assets/img2/app-gallery/ciftlik12.jpg" alt="Image 13"></div>
          <!-- Diğer resimler -->
        </div>
        <div class="dots"></div>
      </div>

      <!-- GLightbox JS -->
      <script src="https://cdn.jsdelivr.net/npm/glightbox@3.0.0/dist/js/glightbox.min.js"></script>
      <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dotsContainer = document.querySelector('.dots');

        // Dinamik olarak noktaları ekle
        slides.forEach((slide, index) => {
          const dot = document.createElement('span');
          dot.classList.add('dot');
          dot.addEventListener('click', () => {
            currentSlide = index;
            document.querySelector('.slides').style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
          });
          dotsContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('.dot');

        function showNextSlide() {
          currentSlide = (currentSlide + 1) % slides.length;
          document.querySelector('.slides').style.transform = `translateX(-${currentSlide * 100}%)`;
          updateDots();
        }

        function updateDots() {
          dots.forEach((dot, index) => {
            dot.classList.remove('active');
            if (index === currentSlide) {
              dot.classList.add('active');
            }
          });
        }

        setInterval(showNextSlide, 3000);

        updateDots(); // İlk yüklemede noktaları güncelle

      </script>

    </section><!-- /Gallery Section -->

    <!-- Section Title -->
  </main>
  <footer id="footer" class="footer">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>SİYAS</h4>
            <p>HAYTEK</p>
            <p>MAKÜ Mühendislik Mimarlık Fakültesi</p>
          </div>
        </div>
      </div>
    </div>


    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SİYAS</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="homePage.php">animalTech</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>



  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>


  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
    

(function() {
  "use strict";

  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  mobileNavToggleBtn.addEventListener('click', mobileNavToogle);

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();
  </script>

</body>

</html>