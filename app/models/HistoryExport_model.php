<?php
class HistoryExport_model {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllExports() {
        $this->db->query("SELECT * FROM riwayat_export ORDER BY created_at DESC");
        return $this->db->resultSet();
    }

    public function addExport($judul) {
        $query = "INSERT INTO riwayat_export (judul) VALUES (:judul)";
        $this->db->query($query);
        $this->db->bind('judul', $judul);
        $this->db->execute();
        return $this->db->rowCount();
    }
}