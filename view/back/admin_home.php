<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="admin_home.css">
</head>
<style>
    .toggle-button {
        background-color:rgb(28, 27, 106); /* Primary color */
        color: white;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
        transition: background-color 0.3s, transform 0.2s;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .toggle-button:hover {
        background-color: #0056b3; /* Darker shade on hover */
        transform: translateY(-2px);
    }

    .toggle-button.active {
        background-color: #dc3545; /* Danger color */
    }

    .toggle-button.active:hover {
        background-color: #c82333; /* Darker shade for active button on hover */
    }

    /* Additional styles for other elements */
    .header {
        /* Your header styles */
    }

    .container {
        /* Your container styles */
    }
0
    /* Add more styles as needed */
</style>
<body>
<div class="header">
    <div class="profile">
        <div class="profile-pic"><img src="mogo150.png" alt=""></div>
        <div class="profile-text">
            <span class="name">Admin</span>
            <span class="title">edit</span>
        </div>
    </div>
    <div class="nav">
        <div class="search-container">
        <form action="" method="post">
            <input type="text" class="search-bar" placeholder="Search by email... "  onkeyup="searchUsers()">
            <button class="search-button">Search</button>
</form>
        </div>
        <div class="nav-item">edit profile</div>
        <div class="nav-item">Settings</div>
        <div class="nav-item">logout</div>
    </div>
</div>

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

<div class="list-container" id="list-members" style="display: none;">
</div>

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
        const listContainer = document.getElementById('list-members');

        if (listContainer.style.display === 'none') {
            listContainer.style.display = 'block';

            fetch('../../controller/user_controller.php?action=fetchMembers')
                .then(response => response.text())
                .then(data => {
                    listContainer.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching members:', error);
                    listContainer.innerHTML = "<p>Error loading members.</p>";
                });
        } else {
            listContainer.style.display = 'none';
        }
    }

    function blockUser(email) {
        if (confirm("Are you sure you want to block this user?")) {
            fetch('../../controller/user_controller.php?action=blockUser&email=' + encodeURIComponent(email), {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    fetchAndDisplayMembers(); // Refresh the user list
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    function openModal(action, type) {
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        const modalTitle = document.getElementById('modal-title');
        const formContent = document.getElementById('form-content');

        modalTitle.textContent = `${action === 'delete' ? 'Delete' : 'Add'} ${type}`;
        formContent.innerHTML = action === 'delete'
            ? `<div class="form-group"><label for="email">Enter Email:</label><input type="text" name="email" id="email" required></div>`
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


    function toggleUserBlock(email, isBlocked) {
    const action = isBlocked ? 'blockUser' : 'unblockUser';
    fetch('../../controller/user_controller.php?action=' + action + '&email=' + encodeURIComponent(email), {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            fetchAndDisplayMembers();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function searchUsers() {
    const keyword = document.querySelector('.search-bar').value;

    fetch('../../controller/user_controller.php?action=searchUsersByEmail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'keyword=' + encodeURIComponent(keyword)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('list-members').innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching search results:', error);
    });
}
</script>

</body>
</html>