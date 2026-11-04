<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';

$currentYear = date('Y');
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>TKR | Teknik Kendaraan Ringan</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #f5f6f7;
            color: #101820;
        }

        a {
            text-decoration: none;
        }

        .navbar {

            position: sticky;
            top: 0;
            z-index: 1000;

            min-height: 80px;

            background: #07131c;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 7%;

            box-shadow: 0 5px 25px rgba(0, 0, 0, .15);

        }

        .logo-icon {

            width: 45px;
            height: 45px;

            border-radius: 8px;

            background: #e51b23;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 25px;

        }

        .logo h2 {
            font-size: 24px;
            line-height: 1;
        }

        .logo span {

            display: block;

            font-size: 7px;

            letter-spacing: 1.5px;

            color: #aaa;

            margin-top: 5px;

        }

        nav {

            display: flex;
            align-items: center;
            gap: 8px;

        }

        nav a {

            color: #aaa;

            font-size: 12px;
            font-weight: 500;

            padding: 10px 14px;

            border-radius: 5px;

            transition: .3s;

        }

        nav a:hover,
        nav a.active {

            color: white;

            background: #e51b23;

        }

        .menu-toggle {

            display: none;

            color: white;

            font-size: 25px;

            cursor: pointer;

        }

        .hero {

            min-height: 650px;

            display: flex;
            align-items: center;

            padding: 80px 8%;

            position: relative;

            overflow: hidden;

            background:

                linear-gradient(
                    90deg,
                    #07131c 0%,
                    rgba(7, 19, 28, .95) 45%,
                    rgba(7, 19, 28, .65) 100%
                ),

                url("img/galeri2.jpg");

            background-size: cover;

            background-position: center;

        }

        .hero-content {

            position: relative;

            z-index: 2;

            max-width: 700px;

        }

        .small-title {

            color: #e51b23;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 4px;

            margin-bottom: 18px;

        }

        .hero h1 {

            color: white;

            font-size: clamp(50px, 8vw, 90px);

            line-height: .95;

            font-weight: 800;

            letter-spacing: -3px;

        }

        .hero h1 span {

            display: block;

            color: #e51b23;

        }

        .hero-text {

            color: #bfc4c7;

            max-width: 500px;

            font-size: 14px;

            line-height: 1.8;

            margin-top: 25px;

        }

        .hero-buttons {

            display: flex;

            gap: 12px;

            margin-top: 30px;

            flex-wrap: wrap;

        }

        .btn {

            display: inline-block;

            padding: 13px 22px;

            border-radius: 5px;

            font-size: 12px;

            font-weight: 600;

            transition: .3s;

        }

        .btn.red {

            background: #e51b23;

            color: white;

        }

        .btn.red:hover {

            background: white;

            color: #e51b23;

            transform: translateY(-3px);

        }

        .btn.outline {

            color: white;

            border: 1px solid #777;

        }

        .btn.outline:hover {

            border-color: #e51b23;

            color: #e51b23;

        }

        .stats {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            background: white;

        }

        .stat {

            padding: 30px 15px;

            text-align: center;

            border-right: 1px solid #eee;

            cursor: pointer;

            transition: .3s;

        }

        .stat:hover {

            background: #07131c;

            color: white;

            transform: translateY(-5px);

        }

        .stat strong {

            display: block;

            font-size: 32px;

            color: #e51b23;

        }

        .stat span {

            display: block;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 1px;

        }

        .stat small {

            display: block;

            color: #999;

            font-size: 8px;

            margin-top: 5px;

        }

        .section {

            padding: 90px 8%;

            scroll-margin-top: 80px;

        }

        .section-title {

            display: flex;

            align-items: end;

            justify-content: space-between;

            margin-bottom: 35px;

        }

        .section-title span {

            color: #e51b23;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 3px;

        }

        .section-title h2 {

            font-size: 32px;

            margin-top: 6px;

        }

        .cards {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 25px;

        }

        .card {

            background: white;

            border-radius: 9px;

            overflow: hidden;

            box-shadow:
                0 8px 25px rgba(0,0,0,.07);

            transition: .3s;

        }

        .card:hover {

            transform: translateY(-8px);

            box-shadow:
                0 18px 40px rgba(0,0,0,.13);

        }

        .card img {

            width: 100%;

            height: 220px;

            object-fit: cover;

        }

        .card-content {

            padding: 23px;

        }

        .card-content small {

            color: #e51b23;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 2px;

        }

        .card-content h3 {

            font-size: 17px;

            margin: 8px 0;

        }

        .card-content p {

            color: #777;

            font-size: 11px;

            line-height: 1.8;

        }

        .card-content button {

            border: none;

            background: none;

            color: #e51b23;

            font-family: inherit;

            font-size: 11px;

            font-weight: 600;

            cursor: pointer;

            margin-top: 15px;

        }

        .gallery-grid {

            display: grid;

            grid-template-columns:
                repeat(4,1fr);

            gap: 15px;

        }

        .gallery-item {

            height: 230px;

            position: relative;

            overflow: hidden;

            border-radius: 8px;

            cursor: pointer;

        }

        .gallery-item img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            transition: .5s;

        }

        .gallery-item:hover img {

            transform: scale(1.1);

        }

        .gallery-overlay {

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            padding: 20px;

            color: white;

            background:
                linear-gradient(
                    transparent,
                    rgba(0,0,0,.85)
                );

        }

        .gallery-overlay span {

            color: #e51b23;

            font-size: 9px;

            font-weight: 700;

        }

        .gallery-overlay h3 {

            font-size: 14px;

            margin-top: 3px;

        }

        .about-grid {

            display: grid;

            grid-template-columns: 1.3fr 1fr;

            gap: 60px;

            align-items: center;

        }

        .red-label {

            color: #e51b23;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 2px;

        }

        .about-grid h2 {

            font-size: 35px;

            margin: 8px 0 20px;

        }

        .about-grid p {

            color: #777;

            font-size: 13px;

            line-height: 1.9;

            margin-bottom: 15px;

        }

        .about-box {

            background: #07131c;

            padding: 10px;

            border-radius: 10px;

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 1px;

        }

        .about-box div {

            background: #101d26;

            padding: 30px 10px;

            text-align: center;

            color: white;

        }

        .about-box strong {

            display: block;

            color: #e51b23;

            font-size: 30px;

        }

        .about-box span {

            color: #bbb;

            font-size: 9px;

        }

        .dark-section {

            background: #07131c;

            color: white;

        }

        .dark-section .section-title h2 {

            color: white;

        }

        .competency-grid {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 20px;

        }

        .competency {

            background: #101d26;

            padding: 30px;

            border-radius: 8px;

            transition: .3s;

        }

        .competency:hover {

            transform: translateY(-6px);

            border-bottom: 3px solid #e51b23;

        }

        .competency-number {

            color: #e51b23;

            font-weight: 700;

        }

        .competency h3 {

            margin: 15px 0 8px;

        }

        .competency p {

            color: #aaa;

            font-size: 11px;

            line-height: 1.7;

        }

        .contact-grid {

            display: grid;

            grid-template-columns: 1fr;

            gap: 60px;

        }

        .contact-info h2 {

            font-size: 35px;

            margin: 8px 0 15px;

        }

        .contact-info > p {

            color: #777;

            font-size: 13px;

            line-height: 1.8;

            margin-bottom: 25px;

        }

        .contact-item {

            display: flex;

            gap: 15px;

            margin-bottom: 20px;

        }

        .contact-icon {

            min-width: 45px;

            height: 45px;

            border-radius: 7px;

            background: #ffe8e8;

            color: #e51b23;

            display: flex;

            align-items: center;

            justify-content: center;

        }

        .contact-item h3 {

            font-size: 13px;

        }

        .contact-item p {

            color: #888;

            font-size: 11px;

        }

        .image-modal {

            display: none;

            position: fixed;

            z-index: 5000;

            inset: 0;

            background:
                rgba(0,0,0,.9);

            align-items: center;

            justify-content: center;

            padding: 30px;

        }

        .image-modal.show {

            display: flex;

        }

        .image-modal img {

            max-width: 90%;

            max-height: 85vh;

            object-fit: contain;

            border-radius: 8px;

            animation: zoom .3s;

        }

        @keyframes zoom {

            from {

                transform: scale(.7);

                opacity: 0;

            }

            to {

                transform: scale(1);

                opacity: 1;

            }
        }

        .image-close {

            position: absolute;

            top: 25px;

            right: 35px;

            color: white;

            font-size: 40px;

            cursor: pointer;

        }

        .image-title {

            position: absolute;

            bottom: 25px;

            left: 0;

            right: 0;

            text-align: center;

            color: white;

            font-size: 13px;

        }

        .modal {

            display: none;

            position: fixed;

            inset: 0;

            z-index: 4000;

            background:
                rgba(0,0,0,.75);

            align-items: center;

            justify-content: center;

            padding: 20px;

        }

        .modal.show {

            display: flex;

        }

        .modal-box {

            width: 100%;

            max-width: 600px;

            max-height: 85vh;

            overflow-y: auto;

            background: white;

            border-radius: 10px;

        }

        .modal-header {

            background: #07131c;

            color: white;

            padding: 22px;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }

        .modal-header span {

            color: #e51b23;

            font-size: 9px;

            letter-spacing: 2px;

        }

        .modal-header h2 {

            margin-top: 5px;

        }

        .close {

            width: 35px;

            height: 35px;

            border: none;

            border-radius: 50%;

            background: #e51b23;

            color: white;

            font-size: 22px;

            cursor: pointer;

        }

        .modal-body {

            padding: 25px;

        }

        .search {

            width: 100%;

            padding: 12px;

            border: 1px solid #ddd;

            border-radius: 5px;

            margin-bottom: 15px;

            outline: none;

            font-family: inherit;

        }

        .student {

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 13px;

            margin-bottom: 8px;

            background: #f6f6f6;

            border-radius: 6px;

        }

        .student-number {

            width: 35px;

            height: 35px;

            background: #07131c;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 5px;

            font-size: 10px;

        }

        .student h3 {

            font-size: 12px;

        }

        .student p {

            color: #888;

            font-size: 9px;

        }

        footer {

            background: #050d13;

            color: white;

            padding: 60px 8%;

            display: grid;

            grid-template-columns: 2fr 1fr 1fr;

            gap: 50px;

        }

        footer h2 {

            margin-bottom: 15px;

        }

        footer h3 {

            font-size: 14px;

            margin-bottom: 15px;

        }

        footer p,
        footer a {

            color: #888;

            font-size: 11px;

            line-height: 1.8;

        }

        footer a {

            display: block;

            margin-bottom: 8px;

        }

        footer a:hover {

            color: #e51b23;

        }

        .copyright {

            background: #02070a;

            color: #666;

            text-align: center;

            padding: 15px;

            font-size: 9px;

        }

        @media(max-width:900px) {

            nav {

                position: absolute;

                top: 80px;

                left: 0;

                width: 100%;

                background: #07131c;

                display: none;

                flex-direction: column;

                padding: 15px;

            }

            nav.show {

                display: flex;

            }

            nav a {

                width: 100%;

                text-align: center;

            }

            .menu-toggle {

                display: block;

            }

            .cards {

                grid-template-columns: 1fr;

            }

            .gallery-grid {

                grid-template-columns: repeat(2, 1fr);

            }

            .about-grid,
            .contact-grid {

                grid-template-columns: 1fr;

            }

            .competency-grid {

                grid-template-columns: repeat(2, 1fr);

            }

            footer {

                grid-template-columns:
                    1fr 1fr;

            }

        }

        @media(max-width:600px) {

            .hero {

                padding: 60px 6%;

            }

            .hero h1 {

                font-size: 52px;

            }

            .section {

                padding: 60px 6%;

            }

            .stats {

                grid-template-columns:
                    1fr 1fr;

            }

            .gallery-grid {

                grid-template-columns: 1fr;

            }

            .gallery-item {

                height: 250px;

            }

            .competency-grid {

                grid-template-columns: 1fr;

            }

            footer {

                grid-template-columns: 1fr;

            }

        }

    </style>

