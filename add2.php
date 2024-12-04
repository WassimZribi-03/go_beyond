<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="add2_css.css"> <!-- Link to the CSS file -->
</head>
<body>

<?php
require_once "connect.php"; // Include your database connection

if (isset($db)) {
    echo "Connection established.";
} else {
    echo "Connection not established.";
}

// Check database connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to fetch members from the database
function fetchMembers($db) {
    $sql = "SELECT FirstName, LastName, Email FROM users"; // Adjust the query based on your table structure
    $result = $db->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $db->error);
    }

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="list-item">';
            echo '<span class="member-name">' . htmlspecialchars($row['FirstName']) . ' ' . htmlspecialchars($row['LastName']) . '</span>';
            echo '<span class="member-email">' . htmlspecialchars($row['Email']) . '</span>';
            echo '<button class="btn btn-delete" onclick="deleteMember(\'' . htmlspecialchars($row['Email']) . '\')">Delete</button>'; // Pass the email for deletion
            echo '</div>';
        }
    } else {
        echo '<div class="list-item">No members found</div>';
    }
}
?>

<div class="container">
    <div class="card" id="card-event">
        <h3 onclick="toggleList('event')">Event</h3>
        <div class="buttons">
            <button class="btn btn-delete" onclick="openModal('delete', 'event'); event.stopPropagation();">Delete</button>
            <button class="btn btn-add" onclick="openModal('add', 'event'); event.stopPropagation();">Add</button>
        </div>
    </div>
    <div class="card" id="card-guide">
        <h3 onclick="toggleList('guide')">Guide</h3>
        <div class="buttons">
            <button class="btn btn-delete" onclick="openModal('delete', 'guide'); event.stopPropagation();">Delete</button>
            <button class="btn btn-add" onclick="openModal('add', 'guide'); event.stopPropagation();">Add</button>
        </div>
    </div>
    <div class="card" id="card-accommodation">
        <h3 onclick="toggleList('accommodation')">Accommodation</h3>
        <div class="buttons">
            <button class="btn btn-delete" onclick="openModal('delete', 'accommodation'); event.stopPropagation();">Delete</button>
            <button class="btn btn-add" onclick="openModal('add', 'accommodation'); event.stopPropagation();">Add</button>
        </div>
    </div>
    <div class="card" id="card-members" onclick="fetchAndDisplayMembers()">
        <h3>Members</h3>
    </div>
</div>
<!-- search bar  -->
<br>
<div class="search-container">
        <form action="search.php" method="POST">
            <input type="text" name="keyword" class="searchTerm" placeholder="Search here...">
            <button type="submit" class="searchButton">Search</button>
        </form>
    </div>
<br>

<!-- Lists -->
<div class="list-container" id="list-event">
    <div class="list-item">Event 1</div>
    <div class="list-item">Event 2</div>
</div>

<div class="list-container" id="list-guide">
    <div class="list-item">Guide 1</div>
    <div class="list-item">Guide 2</div>
</div>

<div class="list-container" id="list-accommodation">
    <div class="list-item">Accommodation 1</div>
    <div class="list-item">Accommodation 2</div>
</div>


<div class="list-container" id="list-members" style="display: none;">
    <!-- Member details will be displayed here -->
</div>

<!-- Modal -->
<div class="overlay" id="overlay" onclick="closeModal()"></div>
<div class="modal" id="modal">
    <h3 id="modal-title"></h3>
    <form id="modal-form" method="POST" action="process.php">
        <div id="form-content"></div>
        <button type="submit" class="btn-submit">Submit</button>
        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
    </form>
</div>

<script>
    function toggleList(type) {
        const list = document.getElementById(`list-${type}`);
        const isActive = list.classList.contains('active');
        document.querySelectorAll('.list-container').forEach(el => el.classList.remove('active'));
        
        if (!isActive) list.classList.add('active');
    }

    function fetchAndDisplayMembers() {
        const list = document.getElementById('list-members');
        if (list.style.display === "none") {
            list.style.display = "block"; // Show the list
            fetchMembers(); // Call the function to fetch members
        } else {
            list.style.display = "none"; // Hide the list
        }
    }

    function fetchMembers() {
        fetch('fetch_members.php') // Create a separate PHP file to handle fetching
            .then(response => response.text())
            .then(data => {
                document.getElementById('list-members').innerHTML = data;
            })
            .catch(error => console.error('Error fetching members:', error));
    }

    function openModal(action, type) {
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        const modalTitle = document.getElementById('modal-title');
        const formContent = document.getElementById('form-content');

        modalTitle.textContent = `${action === 'delete' ? 'Delete' : 'Add'} ${type}`;
        formContent.innerHTML = action === 'delete'
            ? `<div class="form-group">
                   <label for="email">Enter Email:</label>
                   <input type="text" name="email" id="email" required>
               </div>`
            : generateAddForm(type);

        modal.classList.add('active');
        overlay.classList.add('active');
    }

    function closeModal() {
        document.getElementById('modal').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    }

    function generateAddForm(type) {
        // Add form generation logic here based on type
    }

    function deleteMember(email) {
        if (confirm(`Are you sure you want to delete the member with email: ${email}?`)) {
            fetch('delete_member.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: email }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Member deleted successfully.");
                    fetchAndDisplayMembers(); // Refresh the list
                } else {
                    alert("Error deleting member: " + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }


    function deleteMember(email) {
        if (confirm(`Are you sure you want to delete the member with email: ${email}?`)) {
            // Redirect to delete_member.php with the email as a query parameter
            window.location.href = `delete_member.php?email=${encodeURIComponent(email)}`;
        }
    }


    function searchMembers() {
    const keyword = document.getElementById('searchInput').value;

    // Only proceed if the input is not empty
    if (keyword.length === 0) {
        document.getElementById('list-members').innerHTML = ''; // Clear the list if input is empty
        document.getElementById('list-members').style.display = 'none'; // Hide the list
        return;
    }

    fetch('search.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `keyword=${encodeURIComponent(keyword)}`
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('list-members').innerHTML = data; // Update the member list with the search results
        document.getElementById('list-members').style.display = 'block'; // Show the list
    })
    .catch(error => console.error('Error fetching members:', error));
}

</script>

</body>
</html>