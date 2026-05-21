<?php
  class Container extends Controller
  {
    public function index() {
      $data['judul'] = 'Kelola Container';
      $data['containers'] = $this->models('Container_model')->getAllContainer();
      
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/container/index', $data);
      $this->views('admin/templates/footer');
    }

    public function tambah() {
      $data['judul'] = 'Tambah Container';
      $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
      $data['barang'] = $this->models('Barang_model')->getBarangByKategori('Container');
      
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/container/tambah', $data);
      $this->views('admin/templates/footer');
    }

    public function edit($id) {
      $data['judul'] = 'Edit Container';
      $data['container'] = $this->models('Container_model')->getContainerById($id);
      $data['ruangan'] = $this->models('Ruangan_model')->getAllRuangan();
      $data['barang'] = $this->models('Barang_model')->getBarangByKategori('Container');
      
      $this->views('admin/templates/header', $data);
      $this->views('admin/templates/sidebar');
      $this->views('admin/templates/navbar');
      $this->views('admin/container/edit', $data);
      $this->views('admin/templates/footer');
    }

    public function prosesEdit() {
      $_POST['id_user'] = Session::user()['id_user'];
      if ($this->models('Container_model')->ubahDataContainer($_POST) > 0) {
        Session::setFlash('success', 'Container berhasil diubah');
        header('Location: ' . BASEURL . 'container');
        exit;
      } else {
        Session::setFlash('error', 'Gagal mengubah container');
        header('Location: ' . BASEURL . 'container');
        exit;
      }
    }

    public function prosesTambah() {
      $_POST['id_user'] = Session::user()['id_user'];
      
      $id = $this->models('Container_model')->tambahDataContainer($_POST);
      
      if($id) {
        Session::setFlash('success', 'Container berhasil ditambahkan');
        if (isset($_POST['submit_action']) && $_POST['submit_action'] === 'save_and_add') {
          header('Location: ' . BASEURL . 'index.php?url=BarangContainer/tambah/' . $id);
        } else {
          header('Location: ' . BASEURL . 'index.php?url=container/index');
        }
        exit;
      } else {
        Session::setFlash('error', 'Gagal menambahkan container');
        header('Location: ' . BASEURL . 'index.php?url=container/index');
        exit;
      }
    }

    public function hapus($id) {
      if($this->models('Container_model')->hapusDataContainer($id) > 0) {
        Session::setFlash('success', 'Container berhasil dihapus');
        header('Location: ' . BASEURL . 'index.php?url=container/index');
        exit;
      } else {
        Session::setFlash('error', 'Gagal menghapus container');
        header('Location: ' . BASEURL . 'index.php?url=container/index');
        exit;
      }
    }

    public function cetak_qr($id) {
        $data['container'] = $this->models('Container_model')->getContainerDetailById($id);
        if (!$data['container']) {
            Session::setFlash('error', 'Data tidak ditemukan');
            header('Location: ' . BASEURL . 'index.php?url=container/index');
            exit;
        }
        $data['judul'] = 'Cetak QR Container - ' . $data['container']['nama_container'];
        $this->views('admin/container/cetak_qr', $data);
    }

    public function cetak_semua_qr() {
        $data['containers'] = $this->models('Container_model')->getAllContainer();
        $data['judul'] = 'Cetak Semua QR Container';
        $this->views('admin/container/cetak_qr', $data);
    }
  }