</head>
<body>

<header class="navbar">
    <div class="logo">

        <div class="logo">
            <img src="smk.png" alt="" height="50px" width="50px" style="margin-top: 20px;">
        </div>
        <div>
            <span>
                TEKNIK KENDARAAN RINGAN
            </span>
        </div>
    </div>

    <nav id="navMenu">

        <a href="#beranda"
           class="active"
           onclick="activeMenu(this)">
            Beranda
        </a>

        <a href="#artikel"
           onclick="activeMenu(this)">
            Artikel
        </a>

        <a href="#galeri"
           onclick="activeMenu(this)">
            Galeri
        </a>

        <a href="#tentang"
           onclick="activeMenu(this)">
            Tentang Jurusan
        </a>

        <a href="#kontak"
           onclick="activeMenu(this)">
            Kontak
        </a>

        <?php if ($user === null): ?>
            <a href="login.php"
               onclick="activeMenu(this)">
                Login
            </a>

            <a href="daftar.php"
               onclick="activeMenu(this)">
                Daftar
            </a>
        <?php else: ?>
            <a href="login.php"
               onclick="activeMenu(this)">
                Login
            </a>

            <a href="#beranda"
               onclick="activeMenu(this)">
                Role: <?= htmlspecialchars(strtoupper(currentRole()), ENT_QUOTES, 'UTF-8') ?>
            </a>

            <?php if (isAdmin()): ?>
                <a href="admin.php"
                   onclick="activeMenu(this)">
                    Admin
                </a>
            <?php endif; ?>

            <a href="logout.php"
               onclick="activeMenu(this)">
                Logout
            </a>
        <?php endif; ?>


    </nav>

    <div class="menu-toggle"
         onclick="toggleMenu()">

        ☰

    </div>

