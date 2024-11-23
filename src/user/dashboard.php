<?php

class UserDashboard extends Database {
    private $table = 'reservations';


    public function getDashboardStats($id_number) {
        $reserved = $this->count($this->table, "id_number = '$id_number' AND reservation_status_ID = 1");
        $returned = $this->count($this->table, "id_number = '$id_number' AND reservation_status_ID = 3");
        
        return [
            'reserved' => $reserved,
            'returned' => $returned
        ];
    }
}