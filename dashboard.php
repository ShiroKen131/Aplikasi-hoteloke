
<?php
session_start();  // Memulai session

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada session user, redirect ke login.php
    header("Location: login.php");
    exit();
}

// Konten dashboard
echo "Selamat datang, " . $_SESSION['email'];

// Ambil data dari session
$username = $_SESSION['username'];  // Mengambil username dari session
$email = $_SESSION['email'];  

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="assets/css/styles.css">
        <title>Hotel</title>
    </head>
    <body>
<!-- HEADER -->
        <header class="header" id="header">
            <nav class="nav container">
                <a href="#" class="nav__logo">Hotel</a>

                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="#home" class="nav__link active-link">
                                <i class='bx bx-home' ></i>
                                <span class="nav__name">Home</span>
                            </a>
                        </li>
                        
                        <li class="nav__item">
                            <a href="#about" class="nav__link">
                                <i class='bx bxs-calendar'></i>
                                <span class="nav__name">Calendar</span>
                            </a>
                        </li>

                        <li class="nav__item">
                            <a href="#skills" class="nav__link">
                                <i class='bx bxs-bookmarks' ></i>
                                <span class="nav__name">Bookmark</span>
                            </a>
                        </li>


                        <li class="nav__item">
                            <a href="#contactme" class="nav__link">
                                <i class='bx bx-user-circle'></i>
                                <span class="nav__name">Akun</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>

        <main>
   <!-- Home -->
            <section class="container section section__height" id="home">
                <h2 class="section__title">Home</h2>
                  <main>
                    <section class="hotels">
                      <h2>Nearest Hotels</h2>
                      <div class="hotel-card">
                        <img src="assets/img/hotel1.jpg" alt="Hotel Image" class="hotel-image">
                        <div class="hotel-info">
                          <span class="tag genius">Bali</span>
                          <h2>Adiwana</h2>
                          <p class="location">Bali, Indonesia</p>
                          <div class="rating">
                            <span class="rating-score">9.5</span>
                            <span class="rating-text">Luar biasa · 69 ulasan</span>
                          </div>
                          <span class="promo">Promo Akhir Tahun</span>
                          <div class="price-info">
                            <p>2 malam</p>
                            <p class="old-price">Rp 8.625.000</p>
                            <p class="new-price">Rp 5.554.500</p>
                          </div>
                        </div>
                      </div>

                      <div class="hotel-card">
                        <img src="assets/img/hotel2.jpg" alt="Hotel Image" class="hotel-image">
                        <div class="hotel-info">
                          <span class="tag genius">Jakarta</span>
                          <h2>Ageng</h2>
                          <p class="location">Jakarta, Indonesia</p>
                          <div class="rating">
                            <span class="rating-score">9.5</span>
                            <span class="rating-text">Luar biasa · 200 ulasan</span>
                          </div>
                          <span class="promo">Promo Akhir Tahun</span>
                          <div class="price-info">
                            <p>2 malam</p>
                            <p class="old-price">Rp 8.625.000</p>
                            <p class="new-price">Rp 5.554.500</p>
                          </div>
                        </div>
                      </div>

                      <div class="hotel-card">
                        <img src="assets/img/hotel3.jpg" alt="Hotel Image" class="hotel-image">
                        <div class="hotel-info">
                          <span class="tag genius">Jakarta</span>
                          <h2>Jayapura</h2>
                          <p class="location">Jakarta, Indonesia</p>
                          <div class="rating">
                            <span class="rating-score">9.5</span>
                            <span class="rating-text">Luar biasa · 98 ulasan</span>
                          </div>
                          <span class="promo">Promo Ramadhan</span>
                          <div class="price-info">
                            <p>2 malam</p>
                            <p class="old-price">Rp 6.625.000</p>
                            <p class="new-price">Rp 4.554.500</p>
                          </div>
                        </div>
                      </div>

                      <div class="hotel-card">
                        <img src="assets/img/hotel4.jpg" alt="Hotel Image" class="hotel-image">
                        <div class="hotel-info">
                          <span class="tag genius">Jakarta</span>
                          <h2>Arjuna</h2>
                          <p class="location">NTT, Indonesia</p>
                          <div class="rating">
                            <span class="rating-score">9.5</span>
                            <span class="rating-text">Luar biasa · 300 ulasan</span>
                          </div>
                          <span class="promo">Promo Natal</span>
                          <div class="price-info">
                            <p>2 malam</p>
                            <p class="old-price">Rp 8.625.000</p>
                            <p class="new-price">Rp 3.554.500</p>
                          </div>
                        </div>
                      </div>
            </section>

            <!--=============== Calendar ===============-->
            <section class="container section section__height" id="about">
                <h2 class="section__title">Kalender</h2>
              <center>
                <div class="wrapper">
                    <header>
                      <p class="current-date"></p>
                      <div class="icons">
                        <span id="prev" class="material-symbols-rounded"><i class='bx bxs-chevron-left'></i></span>
                        <span id="next" class="material-symbols-rounded"><i class='bx bxs-chevron-right'></i></span>
                      </div>
                    </header>
                    <div class="calendar">
                      <ul class="weeks">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                      </ul>
                      <ul class="days"></ul>
                    </div>
                  </div>

              </center>  
                  <center><h2>Schedule</h2></center>
            </section>

            <!--=============== Bookmark ===============-->
            <section class="container section section__height" id="skills">
                <h2 class="section__title">Bookmark</h2>
                <div class="hotel-card-bookmark">
                    <img src="assets/img/hotel1.jpg" alt="Hotel Image" class="hotel-image">
                    <div class="hotel-info">
                      <span class="tag genius">Bali</span>
                      <h2>Adiwana</h2>
                      <p class="location">Bali, Indonesia</p>
                      <div class="rating">
                        <span class="rating-score">9.5</span>
                        <span class="rating-text">Luar biasa · 69 ulasan</span>
                      </div>
                      <span class="promo">Promo Akhir Tahun</span>
                      <div class="price-info">
                        <p>2 malam</p>
                        <p class="old-price">Rp 8.625.000</p>
                        <p class="new-price">Rp 5.554.500</p>
                      </div>
                    </div>
                  </div>
                   
                  <a href="reservasi.php" class="button1">Reservasi</a>

            </section>

            <!--=============== Akun ===============-->
            <section class="container section section__height" id="contactme">
                <h2 class="section__title">Profile</h2>
               <center> <div class="profile-container">
                    <div class="profile-card">
                      <div class="profile-header">
                        <img src="assets/img/Foto Orang.jpg" alt="Profile Picture" class="profile-image">
                      </div>
                      <div class="profile-body">
                        <h2 id="profile-name"><?php echo htmlspecialchars($username); ?></h2>
                        <p id="profile-email"><?php echo htmlspecialchars($email);?></p>
                      </div>
                    </div>
                  </div>
                  <div class="button2">
    <form action="logout.php" method="POST">
        <button type="submit" class="button2">Logout</button>
    </form>
</div>
                </center>
                
            </section>
        </main>
    
        <!--=============== MAIN JS ===============-->
        <script src="assets/js/main.js"></script>
    </body>
</html>