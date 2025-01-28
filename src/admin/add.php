<?php

class AddItemManager extends Database {
    private $table = 'items';

    // add a new item
    public function addNewItem($itemname, $quantity) {
        $columns = 'item_name, item_quantity, active_status_ID';
        $values = "'$itemname', '$quantity', 1";
        $this->insert($this->table, $columns, $values);
    }
}