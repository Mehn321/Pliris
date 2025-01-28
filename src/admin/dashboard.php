<?php
class AdminDashboard extends Database {

    // get the admin dashboard statistics
    public function getDashboardStats() {
        return [
            'items' => $this->count('items', 'active_status_ID = 1'),
            'reserved' => $this->count('reservations', 'reservation_status_ID = 1'),
            'returned' => $this->count('reservations', 'reservation_status_ID = 2'),
            'accounts' => $this->count('accounts', 'active_status_id=1')
        ];
    }
}