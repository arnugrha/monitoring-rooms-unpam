<?php
class BarangContainer extends Controller {
    private $db;
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
        $data['judul'] = 'Monitoring Barang Container';
        $data['containers'] = $this->models('BarangContainer_model')->getAllContainerWithItems();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/barangContainer/index', $data);
        $this->views('admin/templates/footer');
    }

    public function tambah($preselected_container_id = null)
    {
        $data['judul'] = 'Tambah Barang Container';
        $data['containers'] = $this->models('Container_model')->getAllContainer(); // Master data container
        
        // Support both path parameter and query string parameter
        if (empty($preselected_container_id) && isset($_GET['preselected_container_id'])) {
            $preselected_container_id = $_GET['preselected_container_id'];
        }
        
        $data['preselected_container_id'] = $preselected_container_id;
        $data['barang'] = $this->models('Barang_model')->getAllBarang(); // All items for selection
        $data['kategori'] = $this->models('Barang_model')->getAllKategori();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/barangContainer/tambah', $data);
        $this->views('admin/templates/footer');
    }

    public function prosesTambah()
    {
        if ($this->models('BarangContainer_model')->tambahData($_POST) > 0) {
            Session::setFlash('success', 'Barang berhasil ditambahkan ke container');
            header('Location: ' . BASEURL . 'BarangContainer');
            exit;
        } else {
            Session::setFlash('error', 'Gagal menambahkan barang ke container');
            header('Location: ' . BASEURL . 'BarangContainer');
            exit;
        }
    }

    public function edit($id)
    {
        $data['judul'] = 'Edit Isi Container';
        $data['container_info'] = $this->models('Container_model')->getContainerDetailById($id);
        $data['barang'] = $this->models('Barang_model')->getAllBarang();
        $data['kategori'] = $this->models('Barang_model')->getAllKategori();
        $data['current_items'] = $this->models('BarangContainer_model')->getItemsByContainer($id);
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/barangContainer/edit', $data);
        $this->views('admin/templates/footer');
    }

    public function prosesEdit()
    {
        if ($this->models('BarangContainer_model')->ubahData($_POST) > 0) {
            Session::setFlash('success', 'Isi container berhasil diperbarui');
            header('Location: ' . BASEURL . 'BarangContainer');
            exit;
        } else {
            Session::setFlash('error', 'Gagal memperbarui isi container');
            header('Location: ' . BASEURL . 'BarangContainer');
            exit;
        }
    }

    public function detail($id)
    {
        $data['judul'] = 'Detail Isi Container';
        $data['items'] = $this->models('BarangContainer_model')->getItemsByContainer($id);
        
        // Get container info for header
        $this->db = new Database(); // Temporary for simple fetch or use another model
        $this->db->query("SELECT c.*, b.nama_barang as nama_container, r.nama_ruangan 
                         FROM container c 
                         JOIN barang b ON c.id_barang = b.id_barang 
                         JOIN ruangan r ON c.kode_ruangan = r.kode_ruangan 
                         WHERE c.id_container = :id");
        $this->db->bind('id', $id);
        $data['container_info'] = $this->db->single();

        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/barangContainer/detail', $data);
        $this->views('admin/templates/footer');
    }

    public function hapus($id)
    {
        if ($this->models('BarangContainer_model')->hapusData($id) > 0) {
            Session::setFlash('success', 'Isi container berhasil dikosongkan');
            header('Location: ' . BASEURL . 'BarangContainer');
            exit;
        } else {
            Session::setFlash('error', 'Gagal mengosongkan container');
            header('Location: ' . BASEURL . 'BarangContainer');
            exit;
        }
    }
}
