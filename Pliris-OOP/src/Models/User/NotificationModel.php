<?php


class NotificationModel {
    private $db;
    private $id_number;

    public function __construct($database, $id_number) {
        $this->db = $database;
        $this->id_number = $id_number;
    }

    public function getTotalNotifications() {
        $query = "SELECT COUNT(*) as count FROM notifications WHERE id_number = '$this->id_number' AND is_read = 0";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function getNotifications() {
        $query = "SELECT * FROM notifications WHERE id_number = '$this->id_number' ORDER BY created_at DESC";
        return $this->db->query($query);
    }

    public function addNotification($message) {
        $query = "INSERT INTO notifications (id_number, message, is_read, created_at) 
                VALUES ('$this->id_number', '$message', 0, NOW())";
        return $this->db->query($query);
    }

    public function markAsRead($notification_id) {
        $query = "UPDATE notifications SET is_read = 1 WHERE id_number = '$this->id_number' AND notification_id = '$notification_id'";
        return $this->db->query($query);
    }
}
