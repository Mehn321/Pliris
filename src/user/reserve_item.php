<?php 
class ReserveItemManager extends Database {
    private $available_quantity;
    
    public function __construct(SessionManager $sessionManager) {
        parent::__construct();
        $this->sessionManager = $sessionManager;
    }
    
    public function handleDateTimeSubmission() {
        if (isset($_POST['submit'])) {
            $_SESSION['scheduled_reserve_datetime'] = $_POST['scheduled_reserve_datetime'];
            $_SESSION['scheduled_return_datetime'] = $_POST['scheduled_return_datetime'];
            return true;
        }
        return false;
    }
    
    
    public function getAvailableItems() {
        return $this->retrieve(
            'items.*, active_status.active_stat',
            'items JOIN active_status ON items.active_status_ID = active_status.active_status_ID',
            "active_status.active_stat='active'",
            'items.item_name'
        );
    }
    
    public function calculateAvailableQuantity($item_id,$quantity) {
        $reservedAtTime = $this->getReservedQuantityAtTime($item_id);
        $this->available_quantity = $quantity - $reservedAtTime;
        if($this->available_quantity < 0){
            $this->available_quantity = 0;
        }
        return $this->available_quantity;
    }
    
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
            // OR
            // (scheduled_reserve_datetime >= '$startTime' AND scheduled_return_datetime <= '$endTime') OR
            // (scheduled_reserve_datetime <= '$startTime' AND scheduled_return_datetime >= '$endTime')
            if(isset($result['total_reserved'])){
                return $result['total_reserved'];
            }else{
                return 0;
            }
        }
        
        public function createReservation($item_id, $quantity, $user_id) {
            $columns = 'id_number, item_id, quantity_reserved, scheduled_reserve_datetime, scheduled_return_datetime, reservation_status_ID';
            $values = "'$user_id', 
                '$item_id', 
                '$quantity', 
                '{$_SESSION['scheduled_reserve_datetime']}', 
                '{$_SESSION['scheduled_return_datetime']}',
                1";
            
            $this->insert('reservations', $columns, $values);
            
            $this->update("items","item_quantity_reserved='$quantity'", "item_id = '$item_id'");
            return true;
        }
    
    public function isquantityValid($quantity, $availableAtTime){
        if ($quantity > $availableAtTime) {
            return false;
        }else {
            return true;
        }
    }

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