</header>

<section class="hero"
         id="beranda">

    <div class="hero-content">

        <p class="small-title">
            SMK • TEKNIK OTOMOTIF
        </p>

        <h1>

            TEKNIK

            <span>
                KENDARAAN
            </span>

            RINGAN

        </h1>


        <p class="hero-text">

            Mencetak generasi otomotif yang kompeten,
            kreatif, disiplin, dan siap kerja.

        </p>

        <div class="hero-buttons">

            <a href="#tentang"
               class="btn red">

                Lihat Profil

            </a>

            <a href="#galeri"
               class="btn outline">

                Galeri Kegiatan

            </a>

        </div>

    </div>

</section>

<section class="stats">


    <div class="stat"
         onclick="openData('siswaModal')">

        <strong>
            128
        </strong>

        <span>
            SISWA AKTIF
        </span>

        <small>
            Klik untuk melihat data
        </small>

    </div>

    <div class="stat"
         onclick="openData('guruModal')">

        <strong>
            12
        </strong>

        <span>
            GURU PRODUKTIF
        </span>

        <small>
            Klik untuk melihat data
        </small>

    </div>

    <div class="stat"
         onclick="openData('bengkelModal')">

        <strong>
            3
        </strong>

        <span>
            BENGKEL
        </span>

        <small>
            Klik untuk melihat data
        </small>

    </div>

    <div class="stat"
         onclick="openData('prestasiModal')">

        <strong>
            24
        </strong>

        <span>
            PRESTASI
        </span>

        <small>
            Klik untuk melihat data
        </small>

    </div>


