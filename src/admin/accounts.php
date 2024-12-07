<?php
class AccountManager extends Database {
    private $table = 'accounts';


    public function getAccounts() {
        $accounts = $this->retrieve('*', $this->table, '1=1', 'last_name');
        return $accounts;
    }

    public function updateAccount($oldID_number, $newID_number, $last_name, $first_name, $middle_initial, $email, $password) {

        if (!empty($password)){
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->update("accounts", "last_name = '$last_name', first_name = '$first_name',id_number = '$newID_number', middle_initial = '$middle_initial', email = '$email', password = '$hashedPassword'", "id_number = '$oldID_number'");
        }else{
            $this->update("accounts", "last_name = '$last_name', first_name = '$first_name',id_number = '$newID_number', middle_initial = '$middle_initial', email = '$email'", "id_number = '$oldID_number'");
        }
    }

    public function deleteAccount($idNumber) {
        $this->delete($this->table, "id_number = '$idNumber'");
    }
}