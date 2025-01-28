<?php 
class ReservationsManager extends Database {
    private $sessionManager;

    // Constructor to initialize session manager
    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }

    // Retrieve reservations for the current user
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
            'reservations.reserve_id ASC'
        );
    }

    // Cancel a reservation and update item quantity
    public function cancelReservation($reserve_id, $quantity_reserved, $item_id) {
        $this->delete(
            'reservations',
            "reserve_id = '$reserve_id'"
        );
        return true;
    }

    // Mark an item as returned
    public function returnItem($reserve_id) {
        $this->update(
            'reservations',
            "reservation_status_ID = 2, returned_datetime = NOW()",
            "reserve_id = '$reserve_id'"
        );
        return true;
    }

    // Retrieve all reservations that are not yet returned
    public function getReservations() {
        return $this->retrieve(
            'reservations.*,items.item_id, items.item_name, accounts.first_name, accounts.last_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN accounts ON reservations.id_number = accounts.id_number 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservation_status.reservation_stat = 'reserving' OR reservation_status.reservation_stat = 'disapproved'"
        );
    }
}