</section>

<section class="section"
         id="artikel">


    <div class="section-title">

        <div>

            <span>
                INFORMASI
            </span>

            <h2>
                Artikel Terbaru
            </h2>

        </div>

    </div>

    <div class="cards">

        <article class="card">

            <img src="R4.jpeg"
                 alt="Praktik Ganti ban">

            <div class="card-content">

                <small>
                    PRAKTIK
                </small>
                <h3>
                    Praktik Ganti Ban
                </h3>
                <p>
                    Siswa TKR melakukan praktik
                    pemeriksaan dan perawatan ban kendaraan.
                </p>
                <button
                    onclick="showArticle(
                    'Praktik Ganti Ban',
                    'Kegiatan ini memberikan pengalaman langsung kepada siswa dalam melakukan pemeriksaan, perawatan, dan pengecekan ban kendaraan.'
                    )">

                    Baca Selengkapnya →

                </button>
            </div>
        </article>
        <article class="card">
            <img src="R5.jpeg"
                 alt="Praktik servis mesin">

            <div class="card-content">
                <small>
                    PRAKTIK
                </small>
                <h3>
                    Praktik Servis Mesin
                </h3>
                <p>
                    Siswa mempelajari sistem servis mesin
                    kendaraan melalui kegiatan praktik.
                </p>
                <button
                    onclick="showArticle(
                    'Praktik Servis Mesin',
                    'Dalam kegiatan ini siswa mempelajari komponen servis mesin kendaraan dan cara melakukan pemeriksaan sistem servis mesin dengan benar.'
                    )">

                    Baca Selengkapnya →

                </button>
            </div>
        </article>

        <article class="card">
            <img src="R6.jpg"
                 alt="Praktek servis mesin kendaraan">

            <div class="card-content">
                <small>
                    PRAKTIK
                </small>
                <h3>
                    Praktik servis mesin kendaraan
                </h3>
                <p>
                    Siswa mendapatkan pengalaman mengenai
                    dunia kerja otomotif.
                </p>
                <button
                    onclick="showArticle(
                    'Praktik Servis Mesin Kendaraan',
                    'Siswa mendapatkan pengalaman langsung dalam melakukan servis mesin kendaraan di lingkungan yang mirip dengan dunia kerja.'
                    )">

                    Baca Selengkapnya →

                </button>
            </div>
        </article>
    </div>
