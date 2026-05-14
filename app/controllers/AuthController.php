<?php
class AuthController extends Controller {
    
    public function index() {
        // Jika sudah login, redirect sesuai role
        if(Session::isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }
        
        $data['judul'] = "Login";
        $this->views('public/templates/header', $data);
        $this->views('public/login/index');
    }
    
    public function authenticate() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if(empty($username) || empty($password)) {
            Session::setFlash('error', 'Username dan password harus diisi');
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        $userModel = $this->models('User_model');
        $user = $userModel->getUserByUsername($username);

        if(!$user) {
            Session::setFlash('error', 'Username tidak ditemukan');
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        // Cek password 
        $isValid = false;
        
        // Cek plain text dulu
        if($user['password'] === $password) {
            $isValid = true;
        }
        // Cek dengan hash 
        elseif(password_verify($password, $user['password'])) {
            $isValid = true;
        }
        
        if($isValid) {
            // Login sukses
            unset($user['password']);
            Session::set('user', $user);
            
            $this->redirectBasedOnRole();
        } else {
            Session::setFlash('error', 'Password salah');
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
    }
    
    public function logout() {
        Session::destroy();
        header('Location: ' . BASEURL . 'index.php?url=Home');
        exit;
    }
    
    private function redirectBasedOnRole() {
        $user = Session::user();
        
        if(!$user) {
            header('Location: ' . BASEURL . 'index.php?url=AuthController');
            exit;
        }
        
        switch($user['role']) {
            case 'Admin':
                header('Location: ' . BASEURL . 'index.php?url=dashboard');
                break;
            case 'Ketua kelas':
                // Ketua kelas selalu diarahkan ke ruangan miliknya sendiri
                $kode_ruangan = $user['kode_ruangan'];
                header('Location: ' . BASEURL . 'index.php?url=Home/index/' . $kode_ruangan);
                break;
            case 'OB':
                // OB bisa diarahkan ke ruangan terakhir yang dilihat (misal scan QR)
                $last_room = Session::get('last_viewed_room');
                if ($last_room) {
                    $kode_ruangan = $last_room;
                    Session::remove('last_viewed_room');
                } else {
                    $kode_ruangan = $user['kode_ruangan'];
                }
                
                // Jika OB tidak punya ruangan default dan tidak ada last_room
                if (empty($kode_ruangan)) {
                    $ruanganModel = $this->models('Ruangan_model');
                    $allRuangan = $ruanganModel->getAllRuangan();
                    if (!empty($allRuangan)) {
                        $kode_ruangan = $allRuangan[0]['kode_ruangan'];
                    } else {
                        Session::setFlash('error', 'Tidak ada data ruangan tersedia.');
                        header('Location: ' . BASEURL . 'index.php?url=AuthController');
                        exit;
                    }
                }
                
                header('Location: ' . BASEURL . 'index.php?url=Home/index/' . $kode_ruangan);
                break;
            default:
                header('Location: ' . BASEURL . 'index.php?url=AuthController');
        }
        exit;
    }
}