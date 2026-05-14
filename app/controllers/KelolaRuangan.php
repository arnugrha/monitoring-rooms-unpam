<?php 
  class KelolaRuangan extends Controller {
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
      $data['judul'] = 'Kelola Ruangan';
      $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
      $data['totalRuangan'] = $this->models('Ruangan_model')->getTotalRuangan();
      $data['totalAktif'] = $this->models('Ruangan_model')->getTotalAktif();
      $data['totalMaintenance'] = $this->models('Ruangan_model')->getTotalProsesPerbaikan();
      // $data['totalKosong'] = $this->models('Ruangan_model')->getTotalKetuaKelas();
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/kelolaRuangan/index', $data);
      $this->views('admin/templates/footer');
    }

    public function tambah()
    {
        $data['judul'] = 'Tambah Ruangan';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi input
            $input = [
                'nama_ruangan' => trim($_POST['nama_ruangan']),
                'kode_ruangan' => trim($_POST['kode_ruangan']),
                'lokasi'       => trim($_POST['lokasi'] ?? ''),
                'qr_data'      => trim($_POST['qr_data'] ?? ''),
            ];

            // Cek field kosong
            if (empty($input['nama_ruangan']) || empty($input['kode_ruangan']) || empty($input['lokasi'])) {
                $data['error'] = 'Semua field wajib diisi!';
            } else {
                // Validasi kode ruangan sudah ada
                $existing = $this->models('Ruangan_model')->getRuanganByKode($input['kode_ruangan']);
                if ($existing) {
                    if ($existing['delete_at'] == 0) {
                        $result = $this->models('Ruangan_model')->restoreRuangan($input);

                        if ($result) {
                            if (isset($_POST['action']) && $_POST['action'] === 'save_and_add_items') {
                                header('Location: ' . BASEURL . 'monitoringRuangan/edit/' . $input['kode_ruangan']);
                            } else {
                                header('Location: ' . BASEURL . 'kelolaRuangan');
                            }
                            exit;
                        } else {
                            $data['error'] = 'Gagal menambahkan kembali ruangan, coba lagi!';
                        }
                    } else {
                        $data['error'] = 'Kode ruangan sudah ada!';
                    }
                } else {
                    $result = $this->models('Ruangan_model')->tambahRuangan($input);

                    if ($result) {
                        if (isset($_POST['action']) && $_POST['action'] === 'save_and_add_items') {
                            header('Location: ' . BASEURL . 'monitoringRuangan/edit/' . $input['kode_ruangan']);
                        } else {
                            header('Location: ' . BASEURL . 'kelolaRuangan');
                        }
                        exit;
                    } else {
                        $data['error'] = 'Gagal menambahkan ruangan, coba lagi!';
                    }
                }
            }
        }

        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/kelolaRuangan/tambah', $data);
        $this->views('admin/templates/footer');
    }

    public function edit($id = null)
    {
        $data['judul'] = 'Edit Ruangan';

        // Cek ID valid
        if (!$id) {
            header('Location: ' . BASEURL . 'KelolaRuangan');
            exit;
        }

        $data['ruangan'] = $this->models('Ruangan_model')->getRuanganById($id);

        // Cek ruangan ada
        if (!$data['ruangan']) {
            header('Location: ' . BASEURL . 'KelolaRuangan?error=Ruangan tidak ditemukan');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = [
                'kode_lama'    => trim($_POST['kode_lama']),
                'kode_ruangan' => trim($_POST['kode_ruangan']),
                'nama_ruangan' => trim($_POST['nama_ruangan']),
                'lokasi'       => trim($_POST['lokasi']),
                'status_ruangan' => trim($_POST['status_ruangan']),
            ];

            // Cek field kosong
            if (empty($input['nama_ruangan']) || empty($input['kode_ruangan']) || empty($input['lokasi'])) {
                $data['error'] = 'Semua field wajib diisi!';
            } else {
                // Validasi kode ruangan sudah ada dan bukan milik sendiri
                $existing = $this->models('Ruangan_model')->getRuanganByKode($input['kode_ruangan']);
                if ($existing && $existing['kode_ruangan'] !== $input['kode_lama']) {
                    $data['error'] = 'Kode ruangan sudah ada!';
                } else {
                    $result = $this->models('Ruangan_model')->updateRuangan($input);

                    if ($result) {
                        header('Location: ' . BASEURL . 'KelolaRuangan?success=Ruangan berhasil diupdate');
                        exit;
                    } else {
                        $data['error'] = 'Gagal mengupdate ruangan, coba lagi!';
                    }
                }
            }
        }

        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/kelolaRuangan/edit', $data);
        $this->views('admin/templates/footer');
    }

    public function hapus($id)
    {
        if($this->models('Ruangan_model')->deleteRuangan($id) > 0) {
            header('Location: ' . BASEURL . 'kelolaRuangan');
            exit;
        }
    }

    public function prosesUbah()
    {
      if ($this->models('Ruangan_model')->updateRuangan($_POST) > 0) {
        header('Location: ' . BASEURL . 'kelolaRuangan');
        exit;
      }
    }

    public function cetakSemuaQR()
    {
        $data['judul'] = 'Cetak Semua QR Code Ruangan';
        $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/kelolaRuangan/cetak_qr', $data);
    }

    public function cetakQR($id)
    {
        $data['judul'] = 'Cetak QR Code Ruangan';
        $data['ruangan'] = [$this->models('Ruangan_model')->getRuanganByKode($id)];
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/kelolaRuangan/cetak_qr', $data);
    }

  }