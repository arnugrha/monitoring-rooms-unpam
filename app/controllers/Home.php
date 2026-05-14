<?php
class Home extends Controller {
    public function __construct() {
        if (Session::isLoggedIn() && Session::role() === 'Admin') {
            header('Location: ' . BASEURL . 'index.php?url=Dashboard');
            exit;
        }
    }
    
    public function index($kode = null) {
        $ruanganModel = $this->models('Ruangan_model');
        $laporanModel = $this->models('Laporan_model');
        
        // Jika kode tidak ada di URL, coba ambil dari session (jika login)
        if ($kode === null) {
            $kode = Session::user()['kode_ruangan'] ?? null;
        } else {
            // Jika user login sebagai Ketua kelas, dia hanya boleh melihat ruangannya sendiri
            if (Session::isLoggedIn() && Session::role() === 'Ketua kelas') {
                $user_kode = Session::user()['kode_ruangan'];
                if ($kode !== $user_kode) {
                    header('Location: ' . BASEURL . 'index.php?url=Home/index/' . $user_kode);
                    exit;
                }
            }
            
            // Jika ada kode di URL, simpan ke session sebagai "last_viewed_room" 
            // agar setelah login bisa kembali ke sini (untuk role selain Ketua kelas)
            Session::set('last_viewed_room', $kode);
        }
        
        // Jika masih null, redirect ke halaman login atau tampilkan pesan (karena tidak ada ruangan default)
        if ($kode === null) {
             Session::setFlash('error', 'Silakan masukkan kode ruangan atau login terlebih dahulu.');
             header('Location: ' . BASEURL . 'index.php?url=AuthController');
             exit;
        }
        
        $data['ruangan'] = $ruanganModel->getRuanganById($kode);
        if (!$data['ruangan']) {
            $data['ruangan'] = ['kode_ruangan' => $kode, 'nama_ruangan' => 'Ruangan'];
        }
        
        // Ambil data barang ruangan
        $monitoringModel = $this->models('Monitoring_ruangan_model');
        $data['brg'] = $monitoringModel->getDetailBarangByRuangan($kode) ?: [];
        
        // Ambil riwayat laporan terbaru
        $data['riwayat_laporan'] = $laporanModel->getLaporanByRuangan($kode);

        // Ambil riwayat pengajuan barang
        $data['riwayat_pengajuan'] = $monitoringModel->getPengajuanByRuangan($kode);

        $data['ruangan_list'] = $ruanganModel->getAllRuangan();
        
       $data ['judul'] ="Monitoring Ruangan";

       $this->views('public/templates/header', $data);
       $this->views('public/home/index', $data);
    }
    
