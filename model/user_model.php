<?php

class User{

    private $UserID;
    private $FirstName;
    private $LastName;
    private $Email;
    private $Password;
    private $Role;
    private $Blocked;


    public function __construct($userID = null, $firstName = null, $lastName = null, $email = null, $password = null, $role = 'User' , $blocked = 'no'){
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->blocked==$blocked ;
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
        
        public function getBlocked(){
            return $this->Blocked;
        }

        public function setBlocked($Blocked){
            $this->Blocked = $Blocked;
        }

    }
?>