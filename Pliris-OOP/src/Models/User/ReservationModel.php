<?php
class ReservationModel {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    public function createReservation($id_number, $item_id, $quantity_reserved, $scheduled_reserve_datetime, $scheduled_return_datetime) {
        $columns = "id_number, item_id, reservation_status_ID, quantity_reserved, scheduled_reserve_datetime, scheduled_return_datetime";
        $values = "'$id_number', '$item_id', '1', '$quantity_reserved', '$scheduled_reserve_datetime', '$scheduled_return_datetime'";
        return $this->db->insert("reservations", $columns, $values);
    }

    public function getReservationsByUser($id_number) {
        $sql = "SELECT reservations.*, items.item_name, reservation_status.reservation_stat 
                FROM reservations 
                INNER JOIN items ON reservations.item_id = items.item_id 
                INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                WHERE reservations.id_number = '$id_number'";
        return $this->db->query($sql);
    }

    public function updateReservationStatus($reserve_id, $status_id) {
        return $this->db->update("reservations", "reservation_status_ID='$status_id'", "reserve_id='$reserve_id'");
    }

    public function checkItemAvailability($item_id, $scheduled_reserve_datetime, $scheduled_return_datetime) {
        $sql = "SELECT items.item_quantity - COALESCE(SUM(reservations.quantity_reserved), 0) as available_quantity 
                FROM items 
                LEFT JOIN reservations ON items.item_id = reservations.item_id 
                WHERE items.item_id = '$item_id' 
                AND (reservations.scheduled_reserve_datetime BETWEEN '$scheduled_reserve_datetime' AND '$scheduled_return_datetime' 
                OR reservations.scheduled_return_datetime BETWEEN '$scheduled_reserve_datetime' AND '$scheduled_return_datetime')";
        return $this->db->query($sql);
    }

    public function getReservationDetails($reserve_id) {
        $sql = "SELECT reservations.*, items.item_name, accounts.first_name, accounts.last_name 
                FROM reservations 
                INNER JOIN items ON reservations.item_id = items.item_id 
                INNER JOIN accounts ON reservations.id_number = accounts.id_number 
                WHERE reservations.reserve_id = '$reserve_id'";
        return $this->db->query($sql);
    }

    public function updateReturnDateTime($reserve_id) {
        return $this->db->update("reservations", "returned_datetime=NOW(), reservation_status_ID=2", "reserve_id='$reserve_id'");
    }

    public function getOverdueReservations($id_number) {
        $sql = "SELECT reservations.*, items.item_name 
                FROM reservations 
                INNER JOIN items ON reservations.item_id = items.item_id 
                INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                WHERE reservation_status.reservation_stat='reserving' 
                AND reservations.id_number='$id_number' 
                AND scheduled_return_datetime <= NOW()";
        return $this->db->query($sql);
    }

    public function checkReservationConflicts($item_id, $start_date, $end_date) {
        $sql = "SELECT COUNT(*) as conflicts FROM reservations 
                WHERE item_id = '$item_id' 
                AND ((scheduled_reserve_datetime <= '$start_date' AND scheduled_return_datetime >= '$start_date') 
                OR (scheduled_reserve_datetime <= '$end_date' AND scheduled_return_datetime >= '$end_date'))";
        return $this->db->query($sql);
    }

    public function getReservedItems() {
        $sql = "SELECT reservations.*, items.item_name, accounts.first_name, accounts.last_name 
                FROM reservations 
                INNER JOIN items ON reservations.item_id = items.item_id 
                INNER JOIN accounts ON reservations.id_number = accounts.id_number 
                WHERE reservations.reservation_status_ID = 1";
        return $this->db->query($sql);
    }

    public function getReturnedItems() {
        $sql = "SELECT reservations.*, items.item_name, accounts.first_name, accounts.last_name 
                FROM reservations 
                INNER JOIN items ON reservations.item_id = items.item_id 
                INNER JOIN accounts ON reservations.id_number = accounts.id_number 
                WHERE reservations.reservation_status_ID = 2";
        return $this->db->query($sql);
    }
}
