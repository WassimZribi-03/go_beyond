<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="admin_home.css">
</head>
<body>
<div class="header">
    <div class="profile">
        <div class="profile-pic"><img src="logo75.png" alt=""></div>
        <div class="profile-text">
            <span class="name">Admin</span>
            <span class="title">edit</span>
        </div>
    </div>
    <div class="nav">
        <div class="search-container">
            <input type="text" class="search-bar" placeholder="Search by email...">
            <button class="search-button">Search</button>
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

    function deleteUser(email) {
        console.log("Deleting user with email:", email);
        if (confirm(`Are you sure you want to delete the user with email: ${email}?`)) {
            fetch('../../controller/user_controller.php?action=deleteUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ email: email })
            })
            // mochkla lhneee !!!!! 
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchAndDisplayMembers();
            })
            .catch(error => {
                console.error('Error deleting user:', error);
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
</script>

</body>
</html>