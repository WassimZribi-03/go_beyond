<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $pageTitle ?? 'Go Beyond Tours'; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <!-- Template CSS Files -->
    <link rel="stylesheet" href="/accomodation/assets/css/tooplate-artxibition.css">
    <link rel="stylesheet" href="/accomodation/assets/css/custom.css">

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Preloader -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots"><span></span><span></span><span></span></div>
        </div>
    </div>

    <!-- Header -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="tours.php" class="logo">Go<em>Beyond</em></a>
                        <ul class="nav">
                            <li><a href="tours.php" class="<?php echo $currentPage == 'tours' ? 'active' : ''; ?>">Tours</a></li>
                            <li><a href="my-bookings.php" class="<?php echo $currentPage == 'my-bookings' ? 'active' : ''; ?>">My Bookings</a></li>
                            <li><a href="#" class="<?php echo $currentPage == 'contact' ? 'active' : ''; ?>">Contact</a></li>
                        </ul>
                        <a class='menu-trigger'><span>Menu</span></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Menu Trigger Script -->
    <script>
        $(document).ready(function() {
            // Handle mobile menu
            $('.menu-trigger').click(function() {
                $(this).toggleClass('active');
                $('.header-area .nav').slideToggle(200);
            });

            // Handle sticky header
            $(window).scroll(function() {
                if($(window).scrollTop() > 100) {
                    $('.header-area').addClass('header-sticky');
                } else {
                    $('.header-area').removeClass('header-sticky');
                }
            });

            // Handle preloader
            $(window).on('load', function() {
                $('#js-preloader').addClass('loaded');
            });
        });
    </script>

    <!-- Main Content Start -->
</body>
</html> 