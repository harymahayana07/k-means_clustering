<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>K-MEANS CLUSTERING</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="{{ asset('dashboard-utama/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('dashboard-utama/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap"
        rel="stylesheet">

    <link href="{{ asset('dashboard-utama/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-utama/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-utama/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-utama/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-utama/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-utama/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-utama/assets/css/custom.css') }}" rel="stylesheet">


</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">Grand Asia</h1>
                <span>.</span>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda<br></a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#menu">Produk</a></li>
                    <li><a href="#chefs">Testimoni</a></li>
                    {{-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li> --}}
                    <li><a href="#contact">Kontak Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="index.html#book-a-table">Masuk</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section light-background">

            <div class="container">
                <div class="row gy-4 justify-content-center justify-content-lg-between">
                    <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1 data-aos="fade-up">Solusi Kebutuhan<br>Sembako Anda !</h1>
                        <p data-aos="fade-up" data-aos-delay="100">Belanja Sembako Praktis & Terjangkau di Grand Asia
                            Temukan kebutuhan harian Anda dengan harga bersahabat dan pelayanan terbaik!
                        </p>
                        <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                            <a href="#book-a-table" class="btn-get-started">Daftar Pelanggan Penerima Hadiah</a>
                            {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch
                  Video</span></a> --}}
                        </div>
                    </div>
                    <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                        <img src="{{ asset('dashboard-utama/assets/img/gallery/gallery-4.jpg') }}" style="border-radius: 3rem!important;" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang Kami<br></h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">
                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('dashboard-utama/assets/img/about.jpg') }}" class="img-fluid mb-4" alt="">
                    </div>
                    <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
                        <div class="content ps-0 ps-lg-5">
                            <p class="fst-italic">
                                Grand Asia adalah toko retail sembako terpercaya yang menyediakan berbagai kebutuhan pokok masyarakat Indonesia.
                                Mulai dari beras, minyak goreng, gula, telur, hingga kebutuhan dapur lainnya, semua tersedia dengan harga yang kompetitif dan kualitas terbaik.
                                <br>
                                Kami juga berkomitmen untuk :
                            </p>
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Menyediakan produk segar & berkualitas.</span></li>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Memberikan harga terbaik untuk pelanggan setia kami.</span></li>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Melayani dengan ramah, cepat, dan terpercaya.</span></li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section dark-background">

            <img src="{{ asset('dashboard-utama/assets/img/stats-bg.jpg') }}" alt="" data-aos="fade-in">

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Pelanggan</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Produk</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Transaksi</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>
            </div>
        </section>

        <section id="menu" class="menu section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Top Menu Kami</h2>
                {{-- <p><span>Check Our</span> <span class="description-title">Yummy Menu</span></p> --}}
            </div>

            <div class="container">

                <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">

                    <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-starters">
                            <h4>Sembako</h4>
                        </a>
                    </li>

                </ul>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                    <div class="tab-pane fade active show" id="menu-starters">

                        <div class="tab-header text-center">
                            <p>Menu</p>
                            <h3>Sembako</h3>
                        </div>

                        <div class="row gy-5">
                            @foreach($produkTerlaris as $item)
                            <div class="col-lg-4 menu-item">
                                <!-- <a
                  href="{{ asset('storage/' . $item->produk->image_path) }}"
                  class="glightbox">
                  <img
                    src="{{ asset('storage/' . $item->produk->image_path) }}"
                    class="menu-img img-fluid"
                    alt="{{ $item->produk->nama_produk }}">
                </a> -->

                                <h4>{{ $item->produk->nama_produk }}</h4>

                                <p class="ingredients">
                                    {{ $item->produk->deskripsi ?? '-' }}
                                </p>

                                <p class="price">
                                    Harga: Rp {{ number_format($item->produk->harga,0,',','.') }}
                                    <br>
                                    <span class="badge" style="background:#007bff; color:#fff; font-size:1rem;">
                                        {{ number_format($item->total_qty, 0, ',', '.') }} pcs
                                    </span>
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <section id="testimonials" class="testimonials section light-background">

            <div class="container section-title" data-aos="fade-up">
                <h2>TESTIMONIALS</h2>
                <p>What Are They <span class="description-title">Saying About Us</span></p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            }
                        }
                    </script>
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus.
                                                    Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at
                                                    semper.</span>
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3>Saul Goodman</h3>
                                            <h4>Ceo &amp; Founder</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <img src="{{ asset('dashboard-utama/assets/img/testimonials/testimonials-1.jpg') }}"
                                            class="img-fluid testimonial-img" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum
                                                    eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim
                                                    culpa.</span>
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3>Sara Wilsson</h3>
                                            <h4>Designer</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <img src="{{ asset('dashboard-utama/assets/img/testimonials/testimonials-2.jpg') }}"
                                            class="img-fluid testimonial-img" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam
                                                    duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3>Jena Karlis</h3>
                                            <h4>Store Owner</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <img src="{{ asset('dashboard-utama/assets/img/testimonials/testimonials-3.jpg') }}"
                                            class="img-fluid testimonial-img" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="testimonial-content">
                                            <p>
                                                <i class="bi bi-quote quote-icon-left"></i>
                                                <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat
                                                    minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore
                                                    illum veniam.</span>
                                                <i class="bi bi-quote quote-icon-right"></i>
                                            </p>
                                            <h3>John Larson</h3>
                                            <h4>Entrepreneur</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 text-center">
                                        <img src="{{ asset('dashboard-utama/assets/img/testimonials/testimonials-4.jpg') }}"
                                            class="img-fluid testimonial-img" alt="">
                                    </div>
                                </div>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section><!-- /Testimonials Section -->

        <!-- Book A Table Section -->
        <section id="book-a-table" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Daftar Pelanggan</h2>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    @foreach($pelanggan as $trx)
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                            <div class="border-custom-baru">
                                <span class="total-transaksi">{{ $trx->total_transaksi }}</span>
                            </div>
                            <div>
                                <h3 class="pelanggan-name">{{ $trx->pelanggan->nama_pelanggan }}</h3>
                                <p class="email-telp">
                                    {{ $trx->pelanggan->email_pelanggan ?? '-' }}
                                    @if(! empty($trx->pelanggan->no_telp_pelanggan))
                                    / {{ $trx->pelanggan->no_telp_pelanggan }}
                                    @endif
                                </p>

                                <!-- Cluster Information -->
                                @if($trx->cluster)
                                <div class="cluster-info">
                                    <h5 class="cluster-name">{{ $trx->cluster->nama }}</h5>
                                    <p class="cluster-desc">{{ $trx->cluster->deskripsi ?? 'Deskripsi tidak tersedia' }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak Kami</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="mb-5">
                    <iframe style="width: 100%; height: 400px;"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                        frameborder="0" allowfullscreen=""></iframe>
                </div><!-- End Google Maps -->

                <div class="row gy-4">

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
                            <i class="icon bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Address</h3>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
                            <i class="icon bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>+1 5589 55488 55</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="400">
                            <i class="icon bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>info@example.com</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="500">
                            <i class="icon bi bi-clock flex-shrink-0"></i>
                            <div>
                                <h3>Opening Hours<br></h3>
                                <p><strong>Mon-Sat:</strong> 11AM - 23PM; <strong>Sunday:</strong> Closed</p>
                            </div>
                        </div>
                    </div><!-- End Info Item -->

                </div>
            </div>

        </section><!-- /Contact Section -->

    </main>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('dashboard-utama/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard-utama/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('dashboard-utama/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('dashboard-utama/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('dashboard-utama/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('dashboard-utama/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('dashboard-utama/assets/js/main.js') }}"></script>

</body>

</html>
