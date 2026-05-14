<?php
  class Dashboard extends Controller {

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
      $data['judul'] = 'Dashboard';
      
      // Load Models
      $barangModel = $this->models('Barang_model');
      $laporanModel = $this->models('Laporan_model');
      $ruanganModel = $this->models('Ruangan_model');

      // Fetch Stats
      $data['total_barang_baik'] = $barangModel->getTotalBaik();
      $data['total_laporan'] = $laporanModel->getTotalLaporan();
      $data['laporan_hari_ini'] = $laporanModel->getLaporanHariIni();
      $data['total_barang_rusak'] = $barangModel->getTotalRusak();
      $data['total_ruangan'] = $ruanganModel->getTotalRuangan();
      
      // Fetch Chart Data (Monthly Reports)
      $data['monthly_reports'] = $laporanModel->getMonthlyReportCounts();
      
      // Fetch Recent Activity
      $data['recent_activities'] = $laporanModel->getRecentActivity();

      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/dashboard/index', $data);
      $this->views('admin/templates/footer');
    }

    public function ketua() {
        RoleMiddleware::handle('Ketua kelas');
        $data['judul'] = 'Ketua Kelas';
        $this->views('public/home/index');
        $this->views('public/templates/header', $data);
        $this->views('public/templates/footer');
        $this->views('public/templates/sidebar');
        $this->views('public/templates/navbar');
        $this->views('public/home/laporan');

    }
    

    public function ob() {
        RoleMiddleware::handle('OB');
        $data['judul'] = 'OB  ';
        $this->views('public/home/index');
        $this->views('public/templates/header', $data);
        $this->views('public/templates/footer');
        $this->views('public/templates/sidebar');
        $this->views('public/templates/navbar');
        $this->views('public/home/laporan');
    }
  }
