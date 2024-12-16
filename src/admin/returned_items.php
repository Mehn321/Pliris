<?php
class ReturnedItemsManager extends Database {
    private $table = 'reservations';

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

    public function approveReturn($reserve_id) {
        $this->update($this->table, 'reservation_status_ID = 3', "reserve_id = '$reserve_id'");
    }

    public function createRecord($reserve_id) {
        $this->insert('records', "reserve_id", "$reserve_id");
    }

    public function update_items_quantity_reserved(int $item_quantity_toreturn, int $item_id){
        $this->update('items', 
            "item_quantity_reserved = item_quantity_reserved - $item_quantity_toreturn", 
            "item_id = $item_id"
        );
    }

    public function disapproveReturn($reserve_id){
        $this->update($this->table, 'reservation_status_ID = 4', "reserve_id = '$reserve_id'");
    }

    public function getItemInfo($reserve_id) {
        return $this->retrieve(
            'items.item_name, reservations.id_number, items.item_id',
            'reservations JOIN items ON reservations.item_id = items.item_id',
            "reserve_id = '$reserve_id'"
        )->fetch_assoc();
    }
}
