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

    private function renderAccountRow($row) {
        return "<tr class='row-border'>
            <form action='accounts.php' method='post'>
                <td><input type='text' name='last_name' value='{$row['last_name']}'></td>
                <td><input type='text' name='first_name' value='{$row['first_name']}'></td>
                <td><input type='text' class='mi' name='middle_initial' value='{$row['middle_initial']}'></td>
                <td><input type='number' name='id_num' value='{$row['id_number']}'></td>
                <td><input type='email' name='email' value='{$row['email']}'></td>
                <td><input type='text' name='password' value='{$row['password']}'>
                <input type='hidden' name='id_number' value='{$row['id_number']}'></td>
                <td><input type='submit' name='submit' value='submit'></td>
                <td><input type='submit' name='delete' value='delete'></td>
            </form>
        </tr>";
    }
}
