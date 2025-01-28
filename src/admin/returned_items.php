<?php
class ReturnedItemsManager extends Database {
    private $table = 'reservations';

    // Retrieve all items pending return
    public function getReturnedItems() {
        return $this->retrieve(
            'reservations.*, items.item_name, accounts.first_name, accounts.last_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN accounts ON reservations.id_number = accounts.id_number 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservation_status.reservation_stat = 'pending_return'"
        );
    }

    // Approve the return of an item
    public function approveReturn($reserve_id) {
        $this->update($this->table, 'reservation_status_ID = 3', "reserve_id = '$reserve_id'");
    }

    // Create a record of the return
    public function createRecord($reserve_id) {
        $this->insert('records', "reserve_id", "$reserve_id");
    }


    // Disapprove the return of an item
    public function disapproveReturn($reserve_id) {
        $this->update($this->table, 'reservation_status_ID = 4', "reserve_id = '$reserve_id'");
    }

    // Get information about a specific item return
    public function getItemInfo($reserve_id) {
        return $this->retrieve(
            'items.item_name, reservations.id_number, items.item_id',
            'reservations JOIN items ON reservations.item_id = items.item_id',
            "reserve_id = '$reserve_id'"
        )->fetch_assoc();
    }
}