</section>

<section class="section"
         id="galeri">

    <div class="section-title">

        <div>

            <span>
                DOKUMENTASI
            </span>

            <h2>
                Galeri Kegiatan
            </h2>

        </div>

    </div>

    <div class="gallery-grid">

        <div class="gallery-item"
             onclick="openImage(
             'img/galeri1.jpg',
             'Praktik Mesin'
             )">

            <img src="R8.jpg"
                 alt="Praktik Mesin">

            <div class="gallery-overlay">

                <span>
                    PRAKTIK
                </span>

                <h3>
                    Praktik Mesin
                </h3>

            </div>

        </div>

        <div class="gallery-item"
             onclick="openImage(
             'img/galeri2.jpg',
             'Praktik Kelistrikan'
             )">

            <img src="R7.jpg"
                 alt="Praktik Kelistrikan">

            <div class="gallery-overlay">

                <span>
                    PRAKTIK
                </span>

                <h3>
                    Praktik Kelistrikan
                </h3>

            </div>

        </div>

        <div class="gallery-item"
             onclick="openImage(
             'img/galeri3.jpg',
             'Kegiatan Bengkel'
             )">

            <img src="R4.jpeg"
                 alt="Kegiatan Bengkel">

            <div class="gallery-overlay">

                <span>
                    KEGIATAN
                </span>

                <h3>
                    Kegiatan Bengkel
                </h3>

            </div>

        </div>

        <div class="gallery-item"
             onclick="openImage(
             'img/galeri4.jpg',
             'Kunjungan Industri'
             )">

            <img src="R5.jpeg"
                 alt="Kunjungan Industri">

            <div class="gallery-overlay">

                <span>
                    INDUSTRI
                </span>

                <h3>
                    Kunjungan Industri
                </h3>

            </div>

        </div>


    </div>

