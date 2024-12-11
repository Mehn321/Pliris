<?php
class AccountManager extends Database {

    public function getAccounts() {
        $accounts = $this->retrieve('*', 'accounts', '1=1', 'last_name');
        return $accounts;
    }

    public function updateAccount($oldID_number, $newID_number, $last_name, $first_name, $middle_initial, $email, $password) {
        if($oldID_number==999999999){
            echo "<script>alert('you can not change the admin id number sorry');</script>";
            return false;
        }else{
            if (!empty($password)){
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $this->update("accounts", "last_name = '$last_name', first_name = '$first_name',id_number = '$newID_number', middle_initial = '$middle_initial', email = '$email', password = '$hashedPassword'", "id_number = '$oldID_number'");
            }else{
                $this->update("accounts", "last_name = '$last_name', first_name = '$first_name',id_number = '$newID_number', middle_initial = '$middle_initial', email = '$email'", "id_number = '$oldID_number'");
            }
            return true;
        }

    }

    public function deleteAccount($idNumber) {
        $this->delete('accounts', "id_number = '$idNumber'");
    }
}