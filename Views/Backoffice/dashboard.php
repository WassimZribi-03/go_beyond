<?php
session_start();
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../Controllers/TourController.php');
require_once(__DIR__ . '/../../Controllers/BookingController.php');
require_once('C:/xampp/htdocs/go_beyond-event/Controller/EventController.php');
require_once('C:/xampp/htdocs/go_beyond-guide/config.php');
require_once('C:/xampp/htdocs/go_beyond-guide/Controller/guidecontroller.php');
require_once('C:/xampp/htdocs/go_beyond-guide/Controller/disponibilitecontroller.php');

$tourController = new TourController();
$bookingController = new BookingController();
$eventController = new EventController();
$guideController = new GuideTouristiqueController();
$disponibiliteController = new DisponibilitesGuidesController();

// Get all results and count them properly
$tours = $tourController->listTours();
$bookings = $bookingController->listBookings();
$events = $eventController->listEvents();
$guides = $guideController->listGuides();
$disponibilites = $disponibiliteController->listDisponibilities();

$totalTours = is_array($tours) ? count($tours) : $tours->rowCount();
$totalBookings = is_array($bookings) ? count($bookings) : $bookings->rowCount();
$totalEvents = $events->rowCount();
$totalGuides = is_array($guides) ? count($guides) : $guides->rowCount();
$totalDisponibilites = is_array($disponibilites) ? count($disponibilites) : $disponibilites->rowCount();

$pageTitle = "Dashboard";
$currentPage = "dashboard";
include_once('layout/header.php');
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tours</p>
                                <h5 class="font-weight-bolder"><?php echo $totalTours; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-world-2 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Bookings</p>
                                <h5 class="font-weight-bolder"><?php echo $totalBookings; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-book-bookmark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Events</p>
                                <h5 class="font-weight-bolder"><?php echo $totalEvents; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Guides</p>
                                <h5 class="font-weight-bolder"><?php echo $totalGuides; ?></h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Recent Activity</h6>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-world-2 text-success text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Latest Tours</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">View all tours in the Tours section</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-calendar-grid-58 text-info text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Latest Events</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">View all events in the Events section</p>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="ni ni-single-02 text-dark text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Latest Guides</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">View all guides in the Guides section</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layout/footer.php'); ?>