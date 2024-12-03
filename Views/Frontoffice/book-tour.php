<?php
session_start();
include_once '../../Controllers/TourController.php';

// Check if tour_id is provided
if (!isset($_GET['tour_id'])) {
    echo "<script>
        alert('No tour selected. Please select a tour first.');
        window.location.href='tours.php';
    </script>";
    exit();
}

try {
    $tourController = new TourController();
    $tour = $tourController->getTourById($_GET['tour_id']);
} catch (Exception $e) {
    echo "<script>
        alert('Error loading tour: " . addslashes($e->getMessage()) . "');
        window.location.href='tours.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tour - <?php echo htmlspecialchars($tour['name']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --error-color: #dc2626;
            --success-color: #059669;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .tour-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .tour-details {
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }

        input.error {
            border-color: var(--error-color);
        }

        input.valid {
            border-color: var(--success-color);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tour-header">
            <h1><?php echo htmlspecialchars($tour['name']); ?></h1>
            <div class="price-tag"><?php echo htmlspecialchars($tour['price']); ?> DT</div>
        </div>

        <div class="tour-details">
            <p><i class="fas fa-map-marker-alt"></i> Destination: <?php echo htmlspecialchars($tour['destination']); ?></p>
            <p><i class="fas fa-clock"></i> Duration: <?php echo htmlspecialchars($tour['duration']); ?> days</p>
        </div>

        <form id="bookingForm" action="process-booking.php" method="POST" onsubmit="return validateForm(event)">
            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id']); ?>">
            
            <div class="form-group">
                <label for="customer_name">Full Name</label>
                <input type="text" id="customer_name" name="customer_name" oninput="validateInput(this, 'name')">
                <span class="error-message" id="nameError"></span>
            </div>

            <div class="form-group">
                <label for="customer_email">Email</label>
                <input type="email" id="customer_email" name="customer_email" oninput="validateInput(this, 'email')">
                <span class="error-message" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone Number</label>
                <input type="tel" id="customer_phone" name="customer_phone" oninput="validateInput(this, 'phone')">
                <span class="error-message" id="phoneError"></span>
            </div>

            <div class="form-group">
                <label for="booking_date">Booking Date</label>
                <input type="date" id="booking_date" name="booking_date" oninput="validateInput(this, 'date')">
                <span class="error-message" id="dateError"></span>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-check"></i> Confirm Booking
            </button>
        </form>
    </div>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('booking_date').setAttribute('min', today);

        function validateInput(input, type) {
            input.classList.remove('error', 'valid');
            const errorElement = document.getElementById(`${type}Error`);
            errorElement.style.display = 'none';

            switch(type) {
                case 'name':
                    if (input.value.length < 3) {
                        showError(input, errorElement, 'Name must be at least 3 characters long');
                        return false;
                    }
                    break;

                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value)) {
                        showError(input, errorElement, 'Please enter a valid email address');
                        return false;
                    }
                    break;

                case 'phone':
                    const phoneRegex = /^[0-9+\s-]{8,}$/;
                    if (!phoneRegex.test(input.value)) {
                        showError(input, errorElement, 'Please enter a valid phone number (minimum 8 digits)');
                        return false;
                    }
                    break;

                case 'date':
                    const selectedDate = new Date(input.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (!input.value) {
                        showError(input, errorElement, 'Please select a date');
                        return false;
                    }
                    if (selectedDate < today) {
                        showError(input, errorElement, 'Please select a future date');
                        return false;
                    }
                    break;
            }

            input.classList.add('valid');
            return true;
        }

        function showError(input, errorElement, message) {
            input.classList.add('error');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        function validateForm(event) {
            event.preventDefault();
            
            const inputs = {
                name: document.getElementById('customer_name'),
                email: document.getElementById('customer_email'),
                phone: document.getElementById('customer_phone'),
                date: document.getElementById('booking_date')
            };

            let isValid = true;
            for (const [type, input] of Object.entries(inputs)) {
                if (!validateInput(input, type)) {
                    isValid = false;
                }
            }

            if (isValid) {
                showSuccessMessage();
                setTimeout(() => {
                    document.getElementById('bookingForm').submit();
                }, 1000);
            }

            return false;
        }

        function showSuccessMessage() {
            const successMessage = document.createElement('div');
            successMessage.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--success-color);
                color: white;
                padding: 1rem 2rem;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                animation: slideIn 0.5s ease-out;
            `;
            successMessage.textContent = 'Booking validation successful! Processing...';
            document.body.appendChild(successMessage);

            setTimeout(() => {
                successMessage.style.animation = 'slideOut 0.5s ease-in';
                setTimeout(() => successMessage.remove(), 500);
            }, 2500);
        }

        // Add keyframe animations
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOut {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            </style>
        `);
    </script>
</body>
</html> 