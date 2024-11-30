<?php

class AddItemManager extends Database {
    private $table = 'items';


    public function addNewItem($itemname, $quantity) {
        $columns = 'item_name, item_quantity, item_quantity_reserved, active_status_ID';
        $values = "'$itemname', '$quantity', 0, 1";
        
        $this->insert($this->table, $columns, $values);
    }
}