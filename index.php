<!-- Veritabanı bağlantısının olduğu dosyayı dahil et -->
<?php include("baglanti.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.8/css/line.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles/swiper-bundle.min.css" />
    <link rel="stylesheet" href="styles/style.css" />
    <title>Document</title>
  </head>
  <body>
    <!-- =================================STYLE SWITCHER================================= -->
    <input type="radio" name="color" id="color-1" />
    <input type="radio" name="color" id="color-2" />
    <input type="radio" name="color" id="color-3" />
    <input type="radio" name="color" id="color-4" />
    <input type="radio" name="color" id="color-5" />
    <input type="radio" name="color" id="color-6" />
    <input type="radio" name="color" id="color-7" />
    <input type="radio" name="color" id="color-8" />
    <input type="radio" name="color" id="color-9" />
    <input type="radio" name="color" id="color-10" />
    <input type="checkbox" id="toggler" />
    <input type="checkbox" id="day-night" />

    <div class="style__switcher">
      <label for="toggler" class="style__switcher-toggler">
        <i class="fa-solid fa-gear fa-spin"></i
      ></label>

      <label for="day-night" class="style__switcher-theme">
        <i class="fa-solid fa-sun"></i>
        <i class="fa-solid fa-moon"></i
      ></label>

      <h3 class="style__switcher-title">Temalar</h3>

      <div class="style__switcher-colors">
        <label for="color-1" class="color-1 color"></label>
        <label for="color-2" class="color-2 color"></label>
        <label for="color-3" class="color-3 color"></label>
        <label for="color-4" class="color-4 color"></label>
        <label for="color-5" class="color-5 color"></label>
        <label for="color-6" class="color-6 color"></label>
        <label for="color-7" class="color-7 color"></label>
        <label for="color-8" class="color-8 color"></label>
        <label for="color-9" class="color-9 color"></label>
        <label for="color-10" class="color-10 color"></label>
      </div>
    </div>

    <!-- =================================sidebar================================= -->
    <div class="nav__toggle" id="nav-toggle">
      <i class="uil uil-bars"></i>
    </div>

    <aside class="sidebar" id="sidebar">
      <nav class="nav">
        <div class="nav__logo">
          <a href="index.html" class="nav__logo-text">M</a>
        </div>
        <div class="nav__menu">
          <div class="menu">
            <ul class="nav__list">
              <li class="nav__item">
                <a href="#home" class="nav__link active-link"
                  >Anasayfa</a>
              </li>
              <li class="nav__item">
                <a href="#about" class="nav__link">Hakkımda</a>
              </li>
              <li class="nav__item">
                <a href="#work" class="nav__link">Deneyimlerim </a>
              </li>

              <li class="nav__item">
                <a href="#skills" class="nav__link">Yetkinliklerim </a>
              </li>
              <li class="nav__item">
                <a href="#proje" class="nav__link">Projelerim </a>
              </li>
             <li class="nav__item">
                <a href="#sertifika" class="nav__link">Sertifikalarım </a>
              </li> 

              <li class="nav__item">
                <a href="#referance" class="nav__link"> Referanslarım</a>
              </li>

              <li class="nav__item">
                <a href="#contact" class="nav__link">İletişim</a>
              </li>
            </ul>
          </div>
        </div>

        <!-- <div class="btn__share">
          <i class="uil uil-share-alt social__share"></i>
        </div> -->

        <div class="nav__close" id="nav-close">
          <i class="uil uil-times"></i>
        </div>
      </nav>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <!-- =================================HOME================================= -->
      <section class="home" id="home">
        <div class="home__container container grid">
        <?php
          // Veritabanından verileri sorgula
          $sql = "SELECT linkedin, github, medium FROM anasayfa ORDER BY id DESC LIMIT 1";
          $result = $baglan->query($sql);

          if ($result->num_rows > 0) {
            // Verileri döngüyle al
            $row = $result->fetch_assoc();
            $linkedin_url = $row["linkedin"];
            $github_url = $row["github"];
            $medium_url = $row["medium"];
          } else {
            echo "Veritabanında kayıt bulunamadı";
          }
        ?>

        <!-- Sosyal medya butonlarına veritabnında kayıtlı linkleri eklemek -->
        <div class="home__social">
            <span class="home__social-follow">Beni Takip Et!</span>
            <div class="home__social-links">
            <a href="<?php echo $linkedin_url; ?>" target="_blank" class="home__social-link"><i class="uil uil-linkedin"></i></a>
            <a href="<?php echo $github_url; ?>" target="_blank" class="home__social-link"><i class="uil uil-github"></i></a>
            <a href="<?php echo $medium_url; ?>" target="_blank" class="home__social-link"><i class="uil uil-medium-m"></i></a>
            </div>
        </div>

        <div class="home__data">
            <h1 class="home__title">Merhaba, Ben Mervenur!</h1>
            <h3 class="home__subtitle">Yazılım Öğrencisi</h3>
            <div class="home__description">
            <?php
              // Anasayfa içeriğini al
              $query = "SELECT icerik FROM anasayfa ORDER BY id DESC LIMIT 1";
              $result = $baglan->query($query);

              $anasayfaIcerik = "";

              if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                $anasayfaIcerik = $row["icerik"];
                }
              }
              echo isset($anasayfaIcerik) ? $anasayfaIcerik : "İçerik bulunamadı";
            ?>
            </div>
            <a href="#about" class="button"><i class="uil uil-user button__icon"></i> Beni Tanıyın!</a>
          </div>

          <!-- Giriş sayfası fotoğraf -->
          <div class="home__img-wrapper">
            <img src="images/home-img.png" alt="" class="home__img" />
          </div>

          <!-- İletişim bilgi -->
          <div class="my__info">
            <div class="info__item">
              <i class="uil uil-facebook-messenger-alt info__icon"></i>
              <div>
                <h3 class="info__title">Messenger</h3>
                <span class="info__subtitle">user.ts123</span>
              </div>
            </div>

            <div class="info__item">
              <i class="uil uil-whatsapp info__icon"></i>
              <div>
                <h3 class="info__title">WhatsApp</h3>
                <span class="info__subtitle">6161-616-16-16</span>
              </div>
            </div>

            <div class="info__item">
              <i class="uil uil-envelope-edit info__icon"></i>
              <div>
                <h3 class="info__title">Email</h3>
                <span class="info__subtitle">mevenuraltunkaya1@gmail.com</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- =================================ABOUT================================= -->
      <section class="about section" id="about">
        <h2 data-heading="Benim" class="section__title">Hakkımda</h2>

        <div class="about__container container grid">
          <img src="images/mervenur.jpg" alt="" class="about__img" />
          <div class="about__data">
            <h3 class="about__heading">Ben, Mervenur Altunkaya</h3>
            <?php
              // Anasayfa içeriğini al
              $query = "SELECT hakkimda FROM anasayfa ORDER BY id DESC LIMIT 1";
              $result = $baglan->query($query);
              $anasayfaHakkimda = "";

              if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                $anasayfaHakkimda = $row["hakkimda"];
                }
              }
              echo isset($anasayfaHakkimda) ? $anasayfaHakkimda : "İçerik bulunamadı";
            ?>

            <div class="about__info grid" style="margin-top: 20px;">
              <div class="about__box">
                <i class="uil uil-award about__icon"></i>
                <h3 class="about__title">Deneyim</h3>
              </div>

              <div class="about__box">
                <i class="uil uil-suitcase about__icon"></i>
                <h3 class="about__title">Projeler</h3>
              </div>

              <div class="about__box">
                <i class="uil uil-headphones-alt about__icon"></i>
                <h3 class="about__title">Destek</h3>
              </div>
            </div>

            <a href="#contact" class="button"><i class="uil uil-navigator button__icon"></i>Bana Ulaşın!</a>
          </div>
        </div>
      </section>

      <!-- =================================WORK================================= -->
      <section class="work section" id="work">
        <h2 data-heading="Eğitimim ve" class="section__title">Deneyimlerim</h2>

        <div class="work__container grid">
          <div class="education">
            <h3 class="work__title"><i class="uil uil-graduation-cap"></i>Eğitimim</h3>

            <div class="timeline">
              <?php
              include("baglanti.php");

              // Veritabanından eğitim bilgilerini seçme sorgusu
              $sql = "SELECT * FROM egitim";
              $result = $baglan->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  // Eğitim bilgilerini alma
                  echo '<div class="timeline__item">';
                  echo '<div class="circle__dot"></div>';
                  echo '<h3 class="timeline__title">'. $row["kurum_adi"]. '</h3>';
                  echo '<span class="timeline__date"><i class="uil uil-calendar-alt"></i>' . $row["bas_tarih"] . '-' . $row["bit_tarih"]. '</span>';
                  echo '</div>';
                }
              } else {
                  echo "Eğitim bulunamadı.";
              }
              ?>
            </div>
          </div>

          <div class="experience">
            <h3 class="work__title"><i class="uil uil-suitcase"></i>Deneyimlerim</h3>

            <div class="timeline">
              <?php

                // Veritabanından deneyimleri seçme sorgusu
                $sql = "SELECT * FROM deneyim";
                $result = $baglan->query($sql);

                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                  // Deneyim bilgilerini alma
                  echo '<div class="timeline__item">';
                  echo '<div class="circle__dot"></div>';
                  echo '<h3 class="timeline__title">'. $row["kurum_adi"]. '</h3>';
                  echo '<p class="timeline__title">'. $row["pozisyon"]. '</p>';
                  echo '<span class="timeline__date"><i class="uil uil-calendar-alt"></i>' . $row["yil"] .  '</span>';
                  echo '</div>';
                  }
                } else {
                    echo "Deneyim bulunamadı.";
                }
              ?>
            </div>
          </div>
        </div>
      </section>

      <!-- =================================SKILLS================================= -->
      <section class="skills section" id="skills">
        <h2 data-heading="Beceri ve" class="section__title">Yetkinliklerim</h2>
        <div class="skills__container container grid">
          <div class="skills__tabs">
            <!-- Frontend Başlık -->
            <div class="skills__header skills__active" data-target="#frontend">
              <i class="uil uil-brackets-curly skills__icon"></i>
              <div>
                <h1 class="skills__title">Frontend Developer</h1>
              </div>
              <i class="uil uil-angle-down skills__arrow"></i>
            </div>

            <!-- Backend Başlık -->
            <div class="skills__header" data-target="#backend">
              <i class="uil uil-brackets-curly skills__icon"></i>
              <div>
                <h1 class="skills__title">Backend Developer</h1>
              </div>
              <i class="uil uil-angle-down skills__arrow"></i>
            </div>

            <!-- Mobil Başlık -->
            <div class="skills__header" data-target="#mobil">
              <i class="uil uil-brackets-curly skills__icon"></i>
              <div>
                <h1 class="skills__title">Mobil Uygulama Geliştiriciliği</h1>
              </div>
              <i class="uil uil-angle-down skills__arrow"></i>
            </div>
          </div>

          <!-- FRONTEND -->
          <div class="skills__content">
            <div class="skills__group skills__active" data-content id="frontend">
              <?php
                // Veritabanından frontend kategorili yetkinlikleri seçme sorgusu
                $sql = "SELECT * FROM yetkinlik WHERE kategori='Frontend'";
                $result = $baglan->query($sql);

                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    // Frontend kategorili yetkinliklerin bilgilerini alma
                    echo '<div class="skills__list grid">';
                    echo '<div class="skills__data">';
                    echo '<div class="skills__titles">';
                    echo '<h3 class="skills__name">'. $row["yetkinlik_adi"].'</h3>';
                    echo '<span class="skills__number">'. $row["yuzde"]. '%</span>';
                    echo '</div>';
                    echo '<div class="skills__bar" style="margin-bottom:2rem;">';
                    echo '<span class="skills__percentage" style="width:'. $row["yuzde"].'%"></span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }
                } else {
                  echo "Yetkinlik bulunamadı.";
                }
              ?>
            </div>

            <!-- BACKEND -->
            <div class="skills__group" data-content id="backend">
            <?php
              //  Veritabanından backend kategorili yetkinlikleri seçme sorgusu
              $sql = "SELECT * FROM yetkinlik WHERE kategori='Backend'";
              $result = $baglan->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                // Backend kategorili yetkinliklerin bilgilerini alma
                echo '<div class="skills__list grid">';
                echo '<div class="skills__data">';
                echo '<div class="skills__titles">';
                echo '<h3 class="skills__name">'. $row["yetkinlik_adi"].'</h3>';
                echo '<span class="skills__number">'. $row["yuzde"]. '</span>';
                echo '</div>';
                echo '<div class="skills__bar" style="margin-bottom:2rem;">';
                echo '<span class="skills__percentage" style="width:'. $row["yuzde"].'%"></span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                }
              } else {
                  echo "Yetkinlik bulunamadı.";
              }
            ?>
            </div>

            <!-- MOBİL -->
            <div class="skills__group" data-content id="mobil">
            <?php
              // Veritabanından mobil kategorili yetkinlikleri seçme sorgusu
              $sql = "SELECT * FROM yetkinlik WHERE kategori='Mobil'";
              $result = $baglan->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                // Mobil kategorili yetkinliklerin bilgilerini alma
                echo '<div class="skills__list grid">';
                echo '<div class="skills__data">';
                echo '<div class="skills__titles">';
                echo '<h3 class="skills__name">'. $row["yetkinlik_adi"].'</h3>';
                echo '<span class="skills__number">'. $row["yuzde"]. '</span>';
                echo '</div>';
                echo '<div class="skills__bar" style="margin-bottom:2rem;">';
                echo '<span class="skills__percentage" style="width:'. $row["yuzde"].'%"></span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                }
              } else {
                echo "Yetkinlik bulunamadı.";
              }
            ?>
            </div>
          </div>
        </div>
      </section>

      <!-- =================================PORTFOLIO================================= -->
      <section class="proje section" id="proje">
        <h2 data-heading="Benim" class="section__title">Portfolyom</h2>

        <!-- Proje türlerini filtrelme -->
        <div class="proje__filters">
          <span class="proje__item active-proje" data-filter="all">Hepsi</span>
          <span class="proje__item" data-filter=".Web">Web</span>
          <span class="proje__item" data-filter=".Mobil">Mobil</span>
        </div>

        <div class="proje__container container grid">
          <?php
              // Veritabanından projeleri seçme sorgusu
              $sql = "SELECT * FROM proje";
              $result = $baglan->query($sql);

              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  // Her proje için bir proje kartı oluşturma
                  echo '<div class="proje__card mix ' . $row["proje_turu"] . '">';
                  echo '<img src="./admin/' . $row["fotograf"] . '" alt="proje" class="proje__img" />';
                  echo '<h3 class="proje__title">' . $row["proje_adi"] . '</h3>';
                  echo '<span class="proje__button">Detay <i class="uil uil-arrow-right proje__button-icon"></i></span>';
                  echo '<div class="proje__item-details">';
                  echo '<h3 class="details__title">' . $row["proje_aciklama"] . '</h3>';
                  echo '<ul class="details__info">';
                  echo '</ul>';
                  echo '</div>';
                  echo '</div>';
                }
              } else {
                  echo "Proje bulunamadı.";
              } 
          ?>
        </div>
      </section>

      <!-- =================================PORTFOLIO POPUP================================= -->

      <div class="proje__popup">
        <div class="proje__popup-inner">
          <div class="proje__popup-content grid">
            <span class="proje__popup-close"><i class="uil uil-times"></i></span>

            <!-- Proje popup resmi -->
            <div class="pp__thumbnail">
              <img src="" alt="" class="proje__popup-img" />
            </div>

            <!-- Proje popup bilgi -->
            <div class="proje__popup-info">
              <div class="proje__popup-subtitle">
                Proje Adı - <span></span>
              </div>

              <div class="proje__popup-body">
                <h3 class="details__title"></h3>
                <p class="details__description"></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- =================================SERTİFİKA =================================-->

      <section class="sertifika section" id="sertifika">
        <h2 data-heading="Benim" class="section__title">Sertifikalarım</h2>
        <div class="sertifika__container container swiper">
        <div class="swiper-wrapper">
          <?php
            // Veritabanından sertifikaları seçme sorgusu
            $sql = "SELECT * FROM sertifika";
            $result = $baglan->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
              // Her sertifika için bir sertifika kartı oluşturma
              echo '<div class="sertifika__card swiper-slide">';
              echo '<img src="./admin/' . $row["fotograf"] . '" alt="sertifika" class="sertifika__img" />';
              echo '<h3 class="sertifika__title">' . $row["sertifika_adi"] . '</h3>';
              echo '<div class="sertifika__item-details">';
              echo '</ul>';
              echo '</div>';
              echo '</div>';
              }
            } else {
              echo "Proje bulunamadı.";
            }
          ?>
        </div>
        <div class="swiper-pagination"></div>
        </div>
      </section>
      
      <div class="sertifika__popup" style="display:none;">
        <div class="sertifika__popup-inner">
          <div class="sertifika__popup-content grid">
            <span class="sertifika__popup-close"><i class="uil uil-times"></i></span>
          </div>
        </div>
      </div>

      <!-- =================================REFERANCE================================= -->
      <section class="referance section" id="referance">
        <h2 data-heading="Benim" class="section__title">Referanslarım</h2>

        <div class="referance__container container swiper">
          <div class="swiper-wrapper">
          <?php
            // Veritabanından referansları seçme sorgusu
            $sql = "SELECT * FROM referans";
            $result = $baglan->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
              // Her referans için bir referans kartı oluşturma
              echo '<div class="referance__card swiper-slide">';
              echo '<div class="referance__quote"> <i class="fa-solid fa-quote-left"></i> </div>';
              echo '<p class="referance__description">' . $row["gorus"] . '</p>';
              echo '<span class="referance__profile-name">' . $row["adSoyad"] . '</span>';
              echo '<span class="referance__profile-detail">' . $row["gorev"] . '</span>';
              echo '</div>';
              }
            } else {
                echo "Referans bulunamadı.";
            }
          ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </section>

      <!-- =================================CONTACT================================= -->
      <section class="contact section" id="contact">
        <h2 data-heading="Bana" class="section__title">Ulaşın</h2>
        <div class="contact__container container grid">
          <div class="contact__content">

            <div class="contact__info">
              <div class="contact__card">
                <i class="uil uil-envelope-edit contact__icon"></i>
                <h3 class="contact__card-title">Email</h3>
                <span class="contact__card-data">mevenuraltunkaya1@gmail.com</span>
                <span class="contact__button"> Bana Ulaş<i class="uil uil-arrow-right contact__button-icon"></i></span>
              </div>

              <div class="contact__card">
                <i class="uil uil-whatsapp contact__icon"></i>
                <h3 class="contact__card-title">WhatsApp</h3>
                <span class="contact__card-data">6161-616-16-16</span>
                <span class="contact__button">Bana Ulaş<i class="uil uil-arrow-right contact__button-icon"></i></span>
              </div>

              <div class="contact__card">
                <i class="uil uil-facebook-messenger contact__icon"></i>
                <h3 class="contact__card-title">Messenger</h3>
                <span class="contact__card-data">user.ts6161</span>
                <span class="contact__button">Bana Ulaş<i class="uil uil-arrow-right contact__button-icon"></i></span>
              </div>
            </div>

          </div>

          <div class="contact__content">
            <!-- İletişim Formu -->
            <form action="index.php" method="post" class="contact__form">

              <div class="input__container">
                <input type="text" class="input" name="name" />
                <label for="">Ad Soyad</label>
                <span>Ad Soyad</span>
              </div>

              <div class="input__container">
                <input type="email" class="input" name="email" />
                <label for="">Email</label>
                <span>Email</span>
              </div>

              <div class="input__container textarea">
                <textarea name="mesaj" id="" class="input"></textarea>
                <label for="">Mesaj</label>
                <span>Mesaj</span>
              </div>

              <button type="submit" class="button"><i class="uil uil-user button__icon"></i> Gönder </button>
            </form>

            <!-- İletişim formunu veritabanına kaydetme -->
            <?php
              if(isset($_POST["name"], $_POST["email"], $_POST["mesaj"])){
              $adsoyad=$_POST["name"];
              $email=$_POST["email"];
              $mesaj=$_POST["mesaj"];

              $ekle="INSERT INTO iletisim (adSoyad, email, mesaj) VALUES ('".$adsoyad."','".$email."','".$mesaj."')";

              if($baglan->query($ekle)===TRUE){
                echo "<script>alert('Mesajınız başarı ile gönderilmiştir!')</script>";
                // Yönlendirme işlemi
                echo "<script>window.location = 'index.php';</script>";
                exit; // Kodun devam etmesini önlemek için
              }
             }
            ?>


          </div>
        </div>
      </section>
      
      <!-- =================================FOOTER================================= -->
      <footer class="footer">
        <div class="footer__bg">
          <div class="footer__container container grid">
            <div>
              <h1 class="footer__title">Mervenur</h1>
              <span class="footer__subtitle">Yazılım Öğrencisi</span>
            </div>

            <ul class="footer__links">
              <li>
                <a href="#skills" class="footer__links">Yetkinlikler</a>
              </li>
              <li>
                <a href="#proje" class="footer__links">Projeler</a>
              </li>
              <li>
                <a href="#contact" class="footer__links">İletişim</a>
              </li>
            </ul>

            <?php
            // Veritabanından verileri sorgula
            $sql = "SELECT linkedin, github, medium FROM anasayfa WHERE id=1";
            $result = $baglan->query($sql);

            if ($result->num_rows > 0) {
              // Verileri döngüyle al
              $row = $result->fetch_assoc();
              $linkedin_url = $row["linkedin"];
              $github_url = $row["github"];
              $medium_url = $row["medium"];
            } else {
                echo "Veritabanında kayıt bulunamadı";
            }
            ?>

        <div class="footer__socials">
            <a href="<?php echo $linkedin_url; ?>" target="_blank" class="home__social-link">
            <i class="uil uil-linkedin"></i>
            </a>
            <a href="<?php echo $github_url; ?>" target="_blank" class="home__social-link">
            <i class="uil uil-github"></i>
            </a>
            <a href="<?php echo $medium_url; ?>" target="_blank" class="home__social-link">
            <i class="uil uil-medium-m"></i>
            </a>
        </div>

        </div>
          <p class="footer__copy">&#169; Mervenur Altunkaya</p>
        </div>
      </footer>
    </main>

    <script src="js/mixitup.min.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>

<!-- Veritabanı bağlantısını kapat -->
<?php $baglan->close(); ?>

