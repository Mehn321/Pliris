<?php

class Dashboard {
    private $id_number;
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
        session_start();
        $this->id_number=$_SESSION['id_number'];
        if (!isset($_SESSION['id_number'])) {
            header("Location: ../index.php");
            exit;
        }
        if(isset($_POST['logout'])) {
            unset($_SESSION['id_number']);
            header("Location: ../index.php");
            exit;
        }
    }

    public function displayPage() {
        include("header.php");
        $sql="SELECT first_name FROM accounts WHERE id_number='$this->id_number'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        
        text_head("Welcome $first_name", $this->id_number);
        ?>
        <div class="box">
            <ul>
                <?php
                    $reservations = "SELECT COUNT(reservations.reservation_status_ID) as borrowed_itemsquantity
                    FROM reservations INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
                    WHERE id_number='$this->id_number' AND reservation_stat='reserving'";
                    $result = $this->conn->query($reservations);
                    $row = $result->fetch_assoc();
                    $borrowed_itemsquantity = $row['borrowed_itemsquantity'];
                echo"
                <a href='reserve_item.php' class='red'><li><img src='../images/allitems.png' alt=''>Reserve item</li></a>
                <a href='reserved_items.php' class='blue'><li><img src='../images/borrow.png' alt=''>Reserved items: $borrowed_itemsquantity </li></a>
                ";
                ?>
            </ul>
        </div>
        <?php
    }
}