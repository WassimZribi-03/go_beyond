<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Navigation</title>
    <link rel="stylesheet" href="add.css">
</head>
<body>
    <img src="logo150.png" alt="Logo" class="logo">

<br>
    <nav class="navbar">
        <button onclick="showForm('addGuideForm')">Add Guide</button>
        <button onclick="showForm('addEventForm')">Add Event</button>
        <button onclick="showForm('addAccommodationForm')">Add Accommodation</button>
    </nav>
    
    <div class="form-container" id="addGuideForm" style="display: none;">
        <form method="POST" action="process_guide.php">
            <h2>Add Guide</h2>
            <input type="text" name="name" placeholder="Name" required>
            <input type="number" name="id" placeholder="ID" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="number" name="age" placeholder="Age" required>
            <div class="checkbox-group">
                <label>Sex:</label>
                <label><input type="checkbox" name="sex" value="Male"> Male</label>
                <label><input type="checkbox" name="sex" value="Female"> Female</label>
            </div>
            <input type="text" name="location" placeholder="Location" required>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="form-container" id="addEventForm" style="display: none;">
        <form method="POST" action="process_event.php">
            <h2>Add Event</h2>
            <input type="text" name="event_name" placeholder="Event Name" required>
            <input type="text" name="activities" placeholder="Activities" required>
            <input type="text" name="price" placeholder="Price" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="date" name="date" required>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="form-container" id="addAccommodationForm" style="display: none;">
        <form method="POST" action="process_accommodation.php">
            <h2>Add Accommodation</h2>
            <input type="text" name="type" placeholder="Type of Accommodation" required>
            <input type="number" name="rooms" placeholder="Number of Rooms" required>
            <input type="text" name="price" placeholder="Price" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="text" name="location" placeholder="Location" required>
            <textarea name="details" placeholder="Additional Details" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>

    <br>
    <a href="logout.php">logout</a>
    <br>

    <script>
        function showForm(formId) {
            const forms = document.querySelectorAll('.form-container');
            forms.forEach(form => form.style.display = 'none');
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</body>
</html>
