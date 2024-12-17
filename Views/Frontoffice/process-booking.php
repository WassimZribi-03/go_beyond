<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../Controllers/BookingController.php';
include_once '../../Controllers/TourController.php';
include_once '../../Models/Booking.php';
include_once '../../libs/PHPMailer/src/Exception.php';
include_once '../../libs/PHPMailer/src/PHPMailer.php';
include_once '../../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $tour_id = isset($_POST['tour_id']) ? (int)$_POST['tour_id'] : null;
        $customer_name = $_POST['customer_name'] ?? null;
        $customer_email = $_POST['customer_email'] ?? null;
        $customer_phone = $_POST['customer_phone'] ?? null;
        $booking_date = $_POST['booking_date'] ?? null;

        if (!$tour_id || !$customer_name || !$customer_email || !$customer_phone || !$booking_date) {
            throw new Exception("Missing required fields");
        }

        $bookingController = new BookingController();
        $tourController = new TourController();
        
        // Get tour details
        $tour = $tourController->getTourById($tour_id);
        if (!$tour) {
            throw new Exception("Tour not found");
        }

        // Create booking object
        $booking = new Booking(
            null,
            $tour_id,
            $customer_name,
            $customer_email,
            $customer_phone,
            new DateTime($booking_date)
        );

        // Add booking
        $result = $bookingController->addBooking($booking);

        if ($result) {
            // Send confirmation email
            $mail = new PHPMailer(true);
            
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'dhibmehdi123@gmail.com'; // Your Gmail address
                $mail->Password = 'uyok mxpn tqxr gvgm'; // Your Gmail app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Recipients
                $mail->setFrom('dhibmehdi123@gmail.com', 'Tour Booking');
                $mail->addAddress($customer_email, $customer_name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Tour Booking Confirmation';
                $mail->Body = "
                    <html>
                    <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f5f5f5;'>
                        <div style='max-width: 600px; margin: 20px auto; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                            <!-- Header with Logo/Brand -->
                            <div style='background: linear-gradient(135deg, #2C3E50, #3498DB); padding: 30px 20px; border-radius: 10px 10px 0 0; text-align: center;'>
                                <h1 style='color: white; margin: 0; font-size: 28px; text-transform: uppercase; letter-spacing: 2px;'>Go Beyond</h1>
                                <p style='color: rgba(255,255,255,0.9); margin: 5px 0 0; font-size: 16px;'>Booking Confirmation</p>
                            </div>

                            <!-- Main Content -->
                            <div style='padding: 40px 30px;'>
                                <p style='font-size: 16px; color: #2c3e50; margin-bottom: 20px;'>Dear <strong>{$customer_name}</strong>,</p>
                                <p style='color: #666; margin-bottom: 30px;'>Thank you for choosing Go Beyond! Your tour booking has been confirmed successfully.</p>
                                
                                <!-- Booking Details Box -->
                                <div style='background: #f8f9fa; border-radius: 8px; padding: 25px; margin: 20px 0; border-left: 4px solid #3498DB;'>
                                    <h3 style='color: #2c3e50; margin-top: 0; margin-bottom: 20px; font-size: 18px;'>Booking Details</h3>
                                    
                                    <table style='width: 100%; border-collapse: collapse;'>
                                        <tr>
                                            <td style='padding: 8px 0; color: #666;'><strong>Tour:</strong></td>
                                            <td style='padding: 8px 0; color: #2c3e50;'>{$tour['name']}</td>
                                        </tr>
                                        <tr>
                                            <td style='padding: 8px 0; color: #666;'><strong>Destination:</strong></td>
                                            <td style='padding: 8px 0; color: #2c3e50;'>{$tour['destination']}</td>
                                        </tr>
                                        <tr>
                                            <td style='padding: 8px 0; color: #666;'><strong>Date:</strong></td>
                                            <td style='padding: 8px 0; color: #2c3e50;'>{$booking_date}</td>
                                        </tr>
                                        <tr>
                                            <td style='padding: 8px 0; color: #666;'><strong>Duration:</strong></td>
                                            <td style='padding: 8px 0; color: #2c3e50;'>{$tour['duration']} days</td>
                                        </tr>
                                        <tr>
                                            <td style='padding: 8px 0; color: #666;'><strong>Price:</strong></td>
                                            <td style='padding: 8px 0; color: #2c3e50;'>{$tour['price']} DT</td>
                                        </tr>
                                    </table>
                                </div>

                               

                                <p style='color: #666; margin-top: 30px;'>If you have any questions or need to make changes to your booking, please don't hesitate to contact us.</p>
                                
                                <!-- CTA Button -->
                                <div style='text-align: center; margin: 40px 0;'>
                                    <a href='C:\xampp\htdocs\accomodation\Views\Frontoffice\my-bookings.php' 
                                       style='background: #3498DB; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                                       View My Booking
                                    </a>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div style='background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; border-top: 1px solid #eee;'>
                                <p style='margin: 0; color: #666; font-size: 14px;'>Go Beyond Tours</p>
                                <div style='margin: 15px 0;'>
                                    <a href='#' style='color: #3498DB; margin: 0 10px; text-decoration: none;'>Website</a>
                                    <a href='#' style='color: #3498DB; margin: 0 10px; text-decoration: none;'>Contact Us</a>
                                    <a href='#' style='color: #3498DB; margin: 0 10px; text-decoration: none;'>Terms & Conditions</a>
                                </div>
                                <p style='margin: 0; color: #999; font-size: 12px;'>&copy; " . date('Y') . " Go Beyond. All rights reserved.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";

                $mail->send();
                error_log("Confirmation email sent to $customer_email");
            } catch (Exception $e) {
                error_log("Email sending failed: " . $e->getMessage());
                // Continue with booking process even if email fails
            }

            $_SESSION['booking_confirmation'] = [
                'customer_name' => $customer_name,
                'booking_date' => $booking_date,
                'tour_id' => $tour_id,
                'tour_name' => $tour['name'],
                'tour_destination' => $tour['destination'],
                'tour_price' => $tour['price']
            ];
            
            header("Location: booking-confirmation.php");
            exit();
        } else {
            throw new Exception("Failed to create booking");
        }

    } catch (Exception $e) {
        error_log("Error in process-booking.php: " . $e->getMessage());
        $_SESSION['booking_error'] = $e->getMessage();
        header("Location: book-tour.php?tour_id=" . $tour_id);
        exit();
    }
} else {
    header("Location: tours.php");
    exit();
}
?> 