<?php

class AccountManager extends Database {
    private $table = 'accounts';

    public function handleFormSubmission() {
        if (isset($_POST['submit'])) {
            $this->updateAccount($_POST);
        }
        if (isset($_POST['delete'])) {
            $this->deleteAccount($_POST['id_number']);
        }
    }

    public function getAccounts() {
        $accounts = $this->retrieve('*', $this->table, '1=1', 'last_name');
        return $accounts;
    }

    public function updateAccount($data) {
        $set = "last_name = '{$data['last_name']}',
                first_name = '{$data['first_name']}',
                middle_initial = '{$data['middle_initial']}',
                id_number = '{$data['id_num']}',
                email = '{$data['email']}',
                password = '{$data['password']}'";
        
        $this->update($this->table, $set, "id_number = '{$data['id_number']}'");
    }

    public function deleteAccount($idNumber) {
        $this->delete($this->table, "id_number = '$idNumber'");
    }

}
