class ReserveItemManager extends Database {
    private $sessionManager;

    public function __construct($connection, SessionManager $sessionManager) {
        parent::__construct($connection);
        $this->sessionManager = $sessionManager;
    }

    public function handleReservationForm() {
        if (isset($_POST['submit'])) {
            $_SESSION['scheduled_reserve_datetime'] = $_POST['scheduled_reserve_datetime'];
            $_SESSION['scheduled_return_datetime'] = $_POST['scheduled_return_datetime'];
        }

        $this->displayReservationForm();
        
        if (isset($_SESSION['scheduled_reserve_datetime'])) {
            $this->displayAvailableItems();
        }
    }

    private function displayReservationForm() {
        echo '<div class="container">
            <form action="reserve_item.php" method="post">
                <p>Please submit first the date and time you want to borrow and return the item to show the list of items available at that time</p>
                <label>Reserve Time:</label>
                <input type="datetime-local" name="scheduled_reserve_datetime" value="' . 
                ($_SESSION['scheduled_reserve_datetime'] ?? '') . '" required>
                <label>Return Time:</label>
                <input type="datetime-local" name="scheduled_return_datetime" value="' . 
                ($_SESSION['scheduled_return_datetime'] ?? '') . '" required>
                <input type="submit" name="submit" value="Submit">
            </form>';
    }

    private function displayAvailableItems() {
        echo '<table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved</th>
                <th>Available</th>
                <th>Action</th>
            </tr>';

        $items = $this->getAvailableItems();
        while ($row = $items->fetch_assoc()) {
            echo $this->renderItemRow($row);
        }
        echo '</table></div>';
    }

    private function getAvailableItems() {
        return $this->retrieve(
            'items.*, active_status.active_stat',
            'items JOIN active_status ON items.active_status_ID = active_status.active_status_ID',
            "active_status.active_stat='active'",
            'items.item_name'
        );
    }

    private function renderItemRow($row) {
        $availableAtTime = $this->calculateAvailableQuantity($row);
        
        return "<tr class='row-border'>
            <td>{$row['item_name']}</td>
            <td>{$row['item_quantity']}</td>
            <td>{$row['item_quantity_reserved']}</td>
            <td>$availableAtTime</td>
            <td>
                <form action='reserve_item.php' method='post'>
                    <input type='hidden' name='item_id' value='{$row['item_id']}'>
                    <input type='hidden' name='scheduled_reserve_datetime' value='{$_SESSION['scheduled_reserve_datetime']}'>
                    <input type='hidden' name='scheduled_return_datetime' value='{$_SESSION['scheduled_return_datetime']}'>
                    <input type='hidden' name='availableAtTime' value='$availableAtTime'>
                    <input type='number' name='quantity' min='1' required>
                    <input type='submit' name='reserve' value='Reserve'>
                </form>
            </td>
        </tr>";
    }

    private function calculateAvailableQuantity($item) {
        $reservedAtTime = $this->getReservedQuantityAtTime(
            $item['item_id'],
            $_SESSION['scheduled_reserve_datetime'],
            $_SESSION['scheduled_return_datetime']
        );
        return $item['item_quantity'] - $reservedAtTime;
    }

    private function getReservedQuantityAtTime($itemId, $startTime, $endTime) {
        $result = $this->retrieve(
            'SUM(quantity_reserved) as total_reserved',
            'reservations',
            "item_id = '$itemId' 
            AND reservation_status_ID = 1
            AND (
                (scheduled_reserve_datetime BETWEEN '$startTime' AND '$endTime')
                OR (scheduled_return_datetime BETWEEN '$startTime' AND '$endTime')
                OR ('$startTime' BETWEEN scheduled_reserve_datetime AND scheduled_return_datetime)
            )"
        )->fetch_assoc();
        
        return $result['total_reserved'] ?? 0;
    }
}
