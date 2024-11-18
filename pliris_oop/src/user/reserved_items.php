class UserReservedItemsManager extends Database {
    private $sessionManager;

    public function __construct($connection, SessionManager $sessionManager) {
        parent::__construct($connection);
        $this->sessionManager = $sessionManager;
    }

    public function displayReservedItems() {
        echo '<div class="container">
            <table>
                <tr class="row-border">
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Reserved Schedule</th>
                    <th>Return Schedule</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>';

        $reservations = $this->getUserReservations();
        while ($row = $reservations->fetch_assoc()) {
            echo $this->renderReservationRow($row);
        }
        echo '</table></div>';
    }

    private function getUserReservations() {
        $userId = $this->sessionManager->getUserId();
        return $this->retrieve(
            'reservations.*, items.item_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservations.id_number = '$userId' 
            AND (reservation_status.reservation_stat = 'reserving' 
            OR reservation_status.reservation_stat = 'disapproved')",
            'reservations.scheduled_reserve_datetime DESC'
        );
    }

    private function renderReservationRow($row) {
        $reserve_datetime = new DateTime($row['scheduled_reserve_datetime']);
        $return_datetime = new DateTime($row['scheduled_return_datetime']);
        
        return "<tr class='row-border'>
            <td>{$row['item_name']}</td>
            <td>{$row['quantity_reserved']}</td>
            <td>{$reserve_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>{$return_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>{$row['reservation_stat']}</td>
            <td>
                <form action='reserved_items.php' method='post'>
                    <input type='hidden' name='reserve_id' value='{$row['reserve_id']}'>
                    <input type='submit' name='submit' value='return'>
                </form>
            </td>
        </tr>";
    }
}
