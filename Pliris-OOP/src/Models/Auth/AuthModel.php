<?php

class AuthModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function login($id_number, $password) {
        $result = $this->db->query("SELECT * FROM accounts WHERE id_number='$id_number'");
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($password == $row['password']) {
                return $row;
            }
        }
        return false;
    }

    public function register($first_name, $last_name, $id_number, $email, $middle_initial, $password) {
        $check = $this->db->query("SELECT * FROM accounts WHERE id_number='$id_number'");
        
        if($check->num_rows > 0) {
            return false;
        }

        $query = "INSERT INTO accounts (first_name, last_name, id_number, email, middle_initial, password) 
                VALUES ('$first_name', '$last_name', '$id_number', '$email', '$middle_initial', '$password')";
        
        return $this->db->query($query);
    }

    public function getUserDetails($id_number) {
        $result = $this->db->query("SELECT * FROM accounts WHERE id_number='$id_number'");
        return $result->fetch_assoc();
    }
}
