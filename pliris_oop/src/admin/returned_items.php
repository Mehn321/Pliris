<?php
class ReturnedItemsManager extends Database {
    private $table = 'reservations';

    public function handleReturn($data) {
        if (isset($data['approve'])) {
            $this->approveReturn($data['reserve_id']);
        } else if (isset($data['disapprove'])) {
            $this->disapproveReturn($data);
        }
    }

    public function displayReturnedItems() {
        echo '<div class="container">
            <table>
                <tr class="row-border">
                    <th>Borrower</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Returned Time</th>
                    <th>Action</th>
                </tr>';

        $returns = $this->getReturnedItems();
        while ($row = $returns->fetch_assoc()) {
            echo $this->renderReturnRow($row);
        }
        echo '</table></div>';
    }

    public function getReturnedItems() {
        return $this->retrieve(
            'reservations.*, items.item_name, accounts.first_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN accounts ON reservations.id_number = accounts.id_number 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservation_status.reservation_stat = 'returned'"
        );
    }

    public function approveReturn($reserve_id) {
        $this->update($this->table, 'reservation_status_ID = 3', "reserve_id = '$reserve_id'");
    }

    public function disapproveReturn($data) {
        $reserve_id = $data['reserve_id'];
        $quantity_reserved = $data['quantity_reserved'];
        
        $itemInfo = $this->getItemInfo($reserve_id);
        $this->createDisapprovalNotification($itemInfo, $quantity_reserved);
        $this->update($this->table, 'reservation_status_ID = 4', "reserve_id = '$reserve_id'");
    }

    public function getItemInfo($reserve_id) {
        return $this->retrieve(
            'items.item_name, reservations.id_number, items.item_id',
            'reservations JOIN items ON reservations.item_id = items.item_id',
            "reserve_id = '$reserve_id'"
        )->fetch_assoc();
    }

    public function createDisapprovalNotification($itemInfo, $quantity) {
        $currentTime = date('M-d-Y h:i:s:a');
        $admin = $this->getAdminInfo();
        $message = "Your reservation_status item {$itemInfo['item_name']} with the quantity of $quantity is disapproved at $currentTime. Please return the item/items or you can approach the moderator Mr/Maam: {$admin['first_name']} {$admin['last_name']}.";
        
        $this->insert(
            'notifications', 
            'id_number, notification_status_id, message',
            "'{$itemInfo['id_number']}', 1, '$message'"
        );
    }

    private function getAdminInfo() {
        return $this->retrieve('first_name, last_name', 'accounts', "id_number='999999999'")->fetch_assoc();
    }

    private function renderReturnRow($row) {
        $returned_datetime = new DateTime($row['returned_datetime']);
        return "<tr class='row-border'>
            <td>{$row['first_name']}</td>
            <td>{$row['item_name']}</td>
            <td>{$row['quantity_reserved']}</td>
            <td>{$returned_datetime->format('M-d-Y h:i:s:a')}</td>
            <form action='returned_items.php' method='post'>
                <td>
                    <input type='hidden' name='quantity_reserved' value='{$row['quantity_reserved']}'>
                    <input type='hidden' name='reserve_id' value='{$row['reserve_id']}'>
                    <input type='submit' name='approve' value='approve'>
                    <input type='submit' name='disapprove' value='disapprove'>
                </td>
            </form>
        </tr>";
    }
}
