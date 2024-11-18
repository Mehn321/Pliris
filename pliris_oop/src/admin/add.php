<?php

class AddItemManager extends Database {
    private $table = 'items';

    public function handleAddItem() {
        if (isset($_POST['submit'])) {
            $this->addNewItem($_POST);
        }
    }

    public function displayAddForm() {
        include("header.php");

        text_head("Add Items");

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add Item</title>
            <link rel="stylesheet" href="../css/add.css">
        </head>

        <body>
            <?php
            echo '<div class="container">
                <form action="add.php" method="post">
                    <label>Item Name:</label>
                    <input type="text" name="item_name" required>
                    <label>Quantity:</label>
                    <input type="number" name="item_quantity" required>
                    <input type="submit" name="submit" value="Add Item">
                </form>
                <table>
                    <tr class="row-border">
                        <th>Item Name</th>
                        <th>Quantity</th>
                    </tr>';

            $this->displayExistingItems();
            echo '</table></div>';
            ?>
        </body>

        </html>

        <?php
    }

    public function addNewItem($data) {
        $itemname = $data['item_name'];
        $quantity = $data['item_quantity'];
        
        $columns = 'item_name, item_quantity, item_quantity_reserved, active_status_ID';
        $values = "'$itemname', '$quantity', 0, 1";
        
        $this->insert($this->table, $columns, $values);
    }

    private function displayExistingItems() {
        $items = $this->retrieve('item_name, item_quantity', $this->table, '1=1', 'item_name');
        while ($row = $items->fetch_assoc()) {
            echo "<tr class='row-border'>
                <td>{$row['item_name']}</td>
                <td>{$row['item_quantity']}</td>
            </tr>";
        }
    }
}