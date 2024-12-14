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
            'reservations.reserve_id ASC'
        );
    }

    public function cancelReservation($reserve_id, $quantity_reserved, $item_id) {
        $this->update_items_quantity_reserved($quantity_reserved, $item_id);
        $this->delete(
            'reservations',
            "reserve_id = '$reserve_id'"
        );
        return true;
    }

    public function returnItem($reserve_id) {

        $this->update(
            'reservations',
            "reservation_status_ID = 2, returned_datetime = NOW()",
            "reserve_id = '$reserve_id'"
        );
        return true;
    }

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

    
    private function update_items_quantity_reserved(int $item_quantity_tocancel, int $item_id){
        $this->update('items', 
            "item_quantity_reserved = item_quantity_reserved - $item_quantity_tocancel", 
            "item_id = $item_id"
        );
    }
}
