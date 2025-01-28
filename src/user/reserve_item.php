<?php 
/**
 * Class ReserveItemManager
 * Handles all item reservation operations including availability checks and reservation processing
 * Extends the Database class for database operations
 */
class ReserveItemManager extends Database {
    private $available_quantity;
    
    /**
     * Handles the submission of reservation date and time
     * Stores the scheduled reserve and return datetime in session
     * Returns true if submission is successful, false otherwise
     */
    public function handleDateTimeSubmission() {
        if (isset($_POST['submit'])) {
            $_SESSION['scheduled_reserve_datetime'] = $_POST['scheduled_reserve_datetime'];
            $_SESSION['scheduled_return_datetime'] = $_POST['scheduled_return_datetime'];
            return true;
        }
        return false;
    }
    

    /**
     * Retrieves all active items from the database
     * Returns result set of available items sorted by item name
     */
    public function getAvailableItems() {
        return $this->retrieve(
            'items.*, active_status.active_stat',
            'items JOIN active_status ON items.active_status_ID = active_status.active_status_ID',
            "active_status.active_stat='active'",
            'items.item_name'
        );
    }
    
    /**
     * Calculates the available quantity for a specific item
     * Takes item ID and total quantity as inputs
     * Returns available quantity (minimum 0)
     */
    public function calculateAvailableQuantity($item_id,$quantity) {
        $reservedAtTime = $this->getReservedQuantityAtTime($item_id);
        $this->available_quantity = $quantity - $reservedAtTime;
        if($this->available_quantity < 0){
            $this->available_quantity = 0;
        }
        return $this->available_quantity;
    }
    
    /**
     * Gets the total quantity of items reserved for a specific time period
     * Takes item ID as input and returns total quantity reserved
     */
    public function getReservedQuantityAtTime($itemId) {
        $startTime = $_SESSION['scheduled_reserve_datetime'];
        $endTime = $_SESSION['scheduled_return_datetime'];
        $result = $this->retrieve(
            'SUM(quantity_reserved) AS total_reserved',
            'reservations',
            "item_id = '$itemId'
            AND reservation_status_ID = 1
            AND(
                (scheduled_reserve_datetime >= '$startTime' AND scheduled_return_datetime <= '$startTime') OR
                (scheduled_reserve_datetime <= '$endTime' AND scheduled_return_datetime >= '$endTime') OR
                (scheduled_reserve_datetime = '$startTime' AND scheduled_return_datetime = '$endTime')
            )")->fetch_assoc();
            if(isset($result['total_reserved'])){
                return $result['total_reserved'];
            }else{
                return 0;
            }
        }
        
    /**
     * Creates a new reservation record in the database
     * Takes item ID, quantity, and user ID as inputs
     * Returns true if reservation is created successfully
     */
    private function createReservation($item_id, $quantity, $user_id) {
        $columns = 'id_number, item_id, quantity_reserved, scheduled_reserve_datetime, scheduled_return_datetime, reservation_status_ID';
        $values = "'$user_id', 
            '$item_id', 
            '$quantity', 
            '{$_SESSION['scheduled_reserve_datetime']}', 
            '{$_SESSION['scheduled_return_datetime']}',
            1";
        
        $this->insert('reservations', $columns, $values);
        
        return true;
    }
    
    /**
     * Validates if requested quantity is available
     * Takes requested quantity and available quantity as inputs
     * Returns true if quantity is valid
     */
    private function isquantityValid($quantity, $availableAtTime){
        if ($quantity > $availableAtTime) {
            return false;
        }else {
            return true;
        }
    }

    /**
     * Processes multiple item reservations in a single transaction
     * Takes arrays of item IDs, quantities, available quantities, and user ID
     * Returns status and message of the reservation process as an array
     */
    public function processMultipleReservations($item_ids, $quantities, $availableAtTimes, $user_id) {
        $allValid = true;
        $reservationsMade = false;
        
        for($i = 0; $i < count($item_ids); $i++) {
            if($quantities[$i] > 0) {
                if($this->isquantityValid($quantities[$i], $availableAtTimes[$i])) {
                    $this->createReservation($item_ids[$i], $quantities[$i], $user_id);
                    $reservationsMade = true;
                } else {
                    $allValid = false;
                    return ['success' => false, 'message' => 'Not enough items available for one or more selections. Please check quantities.'];
                }
            }
        }
        
        if($allValid && $reservationsMade) {
            return ['success' => true, 'message' => 'Reservations successful!'];
        }
        
        return ['success' => false, 'message' => 'No items were selected for reservation.'];
    }
}