<?php
  class Container_model {
    private $db;
    private $table = "container";

    public function __construct()
    {
      $this->db = new Database();
    }

    public function getAllContainer()
    {
      $this->db->query("SELECT 
                              c.*, 
                              r.nama_ruangan,
                              b.nama_barang AS nama_container
                        FROM " . $this->table . " c
                        JOIN barang b ON c.id_barang = b.id_barang
                        JOIN ruangan r ON c.kode_ruangan = r.kode_ruangan"
                      );
      return $this->db->resultSet();
    }

    public function getContainerDetailById($id)
    {
      $this->db->query("SELECT 
                              c.*, 
                              r.nama_ruangan,
                              b.nama_barang AS nama_container
                        FROM " . $this->table . " c
                        JOIN barang b ON c.id_barang = b.id_barang
                        JOIN ruangan r ON c.kode_ruangan = r.kode_ruangan
                        WHERE c.id_container = :id"
                      );
      $this->db->bind('id', $id);
      return $this->db->single();
    }

    public function getContainerById($id)
    {
      $this->db->query("SELECT * FROM " . $this->table . " WHERE id_container = :id");
      $this->db->bind('id', $id);
      return $this->db->single();
    }

    public function ubahDataContainer($data)
    {
        // 1. Ambil data lama sebelum diubah
        $oldData = $this->getContainerById($data['id_container']);
        if (!$oldData) return 0;

        // 2. Update data di tabel container
        $query = "UPDATE " . $this->table . " SET 
                  kode_ruangan = :kode_ruangan,
                  id_barang = :id_barang
                  WHERE id_container = :id_container";
        $this->db->query($query);
        $this->db->bind('kode_ruangan', $data['kode_ruangan']);
        $this->db->bind('id_barang', $data['id_barang']);
        $this->db->bind('id_container', $data['id_container']);
        $this->db->execute();

        $old_kode = $oldData['kode_ruangan'];
        $old_barang = $oldData['id_barang'];
        $new_kode = $data['kode_ruangan'];
        $new_barang = $data['id_barang'];

        // 3. SINKRONISASI KE MONITORING RUANGAN
        // Jika ada perubahan lokasi atau jenis barang
        if ($old_kode != $new_kode || $old_barang != $new_barang) {
            
            // A. Kurangi/Hapus dari Ruangan LAMA
            $this->db->query("UPDATE ruangan_barang SET total_barang = total_barang - 1, kondisi_baik = GREATEST(0, kondisi_baik - 1) 
                              WHERE kode_ruangan = :kode AND id_barang = :id_barang AND status_pengajuan = 'disetujui'");
            $this->db->bind('kode', $old_kode);
            $this->db->bind('id_barang', $old_barang);
            $this->db->execute();
            
            // Bersihkan jika jumlah jadi 0
            $this->db->query("DELETE FROM ruangan_barang WHERE kode_ruangan = :kode AND id_barang = :id_barang AND total_barang <= 0");
            $this->db->bind('kode', $old_kode);
            $this->db->bind('id_barang', $old_barang);
            $this->db->execute();

            // B. Tambah ke Ruangan BARU
            $this->db->query("SELECT id_ruangan_barang FROM ruangan_barang WHERE kode_ruangan = :kode AND id_barang = :id_barang AND status_pengajuan = 'disetujui'");
            $this->db->bind('kode', $new_kode);
            $this->db->bind('id_barang', $new_barang);
            $existing = $this->db->single();

            if ($existing) {
                $this->db->query("UPDATE ruangan_barang SET total_barang = total_barang + 1, kondisi_baik = kondisi_baik + 1 WHERE id_ruangan_barang = :id");
                $this->db->bind('id', $existing['id_ruangan_barang']);
            } else {
                $this->db->query("INSERT INTO ruangan_barang (kode_ruangan, id_barang, total_barang, kondisi_baik, kondisi_rusak, id_user, status_pengajuan) 
                                  VALUES (:kode, :id_barang, 1, 1, 0, :id_user, 'disetujui')");
                $this->db->bind('kode', $new_kode);
                $this->db->bind('id_barang', $new_barang);
                $this->db->bind('id_user', $data['id_user']);
            }
            $this->db->execute();
        }

        // 4. Update QR Data
        $this->updateQrData($data['id_container']);
        
        return 1;
    }

    public function updateQrData($id)
    {
        $url = BASEURL . "home/container/" . $id;
        $this->db->query("UPDATE " . $this->table . " SET qr_data = :qr WHERE id_container = :id");
        $this->db->bind('qr', $url);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    public function tambahDataContainer($data)
    {
      $query = "INSERT INTO " . $this->table . " (kode_ruangan, id_barang, id_user, qr_data) 
                VALUES (:kode_ruangan, :id_barang, :id_user, '')";
      $this->db->query($query);
      $this->db->bind('kode_ruangan', $data['kode_ruangan']);
      $this->db->bind('id_barang', $data['id_barang']);
      $this->db->bind('id_user', $data['id_user']);
      $this->db->execute();
      
      $lastId = $this->db->lastInsertId();
      
      // Update QR Data
      $this->updateQrData($lastId);

      // SYNC TO Monitoring (ruangan_barang)
      $this->db->query("SELECT id_ruangan_barang FROM ruangan_barang WHERE kode_ruangan = :kode AND id_barang = :id_barang AND status_pengajuan = 'disetujui'");
      $this->db->bind('kode', $data['kode_ruangan']);
      $this->db->bind('id_barang', $data['id_barang']);
      $existing = $this->db->single();

      if ($existing) {
          $this->db->query("UPDATE ruangan_barang SET total_barang = total_barang + 1, kondisi_baik = kondisi_baik + 1 WHERE id_ruangan_barang = :id");
          $this->db->bind('id', $existing['id_ruangan_barang']);
      } else {
          $this->db->query("INSERT INTO ruangan_barang (kode_ruangan, id_barang, total_barang, kondisi_baik, kondisi_rusak, id_user, status_pengajuan) 
                            VALUES (:kode, :id_barang, 1, 1, 0, :id_user, 'disetujui')");
          $this->db->bind('kode', $data['kode_ruangan']);
          $this->db->bind('id_barang', $data['id_barang']);
          $this->db->bind('id_user', $data['id_user']);
      }
      $this->db->execute();

      return $lastId;
    }
  
    public function hapusDataContainer($id)
    {
      // Ambil data container sebelum dihapus untuk sinkronisasi
      $container = $this->getContainerById($id);
      
      $this->db->query("DELETE FROM " . $this->table . " WHERE id_container = :id");
      $this->db->bind('id', $id);
      $this->db->execute();
      $rowCount = $this->db->rowCount();

      if ($rowCount > 0 && $container) {
          // SYNC TO Monitoring (Kurangi jumlah barang di ruangan)
          $this->db->query("UPDATE ruangan_barang SET total_barang = total_barang - 1, kondisi_baik = GREATEST(0, kondisi_baik - 1) 
                            WHERE kode_ruangan = :kode AND id_barang = :id_barang AND status_pengajuan = 'disetujui'");
          $this->db->bind('kode', $container['kode_ruangan']);
          $this->db->bind('id_barang', $container['id_barang']);
          $this->db->execute();
          
          // Hapus entitas di ruangan_barang jika totalnya jadi 0
          $this->db->query("DELETE FROM ruangan_barang WHERE kode_ruangan = :kode AND id_barang = :id_barang AND total_barang <= 0");
          $this->db->bind('kode', $container['kode_ruangan']);
          $this->db->bind('id_barang', $container['id_barang']);
          $this->db->execute();
      }

      return $rowCount;
    }
  }
