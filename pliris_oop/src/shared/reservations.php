<?php

session_start();

class ReservationManager extends Database {
    private $table = 'reservations';

    public function handleReservation($data) {
        $item_id = $data['item_id'];
        $quantity_toreserve = $data['quantity'];
        $scheduled_reserve_datetime = $data['scheduled_reserve_datetime'];
        $scheduled_return_datetime = $data['scheduled_return_datetime'];
        $availableAtTime = $data['availableAtTime'];

        if ($availableAtTime < $quantity_toreserve) {
            return ['success' => false, 'message' => "Not enough items available. Only $availableAtTime items are available."];
        }

        $this->beginTransaction();
        try {
            $this->updateItemReservation($item_id, $quantity_toreserve);
            $this->createReservation($data);
            $this->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $this->rollback();
            return ['success' => false, 'message' => 'Failed to create reservation'];
        }
    }

    private function updateItemReservation($item_id, $quantity) {
        $current = $this->retrieve('item_quantity_reserved', 'items', "item_id = $item_id")->fetch_assoc();
        $new_quantity = $current['item_quantity_reserved'] + $quantity;
        $this->update('items', "item_quantity_reserved = $new_quantity", "item_id = $item_id");
    }

    private function createReservation($data) {
        $columns = 'id_number, item_id, reservation_status_ID, quantity_reserved, scheduled_reserve_datetime, scheduled_return_datetime';
        $values = "'{$data['id_number']}', {$data['item_id']}, 1, {$data['quantity']}, '{$data['scheduled_reserve_datetime']}', '{$data['scheduled_return_datetime']}'";
        $this->insert($this->table, $columns, $values);
    }


    public function getReservations($where) {
        return $this->retrieve(
            'reservations.*, items.item_name, accounts.first_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN accounts ON reservations.id_number = accounts.id_number 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            $where . " AND (reservation_status.reservation_stat = 'reserving' OR reservation_status.reservation_stat = 'disapproved')"
        );
    }

    private function renderReservationTable($reservations) {
        $output = '<table><tr class="row-border">
            <th>Borrower</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Reserved Schedule</th>
            <th>Return Schedule</th>
            <th>Action</th>
        </tr>';

        while ($row = $reservations->fetch_assoc()) {
            $output .= $this->renderReservationRow($row);
        }

        return $output . '</table>';
    }

    private function renderReservationRow($row) {
        $reserve_datetime = new DateTime($row['scheduled_reserve_datetime']);
        $return_datetime = new DateTime($row['scheduled_return_datetime']);
        
        return "<tr class='row-border'>
            <td>{$row['first_name']}</td>
            <td>{$row['item_name']}</td>
            <td>{$row['quantity_reserved']}</td>
            <td>{$reserve_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>{$return_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>
                <form action='reserved_items.php' method='post'>
                    <input type='hidden' name='reserve_id' value='{$row['reserve_id']}'>
                    <input type='submit' name='submit' value='return'>
                </form>
            </td>
        </tr>";
    }
}