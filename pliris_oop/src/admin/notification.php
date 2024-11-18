<?php
    class NotificationManager extends Database {
        private $lowStockThreshold;

        public function getlowStockThreshold($lowStockThreshold) {
            $this->lowStockThreshold=$lowStockThreshold;
        }

        public function displayNotifications() {
            $items = $this->getLowStockItems();
        
            echo '<div class="container">
                <table>
                    <tr class="row-border">
                        <th>Item Name</th>
                        <th>Quantity</th>
                    </tr>';
        
            $this->renderNotificationRows($items);
            echo '</table></div>';
        }

        private function getLowStockItems() {
            return $this->retrieve(
                'item_name, item_quantity', 
                'items', 
                "item_quantity <= {$this->lowStockThreshold}", 
                'item_name'
            );
        }

        private function renderNotificationRows($items) {
            while ($row = $items->fetch_assoc()) {
                echo $this->renderNotificationRow($row);
            }
        }

        private function renderNotificationRow($row) {
            return "<tr class='row-border'>
                <td>{$row['item_name']}</td>
                <td>{$row['item_quantity']}</td>
            </tr>";
        }

        public function getlowstockNotificationCount() {
            return $this->count('items', "item_quantity <= {$this->lowStockThreshold}");
        }
    
        public function getNotseenNotificationsCount() {
            return $this->count('notifications', "notification_status_id = 2");
        }

        public function getNotifications() {
            $sql = "SELECT 
                a.first_name,
                i.item_name,
                r.quantity_reserved,
                r.scheduled_return_datetime,
                rs.reservation_stat
            FROM reservations r
            JOIN accounts a ON r.id_number = a.id_number
            JOIN items i ON r.item_id = i.item_id
            JOIN reservation_status rs ON r.reservation_status_ID = rs.reservation_status_ID
            WHERE r.reservation_status_ID = 2
            ORDER BY r.scheduled_return_datetime DESC";
        
            return $this->conn->query($sql);
        }

}