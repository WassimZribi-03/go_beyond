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
            $response .= "<div class='member'>";
            $response .= "-Name: " . htmlspecialchars($user['FirstName']) . " " . htmlspecialchars($user['LastName']) . " , ";
            $response .= "Email: " . htmlspecialchars($user['Email']) . " ";
            $response .= "<button class='btn-delete' onclick=\"deleteUser('" . htmlspecialchars($user['Email']) . "')\">Delete</button>";
            $response .= "</div>";
        }

        if (empty($response)) {
            $response = "<p>No members found.</p>";
        }

        echo $response;
    }

    public function deleteUser($email) {
        $conn = config::getConnexion();
        $sql = "DELETE FROM users WHERE Email = :email";
        try {
            $query = $conn->prepare($sql);
            $query->execute([':email' => $email]);
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting user: ' . $e->getMessage()]);
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
                ':password' => $user->getPassword(),
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
            include 'C:/xampp/htdocs/koll_chy_jdid/view/back/admin_home.php';
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
                ':password' => $user->getPassword(),
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

if (isset($_GET['action']) && $_GET['action'] === 'fetchMembers') {
    $controller = new UserController();
    $controller->fetchMembers();
}

if (isset($_POST['action']) && $_POST['action'] === 'deleteUser') {
    $email = $_POST['email'];
    $controller = new UserController();
    $controller->deleteUser($email);
}