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
            header('Location: ' . BASEURL . 'Users');
            exit;
        }
    }

    public function prosesTambah()
    {
        if ($this->models('User_model')->tambahDataUser($_POST) > 0) {
            header('Location: ' . BASEURL . 'Users');
            exit;
        }
    }

    public function prosesUbah()
    {
        if($this->models('User_model')->ubahDataUser($_POST) >= 0) {
            header('Location:' . BASEURL . 'Users');
            exit;
        }
    }
}