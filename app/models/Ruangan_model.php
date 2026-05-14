<?php
  class Ruangan_model {
    private $db;
    private $table = "ruangan";

    public function __construct()
    {
      $this->db = new Database();
    }

public function getAllRuangan() {
    $this->db->query("SELECT * FROM " . $this->table . " WHERE delete_at = 1");
    return $this->db->resultSet();
}


    public function getTotalRuangan()
    {
        $this->db->query("SELECT COUNT(kode_ruangan) AS total 
            FROM ruangan WHERE delete_at = 1
        ");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    public function getTotalAktif()
    {
        $this->db->query("SELECT COUNT(*) as total FROM ruangan WHERE status_ruangan = 'aktif' AND delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }

    public function getTotalProsesPerbaikan()
    {
        $this->db->query("SELECT COUNT(*) as total FROM ruangan WHERE status_ruangan = 'maintance' AND delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }

    public function getTotalKetuaKelas()
    {
        $this->db->query("SELECT COUNT(id_user) AS total 
            FROM user 
            WHERE role = 'Ketua kelas'
            AND (delete_at = 1 OR delete_at IS NULL)
        ");
        $result = $this->db->single();
        return $result['total'] ?? 0;
    }

    public function getRuanganById($id)
    {
        
        $this->db->query(" SELECT 
                r.kode_ruangan,
                r.nama_ruangan,
                r.kode_ruangan,
                r.lokasi,
                r.qr_data,
                r.status_ruangan,
                COALESCE(SUM(rb.total_barang), 0) AS total_barang,
                COALESCE(SUM(rb.kondisi_baik), 0) AS kondisi_baik,
                COALESCE(SUM(rb.kondisi_rusak), 0) AS kondisi_rusak
            FROM ruangan r
            LEFT JOIN ruangan_barang rb ON r.kode_ruangan = rb.kode_ruangan
            WHERE r.kode_ruangan = :id
            GROUP BY 
                r.kode_ruangan,
                r.nama_ruangan,
                r.kode_ruangan,
                r.lokasi,
                r.qr_data,
                r.status_ruangan
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


  public function tambahRuangan($data)
    {
        $kode_ruangan = $data['kode_ruangan'];
        
        // 1. Insert awal tanpa qr_data terlebih dahulu
        $this->db->query("INSERT INTO ruangan (nama_ruangan, kode_ruangan, lokasi, qr_data)
            VALUES (:nama_ruangan, :kode_ruangan, :lokasi, '')
        ");
        $this->db->bind(':nama_ruangan', $data['nama_ruangan']);
        $this->db->bind(':kode_ruangan', $kode_ruangan);
        $this->db->bind(':lokasi',       $data['lokasi']);
        
        if ($this->db->execute()) {
            // 2. Buat URL QR Data menggunakan kode_ruangan
            $qr_data = BASEURL . 'home/index/' . $kode_ruangan;
            
            // 3. Update field qr_data
            $this->db->query("UPDATE ruangan SET qr_data = :qr_data WHERE kode_ruangan = :kode_ruangan");
            $this->db->bind(':qr_data', $qr_data);
            $this->db->bind(':kode_ruangan', $kode_ruangan);
            return $this->db->execute();
        }
        
        return false;
    }


    // Update ruangan
    public function updateRuangan($data)
    {
        // Generate URL QR Data menggunakan kode_ruangan yang baru
        $qr_data = BASEURL . 'home/index/' . $data['kode_ruangan'];

        $this->db->query("UPDATE ruangan 
            SET nama_ruangan = :nama_ruangan,
                kode_ruangan = :kode_ruangan,
                lokasi       = :lokasi,
                qr_data      = :qr_data,
                status_ruangan      = :status_ruangan
            WHERE kode_ruangan = :kode_lama
        ");
        $this->db->bind(':nama_ruangan', $data['nama_ruangan']);
        $this->db->bind(':kode_ruangan', $data['kode_ruangan']);
        $this->db->bind(':lokasi',       $data['lokasi']);
        $this->db->bind(':qr_data',      $qr_data);
        $this->db->bind(':status_ruangan', $data['status_ruangan']);
        $this->db->bind(':kode_lama', $data['kode_lama']);
        return $this->db->execute();
    }

    // Hapus ruangan (Soft Delete)
    public function deleteRuangan($id)
    {
        $this->db->query("UPDATE ruangan 
            SET delete_at = 0
            WHERE kode_ruangan = :id
        ");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getRuanganByKode($kode)
    {
      $this->db->query("SELECT * FROM " . $this->table . " WHERE kode_ruangan = :kode");
      $this->db->bind('kode', $kode);
      return $this->db->single();
    }

    public function restoreRuangan($data)
    {
        $qr_data = BASEURL . 'home/index/' . $data['kode_ruangan'];
        $this->db->query("UPDATE ruangan 
            SET nama_ruangan = :nama_ruangan,
                lokasi       = :lokasi,
                qr_data      = :qr_data,
                status_ruangan = 'aktif',
                delete_at    = 1
            WHERE kode_ruangan = :kode_ruangan
        ");
        $this->db->bind(':nama_ruangan', $data['nama_ruangan']);
        $this->db->bind(':lokasi',       $data['lokasi']);
        $this->db->bind(':qr_data',      $qr_data);
        $this->db->bind(':kode_ruangan', $data['kode_ruangan']);
        return $this->db->execute();
    }
    // public function getRuanganById($id)
    // {
    //   $this->db->query("SELECT * FROM " . $this->table . " WHERE kode_ruangan = :id");
    //   $this->db->bind('id', $id);
    //   return $this->db->single();
    // }
  }
