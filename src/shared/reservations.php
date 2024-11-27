<?php 
class ReservationsManager extends Database {
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }

    public function getUserReservations() {
        $userId = $this->sessionManager->getUserId_number();
        return $this->retrieve(
            'reservations.*, items.item_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservations.id_number = '$userId' 
            AND (reservation_status.reservation_stat = 'reserving' 
            OR reservation_status.reservation_stat = 'disapproved')",
            'reservations.scheduled_reserve_datetime DESC'
        );
    }

    // public function cancelReservation($reserve_id) {
    //     $this->delete(
    //         'reservations',
    //         "reserve_id = '$reserve_id'"
    //     );
    //     return true;
    // }

    public function returnItem($reserve_id) {
        $this->update(
            'reservations',
            'reservation_status_ID = 2',
            "reserve_id = '$reserve_id'"
        );
        return true;
    }

    public function getReservations() {
        return $this->retrieve(
            'reservations.*, items.item_name, accounts.first_name, accounts.last_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN accounts ON reservations.id_number = accounts.id_number 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservation_status.reservation_stat = 'reserving' OR reservation_status.reservation_stat = 'disapproved'"
        );
    }

    
}
