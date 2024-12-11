<?php

class User{

    private $UserID;
    private $FirstName;
    private $LastName;
    private $Email;
    private $Password;
    private $Role;


    public function __construct($userID = null, $firstName = null, $lastName = null, $email = null, $password = null, $role = 'User') {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }




        // Getters et Setters pour chaque propriété
        public function getFirstName() {
            return $this->FirstName;
        }
    
        public function setFirstName($FirstName) {
            $this->FirstName = $FirstName;
        }
        
    
    
        public function getLastName() {
            return $this->LastName;
        }
    
        public function setLastName($LastName) {
            $this->LastName = $LastName;
        }
    
    
        public function getUserID() {
            return $this->UserID;
        }
    
        public function setUserID($UserID) {
            $this->UserID = $UserID;
        }
    
        public function getEmail() {
            return $this->Email;
        }
    
        public function setEmail($Email) {
            $this->Email = $Email;
        }
    
        public function getPassword() {
            return $this->Password;
        }
    
        public function setPassword($Password) {
            $this->Password = $Password;
        }

        public function getRole() {
            return $this->Role;
        }
    
        public function setRole($Role) {
            $this->Role = $Role;
        }


    }
?>