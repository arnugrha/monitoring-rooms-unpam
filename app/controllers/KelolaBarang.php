<?php
  class KelolaBarang extends Controller {
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
      $data['judul'] = 'Kelola Barang';
      $data['barang'] = $this->models('Barang_model')->getAllBarang();
      $data['totalBarang'] = $this->models('Barang_model')->getTotalBarang();
      $data['totalBaik'] = $this->models('Barang_model')->getTotalBaik();
      $data['totalRusak'] = $this->models('Barang_model')->getTotalRusak();
      $data['kategori'] = $this->models('Barang_model')->getAllKategori();
      $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
      
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/kelolaBarang/index', $data);
      $this->views('admin/templates/footer');
    }

    public function tambah()
    {
      $data['judul'] = 'Tambah Data Barang';
      $data['kategori'] = $this->models('Barang_model')->getAllKategori();
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/kelolaBarang/tambah', $data);
      $this->views('admin/templates/footer');
    }

    public function prosesTambah()
    {
      if ($this->models('Barang_model')->getBarangByNama($_POST['nama_barang'])) {
        Session::setFlash('error', 'Nama barang sudah ada dalam sistem!');
        header('Location: ' . BASEURL . 'kelolaBarang/tambah');
        exit;
      }

      if ($this->models('Barang_model')->tambahDataBarang($_POST) > 0) {
        Session::setFlash('success', 'Barang berhasil ditambahkan');
        header('Location: ' . BASEURL . 'kelolaBarang');
        exit;
      }
    }

    public function hapus($id)
    {
      if ($this->models('Barang_model')->hapusDataBarang($id) > 0) {
        Session::setFlash('success', 'Barang berhasil dihapus');
        header('Location: ' . BASEURL . 'kelolaBarang');
        exit;
      }
    }

    public function edit($id)
    {
      $data['judul'] = 'Edit Data Barang';
      $data['barang'] = $this->models('Barang_model')->getBarangById($id);
      $data['kategori'] = $this->models('Barang_model')->getAllKategori();
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/kelolaBarang/edit', $data);
      $this->views('admin/templates/footer');
    }

    public function prosesUbah()
    {
      $existing = $this->models('Barang_model')->getBarangByNama($_POST['nama_barang']);
      if ($existing && $existing['id_barang'] != $_POST['id_barang']) {
        Session::setFlash('error', 'Nama barang tersebut sudah digunakan oleh barang lain!');
        header('Location: ' . BASEURL . 'kelolaBarang/edit/' . $_POST['id_barang']);
        exit;
      }

      if ($this->models('Barang_model')->ubahDataBarang($_POST) > 0) {
        Session::setFlash('success', 'Barang berhasil diubah');
        header('Location: ' . BASEURL . 'kelolaBarang');
        exit;
      }
    }

    public function tambahKategori()
    {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($this->models('Barang_model')->tambahKategori($_POST['nama_kategori']) > 0) {
          header('Location: ' . BASEURL . 'kelolaBarang?success=Kategori berhasil ditambahkan');
          exit;
        }
      }
    }

    public function hapusKategori($id)
    {
      if ($this->models('Barang_model')->hapusKategori($id) > 0) {
        header('Location: ' . BASEURL . 'kelolaBarang?success=Kategori berhasil dihapus');
        exit;
      }
    }

    public function prosesUbahKategori()
    {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($this->models('Barang_model')->ubahKategori($_POST) > 0) {
          header('Location: ' . BASEURL . 'kelolaBarang?success=Kategori berhasil diubah');
          exit;
        }
      }
    }
  }