
<?php
class UserModel {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    public function getUserByIdNumber($id_number) {
        return $this->db->retrieve("*", "accounts", "id_number='$id_number'");
    }

    public function createUser($first_name, $last_name, $id_number, $email, $middle_initial, $password) {
        $columns = "first_name, last_name, id_number, email, middle_initial, password";
        $values = "'$first_name','$last_name','$id_number','$email','$middle_initial','$password'";
        return $this->db->insert("accounts", $columns, $values);
    }

    public function validateLogin($id_number, $password) {
        $result = $this->getUserByIdNumber($id_number);
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $password == $user['password'];
        }
        return false;
    }

    public function getUserDetails($id_number) {
        return $this->db->retrieve("first_name, last_name, middle_initial", "accounts", "id_number='$id_number'");
    }

    public function checkExistingUser($id_number) {
        $result = $this->getUserByIdNumber($id_number);
        return $result->num_rows > 0;
    }

    public function getAdminDetails() {
        return $this->db->retrieve("first_name, last_name", "accounts", "id_number='999999999'");
    }

    public function updateUserProfile($id_number, $data) {
        $set = "";
        foreach($data as $key => $value) {
            $set .= "$key='$value',";
        }
        $set = rtrim($set, ',');
        return $this->db->update("accounts", $set, "id_number='$id_number'");
    }

    public function getUnseenNotifications($id_number) {
        $sql = "SELECT accounts.middle_initial, COUNT(CASE WHEN notifications.notification_status_id = '2' THEN 1 END) as unseenNotifications 
                FROM accounts LEFT JOIN notifications ON accounts.id_number = notifications.id_number 
                WHERE accounts.id_number = '$id_number'";
        return $this->db->query($sql);
    }

    public function getUserReservations($id_number) {
        $sql = "SELECT * FROM reservations WHERE id_number = '$id_number'";
        return $this->db->query($sql);
    }

    public function deleteUser($id_number) {
        return $this->db->delete("accounts", "id_number='$id_number'");
    }
}
