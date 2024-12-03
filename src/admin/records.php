<?php

class RecordsManager extends Database {

        public function getAllRecords() {
        return $this->conn->query("SELECT reservations.returned_datetime, reservations.quantity_reserved, reservations.scheduled_reserve_datetime, items.item_name, accounts.first_name, accounts.last_name, reservation_status.reservation_stat
        FROM records INNER JOIN reservations ON records.reserve_id = reservations.reserve_id
        INNER JOIN items ON reservations.item_id = items.item_id
        INNER JOIN accounts ON reservations.id_number = accounts.id_number
        INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID
        ORDER BY reservations.scheduled_reserve_datetime DESC
        ");
    }


}
