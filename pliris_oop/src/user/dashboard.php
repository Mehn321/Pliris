<?php

class UserDashboard extends Database {
    private $table = 'reservations';
    private $id_number;
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
        session_start();
    }

    public function displayPage() {
        include("header.php");
        $sql = "SELECT first_name FROM accounts WHERE id_number='$this->id_number'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        
        text_head("Welcome $first_name", $this->id_number);
        $this->displayDashboard();
    }

    public function displayDashboard() {
        echo '<div class="box">
            <ul>';
        
        $this->displayDashboardItems();
        echo '</ul></div>';
    }

    private function displayDashboardItems() {
        $stats = $this->getDashboardStats();
        
        echo "<a href='reserve_item.php' class='red'>
                <li><img src='../images/allitems.png' alt=''><br>Reserve Items</li>
            </a>
            <a href='reserved_items.php' class='blue'>
                <li><img src='../images/borrow.png' alt=''><br>Reserved items: {$stats['reserved']}</li>
            </a>
            <a href='returned_items.php' class='green'>
                <li><img src='../images/return.png' alt=''><br>Returned Items: {$stats['returned']}</li>
            </a>";
    }

    private function getDashboardStats() {
        $userId = $this->id_number;
        $reserved = $this->count($this->table, "id_number = '$userId' AND reservation_status_ID = 1");
        $returned = $this->count($this->table, "id_number = '$userId' AND reservation_status_ID = 3");
        
        return [
            'reserved' => $reserved,
            'returned' => $returned
        ];
    }
}