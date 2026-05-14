<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class KelolaLaporan extends Controller
{
    public function __construct() {
        if (!Session::isLoggedIn()) {
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        if (Session::role() !== 'Admin') {
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }
    }
    public function index()
    {
        $data['judul']          = 'Kelola Laporan';
        $data['laporan']        = $this->models('Laporan_model')->getAllLaporan();
        $data['total_laporan']  = $this->models('Laporan_model')->getTotalLaporan();
        $data['total_baru']     = $this->models('Laporan_model')->getTotalLaporanBaru();
        $data['total_proses']   = $this->models('Laporan_model')->getTotalProsesPerbaikan();
        $data['total_selesai']  = $this->models('Laporan_model')->getTotalSelesai();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/kelolaLaporan/index', $data);
        $this->views('admin/templates/footer');
    }

    public function tambah()
    {
        $data['judul']    = 'Tambah Laporan';
        $data['barang']   = $this->models('Barang_model')->getAllBarang();
        $data['kategori'] = $this->models('Barang_model')->getAllKategori();
        $data['ruangan']  = $this->models('Ruangan_model')->getAllRuangan();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/kelolaLaporan/tambah', $data);
        $this->views('admin/templates/footer');
    }

    public function prosesTambah()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle upload foto
            $namaFoto = null;
            if (!empty($_FILES['foto']['name'])) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $namaFoto = 'foto_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                $uploadDir = 'uploads/laporan/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $namaFoto);
            }
            
            $data = [
                'id_user'        => Session::user()['id_user'],
                'id_barang'      => $_POST['id_barang'],
                'kode_ruangan'   => $_POST['kode_ruangan'],
                'jenis_laporan'  => $_POST['jenis_laporan'],
                'deskripsi'      => $_POST['deskripsi'],
                'foto'           => $namaFoto,
                'status_laporan' => $_POST['status_laporan'],
                'jumlah_barang'  => $_POST['jumlah_barang']
            ];
            
            if ($this->models('Laporan_model')->tambahLaporan($data) > 0) {
                header('Location: ' . BASEURL . 'kelolaLaporan?success=Laporan berhasil ditambahkan');
                exit;
            } else {
                header('Location: ' . BASEURL . 'kelolaLaporan/tambah?error=Gagal menambahkan laporan');
                exit;
            }
        }
    }

    public function edit($id)
    {
        $data['judul']    = 'Edit Laporan';
        $data['laporan']  = $this->models('Laporan_model')->getLaporanById($id);
        $data['barang']   = $this->models('Barang_model')->getAllBarang();
        $data['kategori'] = $this->models('Barang_model')->getAllKategori();
        $data['ruangan']  = $this->models('Ruangan_model')->getAllRuangan();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/kelolaLaporan/edit', $data);
        $this->views('admin/templates/footer');
    }

    public function prosesUbah()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_laporan'];
            
            // Handle upload foto baru
            $namaFoto = $_POST['foto_lama'] ?? null;
            
            if (!empty($_FILES['foto']['name'])) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $namaFoto = 'foto_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                $uploadDir = 'uploads/laporan/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $namaFoto)) {
                    // Hapus foto lama jika ada
                    if (!empty($_POST['foto_lama']) && file_exists($uploadDir . $_POST['foto_lama'])) {
                        unlink($uploadDir . $_POST['foto_lama']);
                    }
                }
            }
            
            $data = [
                'id_laporan'     => $id,
                'id_barang'      => $_POST['id_barang'],
                'kode_ruangan'   => $_POST['kode_ruangan'],
                'jenis_laporan'  => $_POST['jenis_laporan'],
                'tanggal'        => $_POST['tanggal'],
                'deskripsi'      => $_POST['deskripsi'],
                'status_laporan' => $_POST['status_laporan'],
                'jumlah_barang'  => $_POST['jumlah_barang'],
                'foto'           => $namaFoto
            ];
            
            if ($this->models('Laporan_model')->ubahLaporan($data) > 0) {
                header('Location: ' . BASEURL . 'kelolaLaporan?success=Laporan berhasil diupdate');
                exit;
            } else {
                header('Location: ' . BASEURL . 'kelolaLaporan/edit/' . $id . '?error=Gagal update laporan');
                exit;
            }
        }
    }

    public function hapus($id)
    {
        // Hapus foto juga jika ada
        $laporan = $this->models('Laporan_model')->getLaporanById($id);
        if ($laporan && !empty($laporan['foto'])) {
            $filePath = 'uploads/laporan/' . $laporan['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        if ($this->models('Laporan_model')->hapusLaporan($id) > 0) {
            header('Location: ' . BASEURL . 'kelolaLaporan?success=Laporan berhasil dihapus');
            exit;
        } else {
            header('Location: ' . BASEURL . 'kelolaLaporan?error=Gagal menghapus laporan');
            exit;
        }
    }

    public function updateStatus($id)
    {
        $status = $_POST['status_laporan'] ?? '';
        if ($this->models('Laporan_model')->updateStatus($id, $status) > 0) {
            header('Location: ' . BASEURL . 'kelolaLaporan?success=Status berhasil diupdate');
            exit;
        } else {
            header('Location: ' . BASEURL . 'kelolaLaporan?error=Gagal update status');
            exit;
        }
    }

    public function getBarangByRuangan($kode_ruangan)
    {
        $barang = $this->models('Monitoring_ruangan_model')->getBarangByRuangan($kode_ruangan);
        echo json_encode($barang);
    }
}