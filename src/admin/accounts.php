<?php
session_start();
class AccountManager extends Database {
    private $table = 'accounts';
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }

    public function getAccounts() {
        $accounts = $this->retrieve('*', $this->table, '1=1', 'last_name');
        return $accounts;
    }

    public function updateAccount($oldID_number, $newID_number, $last_name, $first_name, $middle_initial, $email, $password) {
        // $_SESSION['id_number']=$id_number;
        // $id_num=$_SESSION['id_number'];
            // if($oldID_number==$this->sessionManager->getAdminId()){
            //     $this->sessionManager->setAdminId($newID_number);
            // }
        if($oldID_number==99999999){
            echo "alert('you can't change the admin id number sorry')";
        }
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