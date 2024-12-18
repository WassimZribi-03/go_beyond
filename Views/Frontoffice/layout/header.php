<?php include_once "../../config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $pageTitle ?? 'Events Portal'; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/accomodation/assets/css/tooplate-artxibition.css">
    <link rel="stylesheet" href="/accomodation/assets/css/custom.css">

    <style>
        /* Critical CSS for initial render */
        .header-area { background-color: rgba(250,250,250,0.15); }
        .header-sticky { background-color: #fff !important; }
        .main-nav .logo { 
            font-size: 24px;
            font-weight: 700;
            color: #2a2a2a;
            line-height: 100px;
            transition: all .3s ease 0s;
        }
        .main-nav .logo em {
            font-style: normal;
            color: #dc8cdb;
        }
        
        /* Main Banner Styles */
        .main-banner {
            background-image: url('/accomodation/assets/images/banner-bg.jpg');
            background-position: center center;
            background-size: cover;
            min-height: 100vh;
            padding: 280px 0px 200px 0px;
            position: relative;
        }
        
        .main-banner:after {
            content: '';
            background-image: url('/accomodation/assets/images/banner-left-dec.png');
            background-repeat: no-repeat;
            position: absolute;
            left: 0;
            top: 60px;
            width: 262px;
            height: 625px;
            z-index: 1;
        }
        
        .main-banner:before {
            content: '';
            background-image: url('/accomodation/assets/images/banner-right-dec.png');
            background-repeat: no-repeat;
            position: absolute;
            right: 0;
            top: 60px;
            width: 1159px;
            height: 797px;
            z-index: -1;
        }
        
        /* Counter Styles */
        .counter-content {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 120px;
            z-index: 2;
            background-color: rgba(250,250,250,0.15);
            padding: 20px 40px;
            border-radius: 10px;
        }
        
        .counter-content ul {
            display: flex;
            list-style: none;
            justify-content: center;
            margin: 0;
            padding: 0;
        }
        
        .counter-content ul li {
            text-align: center;
            margin: 0px 45px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .counter-content ul li span {
            display: block;
            font-size: 36px;
            font-weight: 700;
            color: #fff;
            margin-top: 15px;
        }
        
        /* Main Content Styles */
        .main-content {
            text-align: center;
            background-color: rgba(250,250,250,0.95);
            border-radius: 75px;
            padding: 60px;
            max-width: 850px;
            margin: 0 auto;
            position: relative;
            z-index: 3;
            margin-bottom: -50px;
        }
        
        .main-content .next-show {
            margin-bottom: 45px;
        }
        
        .main-content .next-show i {
            color: #dc8cdb;
            font-size: 20px;
        }
        
        .main-content .next-show span {
            font-size: 15px;
            color: #2a2a2a;
            font-weight: 700;
            margin-left: 5px;
        }
        
        .main-content h6 {
            font-size: 20px;
            color: #2a2a2a;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .main-content h2 {
            font-size: 50px;
            color: #2a2a2a;
            font-weight: 800;
            margin-bottom: 45px;
        }
        
        .main-white-button a {
            display: inline-block;
            background-color: #fff;
            font-size: 15px;
            font-weight: 600;
            color: #2a2a2a;
            text-transform: capitalize;
            padding: 12px 25px;
            border-radius: 25px;
            letter-spacing: 0.5px;
            transition: all .3s;
            text-decoration: none;
        }
        
        .main-white-button a:hover {
            background-color: #dc8cdb;
            color: #fff;
        }
        
        /* Preloader */
        .js-preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .js-preloader.loaded {
            visibility: hidden;
            opacity: 0;
            transition: all 1s ease;
        }
        
        /* Show Events Carousel */
        .show-events-carousel {
            padding: 120px 0px;
            position: relative;
            background-color: #f5f5f5;
        }

        .owl-show-events .item {
            position: relative;
            border-radius: 25px;
            overflow: hidden;
        }

        .owl-show-events .item img {
            width: 100%;
            border-radius: 25px;
        }

        /* Amazing Venues */
        .amazing-venues {
            padding: 120px 0px;
            position: relative;
        }

        .amazing-venues .left-content h4 {
            font-size: 45px;
            font-weight: 800;
            line-height: 60px;
            color: #2a2a2a;
        }

        .amazing-venues .right-content {
            background-color: #f5f5f5;
            border-radius: 25px;
            padding: 40px;
        }

        .amazing-venues .right-content h5 {
            font-size: 20px;
            font-weight: 700;
            color: #2a2a2a;
            margin-bottom: 20px;
        }

        .amazing-venues .right-content h5 i {
            color: #dc8cdb;
            margin-right: 10px;
        }

        /* Map Image */
        .map-image {
            margin-top: 120px;
            margin-bottom: 120px;
        }

        .map-image img {
            width: 100%;
            overflow: hidden;
        }

        /* Venue & Tickets */
        .venue-tickets {
            padding: 120px 0px;
            background-color: #f5f5f5;
        }

        .venue-tickets .section-heading {
            text-align: center;
            margin-bottom: 80px;
        }

        .venue-tickets .section-heading h2 {
            font-size: 45px;
            font-weight: 800;
            color: #2a2a2a;
        }

        .venue-tickets .venue-item {
            background-color: #fff;
            border-radius: 25px;
            margin-bottom: 30px;
        }

        .venue-tickets .venue-item .thumb {
            position: relative;
            border-top-right-radius: 25px;
            border-top-left-radius: 25px;
            overflow: hidden;
        }

        .venue-tickets .venue-item .thumb img {
            width: 100%;
            overflow: hidden;
        }

        .venue-tickets .venue-item .down-content {
            padding: 30px;
            border-bottom-right-radius: 25px;
            border-bottom-left-radius: 25px;
        }

        .venue-tickets .venue-item .down-content h4 {
            font-size: 22px;
            font-weight: 700;
            color: #2a2a2a;
            margin-bottom: 15px;
        }

        .venue-tickets .venue-item .down-content p {
            color: #888;
            margin-bottom: 20px;
        }

        .venue-tickets .venue-item .down-content ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .venue-tickets .venue-item .down-content ul li {
            display: inline-block;
            margin-right: 30px;
            font-size: 14px;
            color: #888;
        }

        .venue-tickets .venue-item .down-content ul li:last-child {
            margin-right: 0px;
        }

        .venue-tickets .venue-item .down-content ul li i {
            color: #dc8cdb;
            margin-right: 8px;
        }

        .venue-tickets .venue-item .down-content .price {
            position: absolute;
            right: 30px;
            bottom: 30px;
            background-color: #dc8cdb;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .venue-tickets .venue-item .down-content .price span {
            font-size: 14px;
            color: #fff;
            font-weight: 500;
        }

        .venue-tickets .venue-item .down-content .price em {
            font-size: 24px;
            font-weight: 700;
            font-style: normal;
        }

        /* Responsive Styles */
        @media (max-width: 991px) {
            .counter-content ul li {
                margin: 0px 15px;
            }
            .amazing-venues .left-content h4 {
                font-size: 35px;
                line-height: 45px;
            }
            .venue-tickets .section-heading h2 {
                font-size: 35px;
            }
        }

        @media (max-width: 767px) {
            .counter-content ul li {
                margin: 0px 10px;
                font-size: 14px;
            }
            .counter-content ul li span {
                font-size: 24px;
            }
            .amazing-venues .left-content h4 {
                font-size: 28px;
                line-height: 36px;
            }
        }
    </style>
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
                        <!-- Logo -->
                        <a href="/accomodation/Views/Frontoffice/index.php" class="logo">
                            Go<em>Beyond</em>
                        </a>

                        <!-- Menu -->
                        <ul class="nav">
                            <li><a href="/accomodation/Views/Frontoffice/index.php" <?php echo $currentPage == 'home' ? 'class="active"' : ''; ?>>Home</a></li>
                            <li><a href="/accomodation/Views/Frontoffice/tours.php" <?php echo $currentPage == 'tours' ? 'class="active"' : ''; ?>>Tours</a></li>
                            <li><a href="/go_beyond-guide/View/FrontOffice/guides.php" <?php echo $currentPage == 'guides' ? 'class="active"' : ''; ?>>Our Guides</a></li>
                            <li><a href="/accomodation/Views/Frontoffice/my-bookings.php" <?php echo $currentPage == 'my-bookings' ? 'class="active"' : ''; ?>>My Bookings</a></li>
                            <li><a href="/go_beyond-event/view/Frontoffice/shows-events.php" class="<?php echo ($currentPage == 'events') ? 'active' : ''; ?>">Events</a></li>
                            <li><a href="/go_beyond-event/view/Frontoffice/my-event-bookings.php" class="<?php echo ($currentPage == 'event-bookings') ? 'active' : ''; ?>">My Event Bookings</a></li>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <li><a href="/go_beyond-guide/View/FrontOffice/my-guide-bookings.php" class="<?php echo ($currentPage == 'guide-bookings') ? 'active' : ''; ?>">Guide Bookings</a></li>
                                <li><a href="/accomodation/Views/Frontoffice/logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a href="/accomodation/Views/Frontoffice/login.php">Login</a></li>
                            <?php endif; ?>
                        </ul>
                        <a class='menu-trigger'><span>Menu</span></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>
