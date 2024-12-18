<?php

require_once "C:/xampp/htdocs/koll_chy_jdid/config.php";
require_once "C:/xampp/htdocs/koll_chy_jdid/model/user_model.php";

class UserController {

    public function getUsers() {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM users";

        try {
            $query = $conn->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function fetchMembers() {
        $users = $this->getUsers();
        $response = "";

        foreach ($users as $user) {
            $userBlocked = $user['Blocked'] === 'yes';
            $response .= "<div class='member'>";
            $response .= "-Name: " . htmlspecialchars($user['FirstName']) . " " . htmlspecialchars($user['LastName']) . " , ";
            $response .= "Email: " . htmlspecialchars($user['Email']) . " ";
            $response .= "<button class='toggle-button " . ($userBlocked ? 'active' : '') . "' onclick=\"toggleUserBlock('" . htmlspecialchars($user['Email']) . "', " . ($userBlocked ? 'false' : 'true') . ")\">";
            $response .= $userBlocked ? 'Unblock' : 'Block';
            $response .= "</button>";
            $response .= "</div>";
        }

        if (empty($response)) {
            $response = "<p>No members found.</p>";
        }

        echo $response;
    }

    public function unblockUser($email) {
        $conn = config::getConnexion();
        $sql = "UPDATE users SET Blocked = 'NO' WHERE Email = :email";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':email' => $email]);
            echo json_encode(['status' => 'success', 'message' => 'User unblocked successfully.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error unblocking user: ' . $e->getMessage()]);
        }
    }

    public function blockUser($email) {
        $conn = config::getConnexion();
        $sql = "UPDATE users SET Blocked = 'yes' WHERE Email = :email";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':email' => $email]);
            echo json_encode(['status' => 'success', 'message' => 'User blocked successfully.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error blocking user: ' . $e->getMessage()]);
        }
    }

    public function addUser($user) {
        $conn = config::getConnexion();
        $sql = "INSERT INTO users (UserID, FirstName, LastName, Email, Password, Role)
                VALUES (:userID, :firstName, :lastName, :email, :password, :role)";
        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':userID' => $user->getUserID(),
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail(),
                ':password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                ':role' => $user->getRole()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function getUsersByEmail($letter) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM users WHERE Email LIKE :letter";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':letter' => $letter . '%']);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function searchUsersByEmail() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keyword = htmlspecialchars($_POST['keyword']);
            $users = $this->getUsersByEmail($keyword);
            $response = "";
    
            foreach ($users as $user) {
                $userBlocked = $user['Blocked'] === 'yes';
                $response .= "<div class='member'>";
                $response .= "-Name: " . htmlspecialchars($user['FirstName']) . " " . htmlspecialchars($user['LastName']) . " , ";
                $response .= "Email: " . htmlspecialchars($user['Email']) . " ";
                $response .= "<button class='toggle-button " . ($userBlocked ? 'active' : '') . "' onclick=\"toggleUserBlock('" . htmlspecialchars($user['Email']) . "', " . ($userBlocked ? 'false' : 'true') . ")\">";
                $response .= $userBlocked ? 'Unblock' : 'Block';
                $response .= "</button>";
                $response .= "</div>";
            }
    
            if (empty($response)) {
                $response = "<p>No members found.</p>";
            }
    
            echo $response;
        } else {
            die('Invalid request method.');
        }
    }

    
    public function updateUser($id, $user) {
        $conn = config::getConnexion();
        $sql = "UPDATE users SET FirstName = :firstName, LastName = :lastName, Email = :email, 
                Password = :password, Role = :role WHERE UserID = :id";

        try {
            $query = $conn->prepare($sql);
            $query->execute([
                ':id' => $id,
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail(),
                ':password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                ':role' => $user->getRole()
            ]);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function getUserByEmail($email) {
        $conn = config::getConnexion();
        $sql = "SELECT * FROM Users WHERE Email = :email";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':email' => $email]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function loginCheck($email) {
        return $this->getUserByEmail($email);
    }

    public function login($email, $password) {
        $user = $this->getUserByEmail($email); 

        if ($user) {
            // Check if the user is blocked first
            if ($user['Blocked'] === 'yes') {
                return 'This user is suspended.';
            }

            // Now verify the password
            if (password_verify($password, $user['Password'])) {
                session_start();
                $_SESSION['userID'] = $user['UserID']; 
                $_SESSION['role'] = $user['Role']; 

                if ($user['Role'] === 'Admin') {
                    header('Location: http://localhost/koll_chy_jdid/view/back/admin_home.php');
                } else {
                    header('Location: http://localhost/koll_chy_jdid/view/front/home_page.php');
                }
                exit();
            } else {
                return 'Invalid password.';
            }
        } else {
            return 'User not found.';
        }
    }
}


// Handle requests
if (isset($_GET['action'])) {
    $controller = new UserController();
    if ($_GET['action'] === 'fetchMembers') {
        $controller->fetchMembers();
    } elseif ($_GET['action'] === 'blockUser' && isset($_GET['email'])) {
        $controller->blockUser($_GET['email']);
    } elseif ($_GET['action'] === 'unblockUser' && isset($_GET['email'])) {
        $controller->unblockUser($_GET['email']);
    }
}
?>