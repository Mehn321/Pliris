class UserReturnedItemsManager extends Database {
    private $sessionManager;

    public function __construct($connection, SessionManager $sessionManager) {
        parent::__construct($connection);
        $this->sessionManager = $sessionManager;
    }

    public function displayReturnedItems() {
        echo '<div class="container">
            <table>
                <tr class="row-border">
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Reserved Schedule</th>
                    <th>Return Schedule</th>
                    <th>Returned Time</th>
                    <th>Status</th>
                </tr>';

        $returns = $this->getUserReturns();
        while ($row = $returns->fetch_assoc()) {
            echo $this->renderReturnRow($row);
        }
        echo '</table></div>';
    }

    private function getUserReturns() {
        $userId = $this->sessionManager->getUserId_number();
        return $this->retrieve(
            'reservations.*, items.item_name, reservation_status.reservation_stat',
            'reservations 
            JOIN items ON reservations.item_id = items.item_id 
            JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID',
            "reservations.id_number = '$userId' 
            AND (reservation_status.reservation_stat = 'returned' 
            OR reservation_status.reservation_stat = 'approved' 
            OR reservation_status.reservation_stat = 'disapproved')",
            'reservations.returned_datetime DESC'
        );
    }

    private function renderReturnRow($row) {
        $reserve_datetime = new DateTime($row['scheduled_reserve_datetime']);
        $return_datetime = new DateTime($row['scheduled_return_datetime']);
        $returned_datetime = new DateTime($row['returned_datetime']);
        
        return "<tr class='row-border'>
            <td>{$row['item_name']}</td>
            <td>{$row['quantity_reserved']}</td>
            <td>{$reserve_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>{$return_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>{$returned_datetime->format('M-d-Y h:i:s:a')}</td>
            <td>{$row['reservation_stat']}</td>
        </tr>";
    }
}
