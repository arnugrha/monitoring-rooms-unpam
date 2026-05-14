<?php
class Laporan_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Ambil semua laporan dengan join ke barang dan ruangan
    public function getAllLaporan()
    {
        $this->db->query("SELECT 
                            l.*,
                            b.nama_barang,
                            b.id_kategori,
                            r.nama_ruangan
                          FROM laporan l
                          JOIN barang b ON l.id_barang = b.id_barang
                          JOIN ruangan r ON l.kode_ruangan = r.kode_ruangan
                            LEFT JOIN user u ON l.id_user = u.id_user
                          WHERE l.delete_at = 1
                          ORDER BY l.id_laporan DESC");
        return $this->db->resultSet();
    }

    // Ambil laporan berdasarkan ID
    public function getLaporanById($id)
    {
        $this->db->query("SELECT 
                            l.*,
                            b.nama_barang,
                            b.id_kategori,
                            r.nama_ruangan
                          FROM laporan l
                          JOIN barang b ON l.id_barang = b.id_barang
                          JOIN ruangan r ON l.kode_ruangan = r.kode_ruangan
                          LEFT JOIN user u ON l.id_user = u.id_user
                          WHERE l.id_laporan = :id AND l.delete_at = 1");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // Tambah laporan baru
    public function tambahLaporan($data)
    {
        $query = "INSERT INTO laporan (id_user, id_barang, kode_ruangan, id_container, jenis_laporan, deskripsi, foto, status_laporan, jumlah_barang) 
                  VALUES (:id_user, :id_barang, :kode_ruangan, :id_container, :jenis_laporan, :deskripsi, :foto, :status_laporan, :jumlah_barang)";
        
        $this->db->query($query);
        $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('id_barang', $data['id_barang']);
        $this->db->bind('kode_ruangan', $data['kode_ruangan']);
        $this->db->bind('id_container', $data['id_container'] ?? null);
        $this->db->bind('jenis_laporan', $data['jenis_laporan']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('foto', $data['foto']);
        $this->db->bind('status_laporan', $data['status_laporan']);
        $this->db->bind('jumlah_barang', $data['jumlah_barang']);
        
        if ($this->db->execute()) {
            // Jika jenis laporan adalah 'rusak', update kondisi barang
            if (strtolower($data['jenis_laporan']) == 'rusak') {
                if (isset($data['id_container']) && !empty($data['id_container'])) {
                    // Update di tabel container_barang
                    $this->db->query("UPDATE container_barang 
                                      SET kondisi_baik = kondisi_baik - :jumlah,
                                          kondisi_rusak = kondisi_rusak + :jumlah
                                      WHERE id_container = :id_container AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $data['jumlah_barang']);
                    $this->db->bind('id_container', $data['id_container']);
                    $this->db->bind('id_barang', $data['id_barang']);
                    $this->db->execute();
                } else {
                    // Update di tabel ruangan_barang
                    $this->db->query("UPDATE ruangan_barang 
                                      SET kondisi_baik = kondisi_baik - :jumlah,
                                          kondisi_rusak = kondisi_rusak + :jumlah
                                      WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $data['jumlah_barang']);
                    $this->db->bind('kode_ruangan', $data['kode_ruangan']);
                    $this->db->bind('id_barang', $data['id_barang']);
                    $this->db->execute();
                }
            }
            return 1;
        }
        
        return 0;
    }

   // Ubah laporan
public function ubahLaporan($data)
{
    // Ambil data lama sebelum diupdate untuk perbandingan status
    $oldLaporan = $this->getLaporanById($data['id_laporan']);
    
    $query = "UPDATE laporan SET 
                id_barang = :id_barang,
                kode_ruangan = :kode_ruangan,
                jenis_laporan = :jenis_laporan,
                -- tanggal = :tanggal,
                deskripsi = :deskripsi,
                status_laporan = :status_laporan,
                jumlah_barang = :jumlah_barang,
                foto = :foto
              WHERE id_laporan = :id_laporan";
    
    $this->db->query($query);
    $this->db->bind('id_barang', $data['id_barang']);
    $this->db->bind('kode_ruangan', $data['kode_ruangan']);
    $this->db->bind('jenis_laporan', $data['jenis_laporan']);
    // $this->db->bind('tanggal', $data['tanggal']);
    $this->db->bind('deskripsi', $data['deskripsi']);
    $this->db->bind('status_laporan', $data['status_laporan']);
    $this->db->bind('jumlah_barang', $data['jumlah_barang']);
    $this->db->bind('foto', $data['foto']);
    $this->db->bind('id_laporan', $data['id_laporan']);
    
    $this->db->execute();
    $rowCount = $this->db->rowCount();

    // Jika update berhasil dan ada data lama
    if ($oldLaporan) {
        $oldStatus = $oldLaporan['status_laporan'];
        $newStatus = $data['status_laporan'];
        $type = strtolower($data['jenis_laporan']);
        $jumlah = $data['jumlah_barang'];
        $kode_ruangan = $data['kode_ruangan'];
        $id_barang = $data['id_barang'];

        if ($type == 'rusak') {
            if ($oldStatus != 'Selesai' && $newStatus == 'Selesai') {
                // Menjadi Selesai
                if ($oldLaporan['id_container']) {
                    $this->db->query("UPDATE container_barang 
                                      SET kondisi_baik = kondisi_baik + :jumlah,
                                          kondisi_rusak = kondisi_rusak - :jumlah
                                      WHERE id_container = :id_container AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('id_container', $oldLaporan['id_container']);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                } else {
                    $this->db->query("UPDATE ruangan_barang 
                                      SET kondisi_baik = kondisi_baik + :jumlah,
                                          kondisi_rusak = kondisi_rusak - :jumlah
                                      WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('kode_ruangan', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                }
            } else if ($oldStatus == 'Selesai' && $newStatus != 'Selesai') {
                // Revert dari Selesai
                if ($oldLaporan['id_container']) {
                    $this->db->query("UPDATE container_barang 
                                      SET kondisi_baik = kondisi_baik - :jumlah,
                                          kondisi_rusak = kondisi_rusak + :jumlah
                                      WHERE id_container = :id_container AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('id_container', $oldLaporan['id_container']);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                } else {
                    $this->db->query("UPDATE ruangan_barang 
                                      SET kondisi_baik = kondisi_baik - :jumlah,
                                          kondisi_rusak = kondisi_rusak + :jumlah
                                      WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('kode_ruangan', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                }
            }
        }
    }
    
    return $rowCount;
}

    // Hapus laporan (soft delete)
    public function hapusLaporan($id)
    {
         $this->db->query("DELETE FROM laporan WHERE id_laporan = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return 1;
    }

    // Update status laporan saja
    public function updateStatus($id, $status)
    {
        // Ambil data lama sebelum diupdate
        $oldLaporan = $this->getLaporanById($id);
        if (!$oldLaporan) return 0;

        $oldStatus = $oldLaporan['status_laporan'];
        $type = strtolower($oldLaporan['jenis_laporan']);
        $jumlah = $oldLaporan['jumlah_barang'];
        $kode_ruangan = $oldLaporan['kode_ruangan'];
        $id_barang = $oldLaporan['id_barang'];
        $id_container = $oldLaporan['id_container'];

        // Update status di tabel laporan
        $this->db->query("UPDATE laporan SET status_laporan = :status WHERE id_laporan = :id");
        $this->db->bind('status', $status);
        $this->db->bind('id', $id);
        $this->db->execute();

        // Jika jenis laporan adalah 'rusak', update kondisi barang
        if ($type == 'rusak') {
            if ($oldStatus != 'Selesai' && $status == 'Selesai') {
                // Jika berubah menjadi Selesai: baik bertambah, rusak berkurang
                if ($id_container) {
                    $this->db->query("UPDATE container_barang 
                                      SET kondisi_baik = kondisi_baik + :jumlah,
                                          kondisi_rusak = kondisi_rusak - :jumlah
                                      WHERE id_container = :id_container AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('id_container', $id_container);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                } else {
                    $this->db->query("UPDATE ruangan_barang 
                                      SET kondisi_baik = kondisi_baik + :jumlah,
                                          kondisi_rusak = kondisi_rusak - :jumlah
                                      WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('kode_ruangan', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                }
            } else if ($oldStatus == 'Selesai' && $status != 'Selesai') {
                // Jika berubah dari Selesai ke status lain (revert): baik berkurang, rusak bertambah
                if ($id_container) {
                    $this->db->query("UPDATE container_barang 
                                      SET kondisi_baik = kondisi_baik - :jumlah,
                                          kondisi_rusak = kondisi_rusak + :jumlah
                                      WHERE id_container = :id_container AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('id_container', $id_container);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                } else {
                    $this->db->query("UPDATE ruangan_barang 
                                      SET kondisi_baik = kondisi_baik - :jumlah,
                                          kondisi_rusak = kondisi_rusak + :jumlah
                                      WHERE kode_ruangan = :kode_ruangan AND id_barang = :id_barang");
                    $this->db->bind('jumlah', $jumlah);
                    $this->db->bind('kode_ruangan', $kode_ruangan);
                    $this->db->bind('id_barang', $id_barang);
                    $this->db->execute();
                }
            }
        }

        return 1;
    }

    // Total semua laporan
    public function getTotalLaporan()
    {
        $this->db->query("SELECT COUNT(*) as total FROM laporan WHERE delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }

    // Total laporan dengan status BARU
    public function getTotalLaporanBaru()
    {
        $this->db->query("SELECT COUNT(*) as total FROM laporan WHERE status_laporan = 'Baru' AND delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }

    // Total laporan dengan status PROSES
    public function getTotalProsesPerbaikan()
    {
        $this->db->query("SELECT COUNT(*) as total FROM laporan WHERE status_laporan = 'Proses' AND delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }

    // Total laporan dengan status SELESAI
    public function getTotalSelesai()
    {
        $this->db->query("SELECT COUNT(*) as total FROM laporan WHERE status_laporan = 'Selesai' AND delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }


    public function getLaporanHariIni()
    {
        $this->db->query("SELECT COUNT(*) as total FROM laporan WHERE DATE(created_at) = CURDATE() AND delete_at = 1");
        $result = $this->db->single();
        return $result['total'] ? $result['total'] : 0;
    }

    public function getMonthlyReportCounts()
    {
        // Mendapatkan jumlah laporan per bulan untuk 6 bulan terakhir
        $this->db->query("SELECT 
                                MONTH(created_at) as bulan,
                                MONTHNAME(created_at) as nama_bulan, 
                                COUNT(*) as total 
                            FROM laporan 
                            WHERE delete_at = 1 
                            AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                            GROUP BY bulan, nama_bulan
                            ORDER BY bulan ASC");
        return $this->db->resultSet();
    }

    public function getRecentActivity()
    {
        $this->db->query("SELECT 
                            l.*, 
                            b.nama_barang, 
                            r.nama_ruangan,
                            u.nama_lengkap
                          FROM laporan l
                          JOIN barang b ON l.id_barang = b.id_barang
                          JOIN ruangan r ON l.kode_ruangan = r.kode_ruangan
                          JOIN user u ON l.id_user = u.id_user
                          WHERE l.delete_at = 1
                          ORDER BY l.id_laporan DESC
                          LIMIT 10");
        return $this->db->resultSet();
    }

    public function getLaporanByRuangan($kode_ruangan)
    {
        $this->db->query("SELECT l.*, b.nama_barang, u.nama_lengkap 
                          FROM laporan l 
                          JOIN barang b ON l.id_barang = b.id_barang 
                          LEFT JOIN user u ON l.id_user = u.id_user 
                          WHERE l.kode_ruangan = :kode_ruangan 
                          AND l.id_container IS NULL 
                          AND l.delete_at = 1 
                          ORDER BY l.created_at DESC");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        return $this->db->resultSet();
    }

    public function getSemuaLaporanByRuangan($kode_ruangan)
    {
        $this->db->query("SELECT l.*, b.nama_barang, u.nama_lengkap, bc.nama_barang AS nama_container
                          FROM laporan l 
                          JOIN barang b ON l.id_barang = b.id_barang 
                          LEFT JOIN user u ON l.id_user = u.id_user 
                          LEFT JOIN container c ON l.id_container = c.id_container
                          LEFT JOIN barang bc ON c.id_barang = bc.id_barang
                          WHERE l.kode_ruangan = :kode_ruangan 
                          AND l.delete_at = 1 
                          ORDER BY l.created_at DESC");
        $this->db->bind('kode_ruangan', $kode_ruangan);
        return $this->db->resultSet();
    }

    public function getLaporanByContainer($id_container)
    {
        $this->db->query("SELECT l.*, b.nama_barang, u.nama_lengkap 
                          FROM laporan l 
                          JOIN barang b ON l.id_barang = b.id_barang 
                          LEFT JOIN user u ON l.id_user = u.id_user 
                          WHERE l.id_container = :id_container 
                          AND l.delete_at = 1 
                          ORDER BY l.created_at DESC");
        $this->db->bind('id_container', $id_container);
        return $this->db->resultSet();
    }
}
