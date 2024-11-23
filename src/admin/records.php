<?php

class RecordsManager extends Database {

    public function getAllRecords() {
        return $this->retrieve(
            'reservations.*, items.item_name, accounts.first_name, accounts.last_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN accounts ON reservations.id_number = accounts.id_number 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            '1=1',
            'reservations.scheduled_reserve_datetime DESC'
        );
    }


}
