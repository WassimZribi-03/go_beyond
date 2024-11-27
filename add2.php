<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 50px;
        }
        .card {
            position: relative;
            width: 200px;
            height: 150px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            transition: box-shadow 0.3s;
            cursor: pointer;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .buttons {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            gap: 10px;
        }
        .card:hover .buttons {
            display: flex;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: #fff;
        }
        .btn-add {
            background-color: #2ecc71;
            color: #fff;
        }
        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 350px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            display: none;
            z-index: 1000;
        }
        .modal.active {
            display: block;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
        .overlay.active {
            display: block;
        }
        .modal h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #262626;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }
        .form-group label {
            margin-bottom: 5px;
            font-size: 14px;
            color: #8e8e8e;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #dbdbdb;
            border-radius: 5px;
            background-color: #fafafa;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b2b2b2;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #3897f0;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background-color: #3182d8;
        }
        .btn-cancel {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-cancel:hover {
            background-color: #d6452f;
        }
        .list-container {
            display: none; /* Initially hide the lists */
        }
        .list-container.active {
            display: block; /* Show the list when active */
        }
    </style>
</head>
<body>

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
    <div class="card" id="card-members">
        <h3 onclick="toggleList('members')">Members</h3>
    </div>
</div>

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

<div class="list-container" id="list-members">
    <div class="list-item">
        John Doe (admin) <button class="btn btn-delete" onclick="deleteMember('John Doe')">Delete</button>
    </div>
    <div class="list-item">
        Jane Smith (user) <button class="btn btn-delete" onclick="deleteMember('Jane Smith')">Delete</button>
    </div>
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

    function openModal(action, type) {
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        const modalTitle = document.getElementById('modal-title');
        const formContent = document.getElementById('form-content');

        modalTitle.textContent = `${action === 'delete' ? 'Delete' : 'Add'} ${type}`;
        formContent.innerHTML = action === 'delete'
            ? `<div class="form-group">
                   <label for="id">Enter ${type} ID:</label>
                   <input type="text" name="id" id="id" required>
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
        if (type === 'event') {
            return `
                <div class="form-group">
                    <label for="eventId">Event ID:</label>
                    <input type="text" name="eventId" id="eventId" required>
                </div>
                <div class="form-group">
                    <label for="eventDate">Date:</label>
                    <input type="date" name="eventDate" id="eventDate" required>
                </div>
                <div class="form-group">
                    <label for="eventLocation">Location:</label>
                    <input type="text" name="eventLocation" id="eventLocation" required>
                </div>
                <div class="form-group">
                    <label for="eventPrice">Price:</label>
                    <input type="number" name="eventPrice" id="eventPrice" required>
                </div>
                <div class="form-group">
                    <label for="eventOrganizer">Organizer's Email:</label>
                    <input type="email" name="eventOrganizer" id="eventOrganizer" required>
                </div>
                <div class="form-group">
                    <label for="eventDetails">Details:</label>
                    <textarea name="eventDetails" id="eventDetails" rows="4"></textarea>
                </div>
            `;
        } else if (type === 'guide') {
            return `
                <div class="form-group">
                    <label for="guideFirstName">First Name:</label>
                    <input type="text" name="guideFirstName" id="guideFirstName" required>
                </div>
                <div class="form-group">
                    <label for="guideLastName">Last Name:</label>
                    <input type="text" name="guideLastName" id="guideLastName" required>
                </div>
                <div class="form-group">
                    <label for="guideEmail">Email:</label>
                    <input type="email" name="guideEmail" id="guideEmail" required>
                </div>
                <div class="form-group">
                    <label for="guidePhone">Phone Number:</label>
                    <input type="text" name="guidePhone" id="guidePhone" required>
                </div>
                <div class="form-group">
                    <label for="guideAge">Age:</label>
                    <input type="number" name="guideAge" id="guideAge" required>
                </div>
                <div class="form-group">
                    <label for="guideLocation">Location:</label>
                    <input type="text" name="guideLocation" id="guideLocation" required>
                </div>
                <div class="form-group">
                    <label for="guideCharge">Charge Per Hour:</label>
                    <input type="number" name="guideCharge" id="guideCharge" required>
                </div>
            `;
        } else if (type === 'accommodation') {
            return `
                <div class="form-group">
                    <label for="accommodationType">Accommodation Type:</label>
                    <select name="accommodationType" id="accommodationType" required>
                        <option value="BnB">BnB</option>
                        <option value="Hotel">Hotel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="accommodationPrice">Price Per Night:</label>
                    <input type="number" name="accommodationPrice" id="accommodationPrice" required>
                </div>
                <div class="form-group">
                    <label for="accommodationBeds">Number of Beds:</label>
                    <input type="number" name="accommodationBeds" id="accommodationBeds" required>
                </div>
                <div class="form-group">
                    <label for="accommodationOwnerPhone">Owner's Phone Number:</label>
                    <input type="text" name="accommodationOwnerPhone" id="accommodationOwnerPhone" required>
                </div>
                <div class="form-group">
                    <label for="accommodationOwnerName">Owner's Name:</label>
                    <input type="text" name="accommodationOwnerName" id="accommodationOwnerName" required>
                </div>
                <div class="form-group">
                    <label for="accommodationDetails">Details:</label>
                    <textarea name="accommodationDetails" id="accommodationDetails" rows="4"></textarea>
                </div>
            `;
        }
    }

    function deleteMember(member) {
        alert(`Deleted ${member}`);
    }
</script>

</body>
</html>