</section>

<section class="section"
         id="tentang">


    <div class="about-grid">


        <div>

            <span class="red-label">
                TENTANG JURUSAN
            </span>


            <h2>
                Teknik Kendaraan Ringan
            </h2>


            <p>

                Teknik Kendaraan Ringan atau TKR
                merupakan kompetensi keahlian yang
                mempelajari perawatan dan perbaikan
                kendaraan ringan.

            </p>


            <p>

                Siswa dibekali teori dan praktik mengenai
                mesin, kelistrikan, transmisi, chassis,
                sistem rem, suspensi, dan teknologi
                otomotif.

            </p>

        </div>



        <div class="about-box">


            <div>

                <strong>
                    128
                </strong>

                <span>
                    Siswa Aktif
                </span>

            </div>


            <div>

                <strong>
                    12
                </strong>

                <span>
                    Guru Produktif
                </span>

            </div>


            <div>

                <strong>
                    3
                </strong>

                <span>
                    Bengkel
                </span>

            </div>


            <div>

                <strong>
                    24
                </strong>

                <span>
                    Prestasi
                </span>

            </div>


        </div>

    </div>

</section>

<section class="section dark-section">


    <div class="section-title">

        <div>

            <span>
                KOMPETENSI
            </span>

            <h2>
                Yang Dipelajari
            </h2>

        </div>

    </div>



    <div class="competency-grid">


        <div class="competency">

            <div class="competency-number">
                01
            </div>

            <h3>
                Mesin
            </h3>

            <p>
                Mempelajari sistem mesin,
                pemeriksaan, dan perawatan
                kendaraan.
            </p>

        </div>



        <div class="competency">

            <div class="competency-number">
                02
            </div>

            <h3>
                Kelistrikan
            </h3>

            <p>
                Mempelajari sistem kelistrikan
                kendaraan dan cara pemeriksaannya.
            </p>

        </div>

        <div class="competency">

            <div class="competency-number">
                03
            </div>

            <h3>
                Chassis
            </h3>

            <p>
                Mempelajari sistem chassis,
                suspensi, kemudi, dan rem.
            </p>

        </div>

        <div class="competency">

            <div class="competency-number">
                04
            </div>

            <h3>
                Transmisi
            </h3>

            <p>
                Mempelajari sistem pemindah
                tenaga kendaraan.
            </p>

        </div>


    </div>

</section>

<section class="section"
         id="kontak">


    <div class="contact-grid">


        <div class="contact-info">

            <span class="red-label">
                INFORMASI KONTAK
            </span>


            <h2>
                Hubungi Jurusan TKR
            </h2>


            <p>

                Silakan hubungi jurusan TKR untuk
                mendapatkan informasi mengenai
                kegiatan dan pembelajaran otomotif.

            </p>



            <div class="contact-item">

                <div class="contact-icon">
                    📍
                </div>

                <div>

                    <h3>
                        Alamat
                    </h3>

                    <p>
                        Jalan talagasari,No 10,kawali mukti Kabupaten Ciamis, Jawa Barat, Indonesia
                    </p>

                </div>

            </div>



            <div class="contact-item">

                <div class="contact-icon">
                    📞
                </div>

                <div>

                    <h3>
                        Telepon
                    </h3>

                    <p>
                        087826123214
                    </p>

                </div>

            </div>



            <div class="contact-item">

                <div class="contact-icon">
                    ✉
                </div>

                <div>

                    <h3>
                        Email
                    </h3>

                    <p>
                        smkn1kawali.sch.id
                    </p>

                </div>

            </div>

        </div>



    </div>

</section>



<!-- ==========================================
     FOOTER
=========================================== -->

