<?php
class BarangContainer_model {
    private $table = 'container_barang';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllContainerWithItems()
    {
        // Menampilkan container yang setidaknya memiliki satu jenis barang di dalamnya
        $query = "SELECT 
                    c.id_container,
                    c.kode_ruangan,
                    b_master.nama_barang AS nama_container,
                    r.nama_ruangan,
                    SUM(cb.kondisi_baik) AS total_baik,
                    SUM(cb.kondisi_rusak) AS total_rusak,
                    SUM(cb.kondisi_baik + cb.kondisi_rusak) AS jumlah_items
                  FROM container c
                  JOIN barang b_master ON c.id_barang = b_master.id_barang
                  JOIN ruangan r ON c.kode_ruangan = r.kode_ruangan
                  JOIN container_barang cb ON c.id_container = cb.id_container
                  GROUP BY c.id_container";
        
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getItemsByContainer($id_container)
    {
        $query = "SELECT 
                    cb.*,
                    b.nama_barang
                  FROM container_barang cb
                  JOIN barang b ON cb.id_barang = b.id_barang
                  WHERE cb.id_container = :id_container";
        
        $this->db->query($query);
        $this->db->bind('id_container', $id_container);
        return $this->db->resultSet();
    }
    public function tambahData($data)
    {
        $id_container = $data['id_container'];
        $items = $data['id_barang'];
        $totals = $data['total_barang'];

        $count = 0;
        foreach ($items as $index => $id_barang) {
            if (empty($id_barang)) continue;

            $baik = (int)$totals[$index];
            $rusak = 0; // Default 0 saat tambah baru

            // Cek apakah barang sudah ada di container ini
            $this->db->query("SELECT id_container_barang FROM container_barang WHERE id_container = :id_container AND id_barang = :id_barang");
            $this->db->bind('id_container', $id_container);
            $this->db->bind('id_barang', $id_barang);
            $existing = $this->db->single();

            if ($existing) {
                // Update jumlah jika sudah ada
                $query = "UPDATE container_barang 
                          SET kondisi_baik = kondisi_baik + :baik,
                              kondisi_rusak = kondisi_rusak + :rusak
                          WHERE id_container_barang = :id";
                $this->db->query($query);
                $this->db->bind('baik', $baik);
                $this->db->bind('rusak', $rusak);
                $this->db->bind('id', $existing['id_container_barang']);
            } else {
                // Insert baru
                $query = "INSERT INTO container_barang (id_container, id_barang, kondisi_baik, kondisi_rusak) 
                          VALUES (:id_container, :id_barang, :baik, :rusak)";
                $this->db->query($query);
                $this->db->bind('id_container', $id_container);
                $this->db->bind('id_barang', $id_barang);
                $this->db->bind('baik', $baik);
                $this->db->bind('rusak', $rusak);
            }
            $this->db->execute();
            $count++;
        }

        return $count;
    }

    public function ubahData($data)
    {
        $id_container = $data['id_container'];
        $items = $data['id_barang'];
        $totals = $data['total_barang'];

        // Ambil barang yang saat ini ada di container untuk perbandingan
        $this->db->query("SELECT id_barang FROM container_barang WHERE id_container = :id_container");
        $this->db->bind('id_container', $id_container);
        $currentItems = $this->db->resultSet();
        $processedIds = [];

        $count = 0;
        foreach ($items as $index => $id_barang) {
            if (empty($id_barang)) continue;
            
            $processedIds[] = $id_barang;
            $total = (int)$totals[$index];

            // Cek apakah barang sudah ada di container ini
            $this->db->query("SELECT id_container_barang FROM container_barang WHERE id_container = :id_container AND id_barang = :id_barang");
            $this->db->bind('id_container', $id_container);
            $this->db->bind('id_barang', $id_barang);
            $existing = $this->db->single();

            if ($total <= 0) {
                if ($existing) {
                    $this->db->query("DELETE FROM container_barang WHERE id_container_barang = :id");
                    $this->db->bind('id', $existing['id_container_barang']);
                    $this->db->execute();
                }
                continue;
            }

            if ($existing) {
                // Update (Set total baru, asumsikan kondisi baik semua jika lewat form simpel)
                $query = "UPDATE container_barang 
                          SET kondisi_baik = :total,
                              kondisi_rusak = 0
                          WHERE id_container_barang = :id";
                $this->db->query($query);
                $this->db->bind('total', $total);
                $this->db->bind('id', $existing['id_container_barang']);
            } else {
                // Insert baru
                $query = "INSERT INTO container_barang (id_container, id_barang, kondisi_baik, kondisi_rusak) 
                          VALUES (:id_container, :id_barang, :baik, 0)";
                $this->db->query($query);
                $this->db->bind('id_container', $id_container);
                $this->db->bind('id_barang', $id_barang);
                $this->db->bind('baik', $total);
            }
            $this->db->execute();
            $count++;
        }

        // Hapus barang yang tidak ada lagi di list (Removed from form)
        foreach ($currentItems as $oldItem) {
            if (!in_array($oldItem['id_barang'], $processedIds)) {
                $this->db->query("DELETE FROM container_barang WHERE id_container = :id_container AND id_barang = :id_barang");
                $this->db->bind('id_container', $id_container);
                $this->db->bind('id_barang', $oldItem['id_barang']);
                $this->db->execute();
            }
        }

        return $count;
    }
    public function hapusData($id_container)
    {
        $this->db->query("DELETE FROM container_barang WHERE id_container = :id_container");
        $this->db->bind('id_container', $id_container);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
