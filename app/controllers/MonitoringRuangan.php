<?php 
  class MonitoringRuangan extends Controller {
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
      $status = $_GET['status'] ?? null;
      $data['judul'] = 'Monitoring Ruangan';
      $data['status_filter'] = $status;
      $data['dataBarangRuangan'] = $this->models('Monitoring_ruangan_model')->getAllRuangan($status);
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/monitoringRuangan/index', $data);
      $this->views('admin/templates/footer');
    }

    public function tambah($preselected_kode_ruangan = null) {
      $data['judul'] = 'Tambah Data Barang';
      $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
      
      // Support both route parameter and query string parameter
      if (empty($preselected_kode_ruangan) && isset($_GET['preselected_kode_ruangan'])) {
        $preselected_kode_ruangan = $_GET['preselected_kode_ruangan'];
      }
      
      $data['preselected_kode_ruangan'] = $preselected_kode_ruangan;
      $data['barang'] = $this->models('Barang_model')->getAllBarang();
      $data['kategori'] = $this->models('Barang_model')->getAllKategori();
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/monitoringRuangan/tambah', $data);
      $this->views('admin/templates/footer');
    }

    public function edit($id) {
      $data['judul'] = 'Edit Data Barang Ruangan';
      $data['ruangan_selected'] = $this->models('Ruangan_model')->getRuanganById($id);
      $data['barang_ruangan'] = $this->models('Monitoring_ruangan_model')->getBarangByRuangan($id);
      $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
      $data['barang'] = $this->models('Barang_model')->getAllBarang();
      $data['kategori'] = $this->models('Barang_model')->getAllKategori();
      
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/monitoringRuangan/edit', $data);
      $this->views('admin/templates/footer');
    }

    public function detail($id)
    {
      $data['judul'] = 'Detail Data Barang Ruangan';
      $data['ruangan'] = $this->models('Ruangan_model')->getRuanganById($id);
      $data['barang_ruangan'] = $this->models('Monitoring_ruangan_model')->getDetailBarangByRuangan($id);

      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/monitoringRuangan/detail', $data);
      $this->views('admin/templates/footer');
    }

    public function detailContainer($id)
    {
      $data['judul'] = 'Detail Barang Container';
      $data['container'] = $this->models('Container_model')->getContainerDetailById($id);
      $data['barang_container'] = $this->models('BarangContainer_model')->getItemsByContainer($id);
      $data['ruangan'] = $this->models('Ruangan_model')->getRuanganById($data['container']['kode_ruangan']);

      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/monitoringRuangan/detailContainer', $data);
      $this->views('admin/templates/footer');
    }

    public function export($id)
    {
      $data['ruangan'] = $this->models('Ruangan_model')->getRuanganById($id);
      $data['barang_ruangan'] = $this->models('Monitoring_ruangan_model')->getDetailBarangByRuangan($id);
      
      $filename = "Laporan_Inventaris_Ruangan_" . $data['ruangan']['kode_ruangan'] . "_" . date('Ymd_His') . ".xls";
      
      // Capture output
      ob_start();
      $this->views('admin/monitoringRuangan/export', $data);
      $content = ob_get_clean();
      
      // Save to server
      file_put_contents('export/' . $filename, $content);
      
      // Log to database
      $this->models('HistoryExport_model')->addExport($filename);
      
      // Serve to user
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=" . $filename);
      header("Pragma: no-cache");
      header("Expires: 0");
      echo $content;
      exit;
    }

    public function exportSemua()
    {
      $status = $_GET['status'] ?? null;
      $rooms = $this->models('Monitoring_ruangan_model')->getAllRuangan($status);
      $items = $this->models('Barang_model')->getAllBarang();

      $matrix = [];
      foreach($rooms as $room) {
          $kode = $room['kode_ruangan'];
          $roomDetails = $this->models('Monitoring_ruangan_model')->getDetailBarangByRuangan($kode);
          
          $itemData = [];
          foreach($roomDetails as $detail) {
              $itemData[$detail['id_barang']] = $detail;
          }
          
          $matrix[$kode] = $itemData;
      }
      
      $data['rooms'] = $rooms;
      $data['items'] = $items;
      $data['matrix'] = $matrix;

      $filename = "Laporan_Semua_Inventaris_Ruangan_" . date('Ymd_His') . ".xls";

      // Capture output
      ob_start();
      $this->views('admin/monitoringRuangan/export_semua', $data);
      $content = ob_get_clean();

      // Save to server
      file_put_contents('export/' . $filename, $content);

      // Log to database
      $this->models('HistoryExport_model')->addExport($filename);

      // Serve to user
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=" . $filename);
      header("Pragma: no-cache");
      header("Expires: 0");
      echo $content;
      exit;
    }

    public function importCSV()
    {
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_csv'])) {
        $file = $_FILES['file_csv']['tmp_name'];
        if ($file) {
            $handle = fopen($file, "r");
            $headers = fgetcsv($handle, 4000, ","); // Get header row
            if (!$headers || strcasecmp(trim($headers[0]), 'RUANG') !== 0) {
                fclose($handle);
                header('Location: ' . BASEURL . 'monitoringRuangan?error=Format CSV tidak valid');
                exit;
            }
            
            $success_count = 0;
            
            while (($row = fgetcsv($handle, 4000, ",")) !== FALSE) {
                $kode_ruangan = trim($row[0] ?? '');
                if (empty($kode_ruangan)) continue;

                // Loop through columns in pairs (quantity, condition)
                for ($i = 1; $i < count($headers); $i += 2) {
                    $nama_barang = trim($headers[$i] ?? '');
                    if (empty($nama_barang)) continue;

                    $total_str = trim($row[$i] ?? '');
                    $kondisi_str = trim($row[$i+1] ?? '');
                    
                    if ($total_str === '') continue; // Skip if empty
                    
                    $total_barang = (int)$total_str;

                    // Parse kondisi
                    $kondisi_baik = $total_barang;
                    $kondisi_rusak = 0;

                    if (stripos($kondisi_str, 'Rusak') !== false) {
                        preg_match('/\d+/', $kondisi_str, $matches);
                        if (!empty($matches)) {
                            $kondisi_rusak = (int)$matches[0];
                            $kondisi_baik = max(0, $total_barang - $kondisi_rusak);
                        } else {
                            // If just says 'Rusak' without a number, assume all are broken
                            $kondisi_rusak = $total_barang;
                            $kondisi_baik = 0;
                        }
                    } elseif (stripos($kondisi_str, 'Nyala') !== false) {
                        preg_match('/\d+/', $kondisi_str, $matches);
                        if (!empty($matches)) {
                            $kondisi_baik = (int)$matches[0];
                            $kondisi_rusak = max(0, $total_barang - $kondisi_baik);
                        } else {
                            $kondisi_baik = $total_barang;
                            $kondisi_rusak = 0;
                        }
                    }

                    $this->models('Monitoring_ruangan_model')->importDataBarangCSV($kode_ruangan, $nama_barang, $total_barang, $kondisi_baik, $kondisi_rusak);
                    $success_count++;
                }
            }
            fclose($handle);
            header('Location: ' . BASEURL . 'monitoringRuangan?success=Data berhasil diimport');
            exit;
        }
      }
      header('Location: ' . BASEURL . 'monitoringRuangan?error=Gagal import data');
      exit;
    }

    public function cetak($id)
    {
      $data['judul'] = 'Laporan Inventaris Ruangan ' . $id;
      $data['ruangan'] = $this->models('Ruangan_model')->getRuanganById($id);
      $data['barang_ruangan'] = $this->models('Monitoring_ruangan_model')->getDetailBarangByRuangan($id);

      $this->views('admin/templates/header', $data);
      $this->views('admin/monitoringRuangan/cetak', $data);
    }

    public function simpanUbah() {
      $kode_ruangan = $_POST['kode_ruangan'];
      if ($this->models('Monitoring_ruangan_model')->ubahDataBarangRuangan($_POST) > 0) {
        header('Location: ' . BASEURL . 'MonitoringRuangan/detail/' . $kode_ruangan);
        exit;
      } else {
        // Even if 0 items (all removed), we might want to redirect
        header('Location: ' . BASEURL . 'MonitoringRuangan/detail/' . $kode_ruangan);
        exit;
      }
    }

    public function hapus($id) {
      if ($this->models('Monitoring_ruangan_model')->hapusDataBarangRuangan($id) >= 0) {
        header('Location: ' . BASEURL . 'monitoringRuangan');
        exit;
      }
    }

    public function hapusBarang($kode_ruangan, $id_barang) {
      if ($this->models('Monitoring_ruangan_model')->hapusSatuBarangRuangan($kode_ruangan, $id_barang) >= 0) {
        header('Location: ' . BASEURL . 'MonitoringRuangan/detail/' . $kode_ruangan);
        exit;
      }
    }

    public function simpan() {
      $kode_ruangan = $_POST['kode_ruangan'];
      if ($this->models('Monitoring_ruangan_model')->tambahDataBarangRuangan($_POST) > 0) {
        header('Location: ' . BASEURL . 'MonitoringRuangan/detail/' . $kode_ruangan);
        exit;
      } else {
        header('Location: ' . BASEURL . 'MonitoringRuangan/detail/' . $kode_ruangan);
        exit;
      }
    }
  }