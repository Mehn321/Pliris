<?php
class ItemManager extends Database {
    private $table = 'items';

    public function handleItemActions() {
        if (isset($_POST['submit'])) {
            $this->updateItem($_POST);
        }
        if (isset($_POST['delete'])) {
            $this->deleteItem($_POST['item_id']);
        }
    }


    public function getActiveItems() {
        return $this->retrieve(
            'items.item_id, items.item_name, items.item_quantity, items.item_quantity_reserved, active_status.active_stat',
            'items JOIN active_status ON items.active_status_ID = active_status.active_status_ID',
            "active_status.active_stat='active'",
            'items.item_name'
        );
    }

    public function updateItem($item_id, $item_name=NULL, $item_quantity=NULL) {
        if (!empty($item_name)) {
            $this->update($this->table, "item_name='{$item_name}'", "item_id='$item_id'");
        }
        if (!empty($item_quantity)) {
            $this->update($this->table, "item_quantity='{$item_quantity}'", "item_id='$item_id'");
        }
    }

    public function deleteItem($item_id) {
        $this->update($this->table, "active_status_ID=2", "item_id='$item_id'");
    }
}