    public function laporan($kode = null) {
        // Cek apakah sudah login
        if(!Session::isLoggedIn()) {
            Session::set('redirect_after_login', BASEURL . 'index.php?url=Home/laporan' . ($kode ? '/' . $kode : ''));
            Session::setFlash('error', 'Silakan login terlebih dahulu untuk membuat laporan');
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        $role = Session::role();
        if($role !== 'Ketua kelas' && $role !== 'OB') {
            Session::setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
            header('Location: ' . BASEURL . 'index.php?url=Dashboard');
            exit;
        }
        
        $kode_ruangan = $kode ?? Session::user()['kode_ruangan'] ?? null;
        
        if ($role === 'Ketua kelas') {
            $user_kode = Session::user()['kode_ruangan'];
            if ($kode_ruangan !== $user_kode) {
                $kode_ruangan = $user_kode;
            }
        }
        
        if (!$kode_ruangan) {
            Session::setFlash('error', 'Anda tidak terdaftar di ruangan manapun.');
            header('Location: ' . BASEURL . 'index.php?url=Dashboard');
            exit;
        }

        $ruanganModel = $this->models('Ruangan_model');
        $monitoringModel = $this->models('Monitoring_ruangan_model');
        
        $data['judul'] = "Buat Laporan";
        $data['user'] = Session::user();
        $data['ruangan'] = $ruanganModel->getRuanganById($kode_ruangan);
        $data['items'] = $monitoringModel->getDetailBarangByRuangan($kode_ruangan);
        
        $this->views('public/templates/header', $data);
        $this->views('public/home/laporan', $data);
    }

    public function prosesLaporan() {
        if(!Session::isLoggedIn()) {
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }
        
        // Handle file upload
        $foto = '';
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $namaFile = $_FILES['foto']['name'];
            $ukuranFile = $_FILES['foto']['size'];
            $tmpName = $_FILES['foto']['tmp_name'];
            
            $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
            $ekstensiGambar = explode('.', $namaFile);
            $ekstensiGambar = strtolower(end($ekstensiGambar));
            
            if(in_array($ekstensiGambar, $ekstensiGambarValid)) {
                if($ukuranFile < 5000000) { // Max 5MB
                    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
                    $uploadDir = 'uploads/laporan/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    move_uploaded_file($tmpName, $uploadDir . $namaFileBaru);
                    $foto = $namaFileBaru;
                }
            }
        }
        
        $laporanModel = $this->models('Laporan_model');
        $data = [
            'id_user' => Session::user()['id_user'],
            'kode_ruangan' => $_POST['kode_ruangan'],
            'id_container' => $_POST['id_container'] ?? null,
            'id_barang' => $_POST['id_barang'],
            'jenis_laporan' => $_POST['jenis_laporan'],
            'deskripsi' => $_POST['deskripsi'],
            'jumlah_barang' => $_POST['jumlah_barang'] ?? 1,
            'status_laporan' => 'Baru', // Default status
            'foto' => $foto
        ];
        
        if($laporanModel->tambahLaporan($data) > 0) {
            Session::setFlash('success', 'Laporan berhasil dikirim');
            if (isset($_POST['id_container']) && !empty($_POST['id_container'])) {
                header('Location: ' . BASEURL . 'index.php?url=Home/container/' . $_POST['id_container']);
            } else {
                header('Location: ' . BASEURL . 'index.php?url=Home/index/' . $_POST['kode_ruangan']);
            }
            exit;
        } else {
            Session::setFlash('error', 'Gagal mengirim laporan');
            if (isset($_POST['id_container']) && !empty($_POST['id_container'])) {
                header('Location: ' . BASEURL . 'index.php?url=Home/laporan_container/' . $_POST['id_container']);
            } else {
                header('Location: ' . BASEURL . 'index.php?url=Home/laporan/' . $_POST['kode_ruangan']);
            }
            exit;
        }
    }
    
    // Halaman semua laporan
    public function semua_laporan() {
        // Bisa dilihat oleh ketua kelas dan ob
        $ruanganModel = $this->models('Ruangan_model');
        $laporanModel = $this->models('Laporan_model');
        
        $kode_ruangan = $_GET['ruangan'] ?? 'R.001';
        
        // Jika user login sebagai Ketua kelas, dia hanya boleh melihat laporan ruangannya sendiri
        if (Session::isLoggedIn() && Session::role() === 'Ketua kelas') {
            $user_kode = Session::user()['kode_ruangan'];
            if ($kode_ruangan !== $user_kode) {
                header('Location: ' . BASEURL . 'index.php?url=Home/semua_laporan&ruangan=' . $user_kode);
                exit;
            }
        }
        
        $data['ruangan'] = $ruanganModel->getRuanganByKode($kode_ruangan);
        $data['laporan'] = $laporanModel->getLaporanByRuangan($kode_ruangan);
        $data['judul'] = "Semua Laporan";
        
        $this->views('public/templates/header', $data);
        $this->views('public/home/semua_laporan', $data);
    }

    public function kelola_laporan($kode = null) {
        if(!Session::isLoggedIn() || Session::role() !== 'OB') {
            Session::setFlash('error', 'Akses terbatas untuk Office Boy');
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }

        if($kode === null) {
            $kode = Session::user()['kode_ruangan'];
        }

        $ruanganModel = $this->models('Ruangan_model');
        $laporanModel = $this->models('Laporan_model');

        $data['ruangan'] = $ruanganModel->getRuanganById($kode);
        $data['laporan'] = $laporanModel->getSemuaLaporanByRuangan($kode);
        $data['ruangan_list'] = $ruanganModel->getAllRuangan();
        $data['judul'] = "Kelola Laporan " . $kode;

        $this->views('public/templates/header', $data);
        $this->views('public/home/kelola_laporan', $data);
    }