<footer>


    <div>
        <h2>
            ⚙ TKR
        </h2>
        <p>
            Jurusan Teknik Kendaraan Ringan
            yang mencetak lulusan kompeten
            di bidang otomotif.
        </p>
    </div>

    <div>
        <h3>
            Menu
        </h3>
        <a href="#beranda">
            Beranda
        </a>
        <a href="#artikel">
            Artikel
        </a>
        <a href="#galeri">
            Galeri
        </a>
        <a href="#tentang">
            Tentang Jurusan
        </a>
        <a href="#kontak">
            Kontak
        </a>
    </div>

    <div>
        <h3>
            Hubungi Kami
        </h3>
        <p>
            📞 087826123214
        </p>
        <p>
            ✉ smkn1kawali.sch.id
        </p>
        <p>
            📍
             Jalan talagasari,No 10,kawali mukti Kabupaten Ciamis, Jawa Barat, Indonesia
        </p>
    </div>

</footer>
<div class="copyright">
    © <?= htmlspecialchars($currentYear, ENT_QUOTES, 'UTF-8') ?> M.arif Jastin Firda Nina Achmad
</div>

<div class="image-modal"
     id="imageModal"
     onclick="closeImage()">

    <span class="image-close">
        ×
    </span>
    <img id="modalImage"
         src=""
         alt="Foto">
    <div class="image-title"
         id="imageTitle">
    </div>
</div>

<div class="modal"
     id="siswaModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span>
                    DATA JURUSAN
                </span>
                <h2>
                    Daftar Siswa
                </h2>
            </div>
            <button class="close"
                    onclick="closeData('siswaModal')">

                ×

            </button>

        </div>


        <div class="modal-body">


            <input
                type="text"
                class="search"
                placeholder="Cari nama siswa..."
                onkeyup="searchStudent(this)"
            >


            <div id="studentList">


                <div class="student">

                    <div class="student-number">
                        01
                    </div>

                    <div>

                        <h3>
                            Ahmad Fauzan
                        </h3>

                        <p>
                            XI TKR 1
                        </p>

                    </div>

                </div>


                <div class="student">

                    <div class="student-number">
                        02
                    </div>

                    <div>

                        <h3>
                            Andi Setiawan
                        </h3>

                        <p>
                            XI TKR 1
                        </p>

                    </div>

                </div>


                <div class="student">

                    <div class="student-number">
                        03
                    </div>

                    <div>

                        <h3>
                            Bima Pratama
                        </h3>

                        <p>
                            XI TKR 1
                        </p>

                    </div>

                </div>


                <div class="student">

                    <div class="student-number">
                        04
                    </div>

                    <div>

                        <h3>
                            Dimas Saputra
                        </h3>

                        <p>
                            XI TKR 2
                        </p>

                    </div>

                </div>


                <div class="student">

                    <div class="student-number">
                        05
                    </div>

                    <div>

                        <h3>
                            Fajar Ramadhan
                        </h3>

                        <p>
                            XI TKR 2
                        </p>

                    </div>

                </div>


                <div class="student">

                    <div class="student-number">
                        06
                    </div>

                    <div>

                        <h3>
                            Rizky Firmansyah
                        </h3>

                        <p>
                            XI TKR 2
                        </p>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>

