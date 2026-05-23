<?php 
class Users extends Controller {
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
        
        $data['judul'] = 'Kelola Users';
        $data['users'] = $this->models('User_model')->getAllUser();
        $data['totalUsers'] = $this->models('User_model')->getUsersTotal();
        $data['totalAdmin'] = $this->models('User_model')->getTotalAdmin();
        $data['totalKetuaKelas'] = $this->models('User_model')->getTotalKetuaKelas();
        $data['totalOb'] = $this->models('User_model')->getTotalOb();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/users/index', $data);
        $this->views('admin/templates/footer');
    }
    
    public function tambah()
    {
        $data['judul'] = 'Tambah User';
        $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/users/tambah', $data);
        $this->views('admin/templates/footer');
    }
    
    public function edit($id)
    {
        $data['judul'] = 'Edit User';
        $data['user'] = $this->models('User_model')->getUserById($id);
        $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/users/edit', $data);
        $this->views('admin/templates/footer');
    }
    
    public function hapus($id)
    {
        if($this->models('User_model')->hapusDataUser($id) > 0) {
            Session::setFlash('success', 'Data user berhasil dihapus.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        } else {
            Session::setFlash('error', 'Gagal menghapus data user.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        }
    }

    public function prosesTambah()
    {
        if ($this->models('User_model')->tambahDataUser($_POST) > 0) {
            Session::setFlash('success', 'Data user berhasil ditambahkan.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        } else {
            Session::setFlash('error', 'Gagal menambahkan data user.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        }
    }

    public function prosesUbah()
    {
        if($this->models('User_model')->ubahDataUser($_POST) >= 0) {
            Session::setFlash('success', 'Data user berhasil diperbarui.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        } else {
            Session::setFlash('error', 'Gagal memperbarui data user.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        }
    }

    public function export()
    {
        $data['users'] = $this->models('User_model')->getAllUser(); // Get all active users
        
        $filename = "Laporan_Daftar_Users_" . date('Ymd_His') . ".xls";
        
        // Capture output
        ob_start();
        $this->views('admin/users/export', $data);
        $content = ob_get_clean();
        
        // Save to server
        if (!is_dir('export')) {
            mkdir('export', 0777, true);
        }
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
            
            // Clean headers (remove BOM if any, trim and convert to uppercase for robust check)
            if ($headers) {
                // Remove BOM from first element if present
                $headers[0] = preg_replace('/[\x{00EF}\x{00BB}\x{00BF}]/u', '', $headers[0]);
                $headers = array_map('trim', $headers);
            }

            if (!$headers || strcasecmp($headers[0], 'USERNAME') !== 0) {
                fclose($handle);
                Session::setFlash('error', 'Format CSV tidak valid. Kolom pertama harus USERNAME.');
                header('Location: ' . BASEURL . 'Users');
                exit;
            }
            
            $success_count = 0;
            $userModel = $this->models('User_model');
            
            while (($row = fgetcsv($handle, 4000, ",")) !== FALSE) {
                // Ensure row has enough columns
                if (count($row) < 1) continue;
                
                $username = trim($row[0] ?? '');
                $nama_lengkap = trim($row[1] ?? '');
                $kode_kelas = trim($row[2] ?? '');
                $password = trim($row[3] ?? '');
                $role = trim($row[4] ?? '');
                $kode_ruangan = trim($row[5] ?? '');

                if (empty($username)) continue;

                // Validate role - if empty or invalid, default to 'OB'
                if (strcasecmp($role, 'Admin') === 0) {
                    $role = 'Admin';
                } elseif (strcasecmp($role, 'Ketua kelas') === 0 || strcasecmp($role, 'Ketua_kelas') === 0) {
                    $role = 'Ketua kelas';
                } else {
                    $role = 'OB'; // Default role
                }

                // If password is empty, let's set a default or use username
                if (empty($password)) {
                    // Check if user already exists, if so keep password, else default password
                    $existing = $userModel->getUserByUsername($username);
                    if ($existing) {
                        $password = ''; // Keep old password in update
                    } else {
                        $password = '123456'; // Default password for new users
                    }
                }

                // If kode_ruangan is empty or '-' or 'null', make it empty
                if (empty($kode_ruangan) || $kode_ruangan === '-' || strcasecmp($kode_ruangan, 'null') === 0) {
                    $kode_ruangan = '';
                }

                $userModel->importUserCSV($username, $nama_lengkap, $kode_kelas, $password, $role, $kode_ruangan);
                $success_count++;
            }
            fclose($handle);
            Session::setFlash('success', $success_count . ' Data user berhasil diimport.');
            header('Location: ' . BASEURL . 'Users');
            exit;
        }
      }
      Session::setFlash('error', 'Gagal import data user.');
      header('Location: ' . BASEURL . 'Users');
      exit;
    }
}