    public function update_status_laporan() {
        if(!Session::isLoggedIn() || Session::role() !== 'OB') {
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_laporan = $_POST['id_laporan'];
            $status = $_POST['status'];
            $kode_ruangan = $_POST['kode_ruangan'];

            $laporanModel = $this->models('Laporan_model');
            if($laporanModel->updateStatus($id_laporan, $status)) {
                Session::setFlash('success', 'Status laporan berhasil diperbarui');
            } else {
                Session::setFlash('error', 'Gagal memperbarui status laporan');
            }
            header('Location: ' . BASEURL . 'index.php?url=Home/kelola_laporan/' . $kode_ruangan);
            exit;
        }
    }

    public function tambah_barang($kode = null) {
        if(!Session::isLoggedIn() || Session::role() !== 'Ketua kelas') {
            Session::setFlash('error', 'Akses ditolak.');
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }

        $kode_ruangan = $kode ?? Session::user()['kode_ruangan'];
        
        $ruanganModel = $this->models('Ruangan_model');
        $barangModel = $this->models('Barang_model');

        $data['judul'] = "Tambah Barang";
        $data['ruangan'] = $ruanganModel->getRuanganById($kode_ruangan);
        $data['barang_list'] = $barangModel->getAllBarang();

        $this->views('public/templates/header', $data);
        $this->views('public/home/tambah_barang', $data);
    }

    public function prosesTambahBarang() {
        if(!Session::isLoggedIn() || Session::role() !== 'Ketua kelas') {
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $monitoringModel = $this->models('Monitoring_ruangan_model');
            $data = [
                'kode_ruangan' => $_POST['kode_ruangan'],
                'id_user' => Session::user()['id_user'],
                'id_barang' => $_POST['id_barang'],
                'total_barang' => $_POST['total_barang']
            ];

            if($monitoringModel->ajukanBarang($data) > 0) {
                Session::setFlash('success', 'Pengajuan barang berhasil dikirim. Menunggu persetujuan Admin.');
                header('Location: ' . BASEURL . 'index.php?url=Home');
                exit;
            } else {
                Session::setFlash('error', 'Gagal mengajukan barang.');
                header('Location: ' . BASEURL . 'index.php?url=Home/tambah_barang');
                exit;
            }
        }
    }

    public function container($id) {
        $data['judul'] = 'Detail Container';
        $data['container'] = $this->models('Container_model')->getContainerDetailById($id);
        
        if(!$data['container']) {
             Session::setFlash('error', 'Container tidak ditemukan.');
             header('Location: ' . BASEURL . 'index.php?url=Home');
             exit;
        }
        
        $data['items'] = $this->models('BarangContainer_model')->getItemsByContainer($id);
        $data['riwayat_laporan'] = $this->models('Laporan_model')->getLaporanByContainer($id);
        
        $this->views('public/templates/header', $data);
        $this->views('public/home/container', $data);
    }

    public function laporan_container($id) {
        // Cek apakah sudah login
        if(!Session::isLoggedIn()) {
            Session::set('redirect_after_login', BASEURL . 'index.php?url=Home/laporan_container/' . $id);
            Session::setFlash('error', 'Silakan login terlebih dahulu untuk membuat laporan');
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        $role = Session::role();
        if($role !== 'Ketua kelas' && $role !== 'OB') {
            Session::setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
            header('Location: ' . BASEURL . 'index.php?url=Dashboard');
            exit;
        }

        $containerModel = $this->models('Container_model');
        $barangContainerModel = $this->models('BarangContainer_model');
        
        $data['container'] = $containerModel->getContainerDetailById($id);
        if (!$data['container']) {
            Session::setFlash('error', 'Container tidak ditemukan');
            header('Location: ' . BASEURL . 'index.php?url=Home');
            exit;
        }

        $data['judul'] = "Buat Laporan Container";
        $data['user'] = Session::user();
        $data['ruangan'] = ['kode_ruangan' => $data['container']['kode_ruangan'], 'nama_ruangan' => $data['container']['nama_ruangan']];
        
        // Filter barang: hanya yang ada di container ini
        $data['items'] = $barangContainerModel->getItemsByContainer($id);
        // Rename keys to match laporan.php expected format if needed
        // getItemsByContainer returns fields like id_barang, nama_barang, kondisi_baik
        
        $data['id_container'] = $id;
        
        $this->views('public/templates/header', $data);
        $this->views('public/home/laporan', $data);
    }
}