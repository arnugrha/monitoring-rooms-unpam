<?php
  class Home_model {
    private $db;

    public function __construct()
    {
      $this->db = new Database();
    }

    public function getAllBarang($id) {
      $this->db->query(
                        "SELECT 
                              barang.nama_barang, 
                              ruangan_barang.total_barang, 
                              ruangan_barang.kondisi_baik, 
                              ruangan_barang.kondisi_rusak
                        FROM ruangan_barang
                        JOIN barang ON ruangan_barang.id_barang = barang.id_barang
                        WHERE ruangan_barang.kode_ruangan = :id;"
                      );
      $this->db->bind('id', $id);
      return $this->db->resultSet();
    }

    public function getRuanganById($id) {
      $this->db->query("SELECT * FROM ruangan WHERE kode_ruangan = :id");
      $this->db->bind('id', $id);
      return $this->db->single();
    }

    public function getLatestReports($kode_ruangan)
    {
        $this->db->query("
            SELECT 
                l.*, 
                u.nama_lengkap, 
                u.role, 
                b.nama_barang, 
                r.kode_ruangan 
            FROM laporan l
            JOIN user u ON l.id_user = u.id_user
            JOIN barang b ON l.id_barang = b.id_barang
            JOIN ruangan r ON l.kode_ruangan = r.kode_ruangan
            WHERE l.kode_ruangan = :kode_ruangan AND l.delete_at = 1
            ORDER BY l.created_at DESC
            LIMIT 5
        ");
        $this->db->bind(':kode_ruangan', $kode_ruangan);
        return $this->db->resultSet();
    }
  }