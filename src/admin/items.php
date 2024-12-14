<?php
class ItemManager extends Database {

    //reurn all active items sorted by name
    public function getActiveItems() {
        return $this->retrieve(
            'items.item_id, items.item_name, items.item_quantity, items.item_quantity_reserved, active_status.active_stat',
            'items JOIN active_status ON items.active_status_ID = active_status.active_status_ID',
            "active_status.active_stat='active'",
            'items.item_name'
        );
    }

    //update item details
    public function updateItem($item_id, $item_name=NULL, $item_quantity=NULL) {
        if ($item_name != NULL) {
            $this->update("items", "item_name='{$item_name}'", "item_id='$item_id'");
        }
        if ($item_quantity != NULL) {
            $this->update("items", "item_quantity='{$item_quantity}'", "item_id='$item_id'");
        }
    }

    //delete item
    public function deleteItem($item_id) {
        $this->update("items", "active_status_ID=2", "item_id='$item_id'");
    }
}