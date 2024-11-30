<?php
class AdminDashboard extends Database {
    public function getDashboardStats() {
        return [
            'items' => $this->count('items', 'active_status_ID = 1'),
            'reserved' => $this->count('reservations', 'reservation_status_ID = 1'),
            'returned' => $this->count('reservations', 'reservation_status_ID = 3'),
            'accounts' => $this->count('accounts', '1=1')
        ];
    }
}