<?php
  class Barang_model {
    private $db;

    public function __construct()
    {
      $this->db = new Database();
    }

    public function getAllBarang()
    {
      $this->db->query("SELECT 
                              b.id_barang,
                              b.nama_barang, 
                              b.id_kategori,
                              kb.nama_kategori AS kategori,
                              COALESCE(SUM(rb.kondisi_baik), 0) AS total_baik, 
                              COALESCE(SUM(rb.kondisi_rusak), 0) AS total_rusak, 
                              COALESCE(SUM(rb.total_barang), 0) AS total_keseluruhan
                        FROM barang b
                        LEFT JOIN kategori_barang kb ON b.id_kategori = kb.id_kategori
                        LEFT JOIN ruangan_barang rb ON b.id_barang = rb.id_barang
                        WHERE b.delete_at = 1
                        GROUP BY b.id_barang, b.nama_barang, b.id_kategori, kb.nama_kategori;"
                      );
      return $this->db->resultSet();
    }

    public function getBarangById($id)
    {
      $this->db->query("SELECT * FROM barang WHERE id_barang = :id AND delete_at = 1");
      $this->db->bind('id', $id);
      return $this->db->single();
    }

    public function getBarangByNama($nama)
    {
      $this->db->query("SELECT * FROM barang WHERE nama_barang = :nama AND delete_at = 1");
      $this->db->bind('nama', $nama);
      return $this->db->single();
    }

    public function getTotalBarang()
    {
      $this->db->query("SELECT SUM(total_barang) as total FROM ruangan_barang");
      $result = $this->db->single();
      return $result['total'] ? $result['total'] : 0;
    }

    public function getTotalBaik()
    {
      $this->db->query("SELECT SUM(kondisi_baik) as total FROM ruangan_barang");
      $result = $this->db->single();
      return $result['total'] ? $result['total'] : 0;
    }

    public function getTotalRusak()
    {
      $this->db->query("SELECT SUM(kondisi_rusak) as total FROM ruangan_barang");
      $result = $this->db->single();
      return $result['total'] ? $result['total'] : 0;
    }

    public function tambahDataBarang($data)
    {
      $query = "INSERT INTO barang (nama_barang, id_kategori) VALUES (:nama_barang, :id_kategori)";
      $this->db->query($query);
      $this->db->bind('nama_barang', $data['nama_barang']);
      $this->db->bind('id_kategori', $data['id_kategori']);
      $this->db->execute();
      return 1;
    }

    public function ubahDataBarang($data)
    {
      $query = "UPDATE barang SET nama_barang = :nama_barang, id_kategori = :id_kategori WHERE id_barang = :id_barang";
      $this->db->query($query);
      $this->db->bind('nama_barang', $data['nama_barang']);
      $this->db->bind('id_kategori', $data['id_kategori']);
      $this->db->bind('id_barang', $data['id_barang']);
      $this->db->execute();
      return 1;
    }

    public function hapusDataBarang($id)
    {
      $this->db->query("UPDATE barang SET delete_at = 0 WHERE id_barang = :id");
      $this->db->bind('id', $id);
      $this->db->execute();
      return 1;
    }

    public function getAllKategori()
    {
      $this->db->query("SELECT * FROM kategori_barang ORDER BY nama_kategori ASC");
      return $this->db->resultSet();
    }

    public function tambahKategori($nama)
    {
      $this->db->query("INSERT INTO kategori_barang (nama_kategori) VALUES (:nama)");
      $this->db->bind('nama', $nama);
      $this->db->execute();
      return $this->db->rowCount();
    }

    public function hapusKategori($id)
    {
      $this->db->query("DELETE FROM kategori_barang WHERE id_kategori = :id");
      $this->db->bind('id', $id);
      $this->db->execute();
      return $this->db->rowCount();
    }

    public function ubahKategori($data)
    {
      $this->db->query("UPDATE kategori_barang SET nama_kategori = :nama WHERE id_kategori = :id");
      $this->db->bind('nama', $data['nama_kategori']);
      $this->db->bind('id', $data['id_kategori']);
      $this->db->execute();
      return $this->db->rowCount();
    }

    public function getBarangByKategori($nama_kategori)
    {
      $this->db->query("SELECT b.* FROM barang b 
                        JOIN kategori_barang kb ON b.id_kategori = kb.id_kategori 
                        WHERE kb.nama_kategori = :nama AND b.delete_at = 1");
      $this->db->bind('nama', $nama_kategori);
      return $this->db->resultSet();
    }
  }