<div class="modal" id="guruModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span>DATA JURUSAN</span>
                <h2>Guru Produktif</h2>
            </div>
            <button class="close" onclick="closeData('guruModal')">×</button>
        </div>
        <div class="modal-body">
            <div class="student">
                <div class="student-number">01</div>
                <div><h3>Drs. Dedi Mulyadi</h3><p>Teknik Dasar Otomotif</p></div>
            </div>
            <div class="student">
                <div class="student-number">02</div>
                <div><h3>Rina Marlina, S.Pd.</h3><p>Pemeliharaan Mesin Kendaraan</p></div>
            </div>
            <div class="student">
                <div class="student-number">03</div>
                <div><h3>Agus Setiawan, S.T.</h3><p>Kelistrikan Kendaraan Ringan</p></div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="bengkelModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span>DATA JURUSAN</span>
                <h2>Bengkel Praktik</h2>
            </div>
            <button class="close" onclick="closeData('bengkelModal')">×</button>
        </div>
        <div class="modal-body">
            <div class="student">
                <div class="student-number">01</div>
                <div><h3>Bengkel Mesin</h3><p>Praktik servis dan perawatan mesin</p></div>
            </div>
            <div class="student">
                <div class="student-number">02</div>
                <div><h3>Bengkel Kelistrikan</h3><p>Praktik sistem kelistrikan kendaraan</p></div>
            </div>
            <div class="student">
                <div class="student-number">03</div>
                <div><h3>Bengkel Chassis</h3><p>Praktik rem, suspensi, dan kemudi</p></div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="prestasiModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span>DATA JURUSAN</span>
                <h2>Prestasi Siswa</h2>
            </div>
            <button class="close" onclick="closeData('prestasiModal')">×</button>
        </div>
        <div class="modal-body">
            <div class="student">
                <div class="student-number">01</div>
                <div><h3>Juara 1 Lomba Kompetensi Siswa</h3><p>Tingkat Kabupaten - 2024</p></div>
            </div>
            <div class="student">
                <div class="student-number">02</div>
                <div><h3>Juara 2 Servis Mesin</h3><p>Tingkat Provinsi - 2023</p></div>
            </div>
            <div class="student">
                <div class="student-number">03</div>
                <div><h3>Finalis Kontes Otomotif</h3><p>Tingkat Nasional - 2023</p></div>
            </div>
        </div>
    </div>
</div>

<script>

    function toggleMenu() {

        const menu =
            document.getElementById("navMenu");

        menu.classList.toggle("show");

    }

    function activeMenu(element) {

        document
            .querySelectorAll("nav a")
            .forEach(function(link) {

                link.classList.remove("active");

            });

        element.classList.add("active");

        document
            .getElementById("navMenu")
            .classList.remove("show");

    }

    function openImage(image, title) {

        const modal =
            document.getElementById("imageModal");

        const modalImage =
            document.getElementById("modalImage");

        const imageTitle =
            document.getElementById("imageTitle");


        modalImage.src = image;

        imageTitle.innerText = title;

        modal.classList.add("show");

        document.body.style.overflow =
            "hidden";

    }

    function closeImage() {

        document
            .getElementById("imageModal")
            .classList.remove("show");

        document.body.style.overflow =
            "auto";

    }

    function openData(id) {

        document
            .getElementById(id)
            .classList.add("show");

        document.body.style.overflow =
            "hidden";

    }

    function closeData(id) {

        document
            .getElementById(id)
            .classList.remove("show");

        document.body.style.overflow =
            "auto";

    }

    function searchStudent(input) {

        const keyword =
            input.value.toLowerCase();

        const students =
            document.querySelectorAll(
                ".student"
            );

        students.forEach(
            function(student) {

                const text =
                    student.innerText.toLowerCase();


                if (
                    text.includes(keyword)
                ) {

                    student.style.display =
                        "flex";

                } else {

                    student.style.display =
                        "none";

                }

            }
        );

    }

    function showArticle(title, text) {

        alert(
            title +
            "\n\n" +
            text
        );

    }

    window.addEventListener(
        "click",
        function(event) {

            if (
                event.target.classList.contains(
                    "modal"
                )
            ) {

                event.target.classList.remove(
                    "show"
                );

                document.body.style.overflow =
                    "auto";

            }

        }
    );

    document.addEventListener(
        "keydown",
        function(event) {

            if (
                event.key === "Escape"
            ) {

                document
                    .querySelectorAll(
                        ".modal, .image-modal"
                    )
                    .forEach(
                        function(element) {

                            element.classList.remove(
                                "show"
                            );

                        }
                    );


                document.body.style.overflow =
                    "auto";

            }

        }
    );


</script>

</body>

</html>