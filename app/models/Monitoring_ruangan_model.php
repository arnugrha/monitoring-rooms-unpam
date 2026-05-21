<?php
  class Monitoring_ruangan_model {
    private $db;

    public function __construct()
    {
      $this->db = new Database();
    }

    public function getAllRuangan($filterStatus = null)
    {
      $query = "SELECT 
                r.kode_ruangan,
                r.nama_ruangan,
                SUM(IFNULL(rb.total_barang, 0)) AS total_barang,
                SUM(IFNULL(rb.kondisi_baik, 0)) AS total_baik,
                SUM(IFNULL(rb.kondisi_rusak, 0)) AS total_rusak
              FROM ruangan r
              LEFT JOIN ruangan_barang rb ON r.kode_ruangan = rb.kode_ruangan
              WHERE r.delete_at = 1 AND (rb.status_pengajuan = 'disetujui' OR rb.id_ruangan_barang IS NULL)";
      
      if ($filterStatus == 'rusak') {
          $query .= " GROUP BY r.kode_ruangan HAVING SUM(IFNULL(rb.kondisi_rusak, 0)) > 0";
      } else {
          $query .= " GROUP BY r.kode_ruangan HAVING SUM(IFNULL(rb.total_barang, 0)) > 0";
      }
              
      $this->db->query($query);
      return $this->db->resultSet();
    }

    public function tambahDataBarangRuangan($data)
    {
        $kode_ruangan = $data['kode_ruangan'];
        $items = $data['id_barang'];
        $totals = $data['total_barang'];

        $count = 0;
        $id_user = Session::user()['id_user'];
        foreach ($items as $index => $id_barang) {
            if (empty($id_barang) || empty($totals[$index])) continue;

            $qty = (int)$totals[$index];

            // Cek apakah barang yang SUDAH DISETUJUI sudah ada di ruangan tersebut
            $this->db->query("SELECT id_ruangan_barang FROM ruangan_barang WHERE TRIM(kode_ruangan) = TRIM(:kode_ruangan) AND id_barang = :id_barang AND status_pengajuan = 'disetujui'");
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->bind('id_barang', $id_barang);
            $existing = $this->db->single();

            if ($existing) {
                // Jika sudah ada yang disetujui, update saja
                $query = "UPDATE ruangan_barang 
                          SET total_barang = total_barang + :qty,
                              kondisi_baik = kondisi_baik + :qty,
                              id_user = :id_user
                          WHERE id_ruangan_barang = :id_ruangan_barang";
                $this->db->query($query);
                $this->db->bind('qty', $qty);
                $this->db->bind('id_user', $id_user);
                $this->db->bind('id_ruangan_barang', $existing['id_ruangan_barang']);
            } else {
                // Jika belum ada yang disetujui, insert baru dengan status disetujui
                $query = "INSERT INTO ruangan_barang (kode_ruangan, id_barang, total_barang, kondisi_baik, kondisi_rusak, status_pengajuan, id_user) 
                          VALUES (:kode_ruangan, :id_barang, :qty, :qty, 0, 'disetujui', :id_user)";
                $this->db->query($query);
                $this->db->bind('kode_ruangan', trim($kode_ruangan));
                $this->db->bind('id_barang', $id_barang);
                $this->db->bind('qty', $qty);
                $this->db->bind('id_user', $id_user);
            }
            
            $this->db->execute();

            // AUTO ADD TO MASTER DATA CONTAINER
            $this->db->query("SELECT kb.nama_kategori 
                              FROM barang b 
                              JOIN kategori_barang kb ON b.id_kategori = kb.id_kategori 
                              WHERE b.id_barang = :id_barang");
            $this->db->bind('id_barang', $id_barang);
            $kat = $this->db->single();
            
            if ($kat && $kat['nama_kategori'] == 'Container') {
                $this->db->query("SELECT id_container FROM container WHERE kode_ruangan = :kode AND id_barang = :id_barang");
                $this->db->bind('kode', $kode_ruangan);
                $this->db->bind('id_barang', $id_barang);
                if (!$this->db->single()) {
                    $this->db->query("INSERT INTO container (kode_ruangan, id_barang, id_user, qr_data) VALUES (:kode, :id_barang, :id_user, '')");
                    $this->db->bind('kode', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->bind('id_user', $id_user);
                    $this->db->execute();

                    $id_container = $this->db->lastInsertId();
                    $qr_url = BASEURL . "home/container/" . $id_container;
                    $this->db->query("UPDATE container SET qr_data = :qr WHERE id_container = :id");
                    $this->db->bind('qr', $qr_url);
                    $this->db->bind('id', $id_container);
                    $this->db->execute();
                }
            }

            $count++;
        }

        return $count;
    }

    public function getBarangByRuangan($kode_ruangan)
    {
        $this->db->query("SELECT rb.*, b.id_kategori 
                          FROM ruangan_barang rb
                          JOIN barang b ON rb.id_barang = b.id_barang
                          WHERE rb.kode_ruangan = :kode_ruangan");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        return $this->db->resultSet();
    }

    public function getDetailBarangByRuangan($kode_ruangan)
    {
        $query = "SELECT b.nama_barang, rb.id_barang, rb.kode_ruangan, 
                         SUM(rb.total_barang) as total_barang, 
                         SUM(rb.kondisi_baik) as kondisi_baik, 
                         SUM(rb.kondisi_rusak) as kondisi_rusak,
                         kb.nama_kategori,
                         c.id_container
                  FROM ruangan_barang rb
                  JOIN barang b ON rb.id_barang = b.id_barang
                  LEFT JOIN kategori_barang kb ON b.id_kategori = kb.id_kategori
                  LEFT JOIN container c ON rb.id_barang = c.id_barang AND rb.kode_ruangan = c.kode_ruangan
                  WHERE rb.kode_ruangan = :kode_ruangan AND rb.status_pengajuan = 'disetujui'
                  GROUP BY rb.id_barang, b.nama_barang, rb.kode_ruangan, kb.nama_kategori, c.id_container";
        $this->db->query($query);
        $this->db->bind('kode_ruangan', $kode_ruangan);
        return $this->db->resultSet();
    }

    public function ubahDataBarangRuangan($data)
    {
        $kode_ruangan = $data['kode_ruangan'];
        $items = $data['id_barang'];
        $totals = $data['total_barang'];

        // Ambil ID barang yang saat ini ada di ruangan untuk perbandingan
        $this->db->query("SELECT id_barang FROM ruangan_barang WHERE kode_ruangan = :kode AND status_pengajuan = 'disetujui'");
        $this->db->bind('kode', $kode_ruangan);
        $currentItems = $this->db->resultSet();
        $processedIds = [];

        $count = 0;
        $id_user = Session::user()['id_user'];
        foreach ($items as $index => $id_barang) {
            if (empty($id_barang)) continue;
            
            $processedIds[] = $id_barang;
            $qty = (int)($totals[$index] ?? 0);

            // Cek apakah barang sudah ada di ruangan tersebut
            $this->db->query("SELECT id_ruangan_barang FROM ruangan_barang WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang AND status_pengajuan = 'disetujui'");
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->bind('id_barang', $id_barang);
            $existing = $this->db->single();

            if ($qty <= 0) {
                if ($existing) {
                    // Hapus jika jumlahnya 0
                    $this->db->query("DELETE FROM ruangan_barang WHERE id_ruangan_barang = :id");
                    $this->db->bind('id', $existing['id_ruangan_barang']);
                    $this->db->execute();

                    $this->db->query("DELETE FROM container WHERE kode_ruangan = :kode AND id_barang = :id_barang");
                    $this->db->bind('kode', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                }
                continue;
            }

            if ($existing) {
                // Update dengan nilai baru
                $query = "UPDATE ruangan_barang 
                          SET total_barang = :qty,
                              kondisi_baik = :qty,
                              kondisi_rusak = 0,
                              id_user = :id_user
                          WHERE id_ruangan_barang = :id_ruangan_barang";
                $this->db->query($query);
                $this->db->bind('qty', $qty);
                $this->db->bind('id_user', $id_user);
                $this->db->bind('id_ruangan_barang', $existing['id_ruangan_barang']);
            } else {
                // Insert baru
                $query = "INSERT INTO ruangan_barang (kode_ruangan, id_barang, total_barang, kondisi_baik, kondisi_rusak, status_pengajuan, id_user) 
                          VALUES (:kode_ruangan, :id_barang, :qty, :qty, 0, 'disetujui', :id_user)";
                $this->db->query($query);
                $this->db->bind('kode_ruangan', $kode_ruangan);
                $this->db->bind('id_barang', $id_barang);
                $this->db->bind('qty', $qty);
                $this->db->bind('id_user', $id_user);
            }
            
            $this->db->execute();

            // AUTO ADD TO MASTER DATA CONTAINER
            $this->db->query("SELECT kb.nama_kategori 
                              FROM barang b 
                              JOIN kategori_barang kb ON b.id_kategori = kb.id_kategori 
                              WHERE b.id_barang = :id_barang");
            $this->db->bind('id_barang', $id_barang);
            $kat = $this->db->single();
            
            if ($kat && $kat['nama_kategori'] == 'Container') {
                $this->db->query("SELECT id_container FROM container WHERE kode_ruangan = :kode AND id_barang = :id_barang");
                $this->db->bind('kode', $kode_ruangan);
                $this->db->bind('id_barang', $id_barang);
                if (!$this->db->single()) {
                    $this->db->query("INSERT INTO container (kode_ruangan, id_barang, id_user, qr_data) VALUES (:kode, :id_barang, :id_user, '')");
                    $this->db->bind('kode', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->bind('id_user', $id_user);
                    $this->db->execute();

                    $id_container = $this->db->lastInsertId();
                    $qr_url = BASEURL . "home/container/" . $id_container;
                    $this->db->query("UPDATE container SET qr_data = :qr WHERE id_container = :id");
                    $this->db->bind('qr', $qr_url);
                    $this->db->bind('id', $id_container);
                    $this->db->execute();
                }
            }

            $count++;
        }

        // HAPUS BARANG YANG TIDAK ADA LAGI DI LIST (REMOVED FROM FORM)
        foreach ($currentItems as $oldItem) {
            if (!in_array($oldItem['id_barang'], $processedIds)) {
                $this->db->query("DELETE FROM ruangan_barang WHERE kode_ruangan = :kode AND id_barang = :id_barang");
                $this->db->bind('kode', $kode_ruangan);
                $this->db->bind('id_barang', $oldItem['id_barang']);
                $this->db->execute();

                // Juga hapus dari container jika ada
                $this->db->query("DELETE FROM container WHERE kode_ruangan = :kode AND id_barang = :id_barang");
                $this->db->bind('kode', $kode_ruangan);
                $this->db->bind('id_barang', $oldItem['id_barang']);
                $this->db->execute();
            }
        }

        return $count;
    }

    public function hapusDataBarangRuangan($kode_ruangan)
    {
        $this->db->query("DELETE FROM ruangan_barang WHERE kode_ruangan = :kode_ruangan");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $this->db->execute();

        // Juga hapus dari master data container untuk ruangan ini
        $this->db->query("DELETE FROM container WHERE kode_ruangan = :kode_ruangan");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusSatuBarangRuangan($kode_ruangan, $id_barang)
    {
        $this->db->query("DELETE FROM ruangan_barang WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $this->db->bind('id_barang', $id_barang);
        $this->db->execute();

        // Juga hapus dari master data container untuk ruangan dan barang ini jika ada
        $this->db->query("DELETE FROM container WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $this->db->bind('id_barang', $id_barang);
        $this->db->execute();

        return $this->db->rowCount();
    }
    public function importDataBarangCSV($kode_ruangan, $nama_barang, $total_barang, $kondisi_baik, $kondisi_rusak)
    {
        // 0. Cek apakah ruangan sudah ada
        $this->db->query("SELECT * FROM ruangan WHERE kode_ruangan = :kode_ruangan");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $ruangan = $this->db->single();

        if (!$ruangan) {
            // Buat ruangan baru
            $nama_ruangan = "Ruang " . $kode_ruangan;
            $lokasi = "Gedung Utama"; // Default
            
            $this->db->query("INSERT INTO ruangan (nama_ruangan, kode_ruangan, lokasi, qr_data, delete_at)
                              VALUES (:nama_ruangan, :kode_ruangan, :lokasi, '', 1)");
            $this->db->bind('nama_ruangan', $nama_ruangan);
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->bind('lokasi', $lokasi);
            $this->db->execute();
            
            $qr_data = BASEURL . 'home/index/' . $kode_ruangan;
            $this->db->query("UPDATE ruangan SET qr_data = :qr_data WHERE kode_ruangan = :kode_ruangan");
            $this->db->bind('qr_data', $qr_data);
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->execute();
        } elseif ($ruangan['delete_at'] == 0) {
            // Jika ruangan di-softdelete, restore ruangan tersebut
            $this->db->query("UPDATE ruangan SET delete_at = 1 WHERE kode_ruangan = :kode_ruangan");
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->execute();
        }

        // 1. Cari id_barang berdasarkan nama_barang
        $this->db->query("SELECT id_barang FROM barang WHERE nama_barang = :nama_barang");
        $this->db->bind('nama_barang', $nama_barang);
        $barang = $this->db->single();

        if ($barang) {
            $id_barang = $barang['id_barang'];
        } else {
            // Jika data berjumlah 0 dan barang belum ada, tidak perlu di-insert ke tabel barang
            if ($total_barang <= 0) return true;

            // Jika tidak ada, tambahkan barang baru
            $this->db->query("INSERT INTO barang (nama_barang) VALUES (:nama_barang)");
            $this->db->bind('nama_barang', $nama_barang);
            $this->db->execute();
            
            $this->db->query("SELECT id_barang FROM barang WHERE nama_barang = :nama_barang ORDER BY id_barang DESC LIMIT 1");
            $this->db->bind('nama_barang', $nama_barang);
            $newBarang = $this->db->single();
            $id_barang = $newBarang['id_barang'];
        }

        // 2. Jika total barang 0, hapus dari database ruangan ini jika ada
        if ($total_barang <= 0) {
            $this->db->query("DELETE FROM ruangan_barang WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->bind('id_barang', $id_barang);
            $this->db->execute();

            // Juga hapus dari master data container jika barang tersebut adalah container
            $this->db->query("DELETE FROM container WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->bind('id_barang', $id_barang);
            $this->db->execute();

            return true;
        }

        // 3. Cek apakah barang sudah ada di ruangan tersebut
        $this->db->query("SELECT id_ruangan_barang FROM ruangan_barang WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $this->db->bind('id_barang', $id_barang);
        $existing = $this->db->single();

        $id_user = Session::user()['id_user'];

        if ($existing) {
            // Update
            $this->db->query("UPDATE ruangan_barang 
                              SET total_barang = :total_barang,
                                  kondisi_baik = :kondisi_baik,
                                  kondisi_rusak = :kondisi_rusak,
                                  id_user = :id_user,
                                  status_pengajuan = 'disetujui'
                              WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
        } else {
            // Insert
            $this->db->query("INSERT INTO ruangan_barang (kode_ruangan, id_barang, total_barang, kondisi_baik, kondisi_rusak, id_user, status_pengajuan) 
                              VALUES (:kode_ruangan, :id_barang, :total_barang, :kondisi_baik, :kondisi_rusak, :id_user, 'disetujui')");
        }
        
        $this->db->bind('kode_ruangan', $kode_ruangan);
        $this->db->bind('id_barang', $id_barang);
        $this->db->bind('total_barang', $total_barang);
        $this->db->bind('kondisi_baik', $kondisi_baik);
        $this->db->bind('kondisi_rusak', $kondisi_rusak);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();

        // AUTO ADD TO MASTER DATA CONTAINER
        $this->db->query("SELECT kb.nama_kategori 
                          FROM barang b 
                          JOIN kategori_barang kb ON b.id_kategori = kb.id_kategori 
                          WHERE b.id_barang = :id_barang");
        $this->db->bind('id_barang', $id_barang);
        $kat = $this->db->single();
        
            if ($kat && $kat['nama_kategori'] == 'Container') {
                $this->db->query("SELECT id_container FROM container WHERE kode_ruangan = :kode AND id_barang = :id_barang");
                $this->db->bind('kode', $kode_ruangan);
                $this->db->bind('id_barang', $id_barang);
                if (!$this->db->single()) {
                    $this->db->query("INSERT INTO container (kode_ruangan, id_barang, id_user, qr_data) VALUES (:kode, :id_barang, :id_user, '')");
                    $this->db->bind('kode', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->bind('id_user', $id_user);
                    $this->db->execute();

                    $id_container = $this->db->lastInsertId();
                    $qr_url = BASEURL . "home/container/" . $id_container;
                    $this->db->query("UPDATE container SET qr_data = :qr WHERE id_container = :id");
                    $this->db->bind('qr', $qr_url);
                    $this->db->bind('id', $id_container);
                    $this->db->execute();
                }
            }
        
        return 1;
    }

    public function ajukanBarang($data)
    {
        $kode_ruangan = $data['kode_ruangan'];
        $id_user = $data['id_user'];
        $id_barangs = $data['id_barang'];
        $total_barangs = $data['total_barang'];

        $count = 0;
        foreach ($id_barangs as $index => $id_barang) {
            if (empty($id_barang) || empty($total_barangs[$index])) continue;

            $query = "INSERT INTO ruangan_barang (kode_ruangan, id_barang, id_user, total_barang, kondisi_baik, kondisi_rusak, status_pengajuan) 
                      VALUES (:kode_ruangan, :id_barang, :id_user, :total_barang, :kondisi_baik, :kondisi_rusak, :status_pengajuan)";
            
            $this->db->query($query);
            $this->db->bind('kode_ruangan', $kode_ruangan);
            $this->db->bind('id_barang', $id_barang);
            $this->db->bind('id_user', $id_user);
            $this->db->bind('total_barang', $total_barangs[$index]);
            $this->db->bind('kondisi_baik', $total_barangs[$index]); 
            $this->db->bind('kondisi_rusak', 0);
            $this->db->bind('status_pengajuan', 'diproses');
            
            if ($this->db->execute()) {
                $count++;
            }
        }
        
        return $count;
    }

    public function getPengajuanByRuangan($kode_ruangan)
    {
        $query = "SELECT rb.*, b.nama_barang, u.nama_lengkap 
                  FROM ruangan_barang rb
                  JOIN barang b ON rb.id_barang = b.id_barang
                  LEFT JOIN user u ON rb.id_user = u.id_user
                  WHERE rb.kode_ruangan = :kode_ruangan AND (u.role != 'Admin' OR u.role IS NULL)
                  ORDER BY rb.created_at DESC";
        $this->db->query($query);
        $this->db->bind('kode_ruangan', $kode_ruangan);
        return $this->db->resultSet();
    }

    public function getAllPengajuan()
    {
        $query = "SELECT rb.*, b.nama_barang, u.nama_lengkap, r.nama_ruangan 
                  FROM ruangan_barang rb
                  JOIN barang b ON rb.id_barang = b.id_barang
                  JOIN ruangan r ON rb.kode_ruangan = r.kode_ruangan
                  LEFT JOIN user u ON rb.id_user = u.id_user
                  WHERE rb.status_pengajuan = 'diproses'
                  ORDER BY rb.created_at DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function updateStatusPengajuan($id, $status)
    {
        $query = "UPDATE ruangan_barang SET status_pengajuan = :status WHERE id_ruangan_barang = :id";
        $this->db->query($query);
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }
}

