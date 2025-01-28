<?php

// This class extends the Database class to manage user dashboard data
class UserDashboard extends Database {
    // Table name for reservations
    private $table = 'reservations';

    // Retrieve dashboard statistics for a given user
    public function getDashboardStats($id_number) {
        // Count the number of reserved items for the user
        $reserved = $this->count($this->table, "id_number = '$id_number' AND reservation_status_ID = 1");
        
        // Count the number of returned items for the user
        $returned = $this->count($this->table, "id_number = '$id_number' AND reservation_status_ID = 3");
        
        // Return the statistics as an associative array
        return [
            'reserved' => $reserved,
            'returned' => $returned
        ];
    }
}
