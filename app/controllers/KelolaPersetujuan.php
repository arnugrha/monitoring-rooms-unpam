<?php
class KelolaPersetujuan extends Controller {
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
        $data['judul'] = 'Persetujuan Barang';
        $data['pengajuan'] = $this->models('Monitoring_ruangan_model')->getAllPengajuan();
        
        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar');
        $this->views('admin/templates/navbar');
        $this->views('admin/persetujuanBarang/index', $data);
        $this->views('admin/templates/footer');
    }

    public function setujui($id)
    {
        if ($this->models('Monitoring_ruangan_model')->updateStatusPengajuan($id, 'disetujui') > 0) {
            Session::setFlash('success', 'Pengajuan barang berhasil disetujui');
            header('Location: ' . BASEURL . 'KelolaPersetujuan');
            exit;
        } else {
            Session::setFlash('error', 'Gagal menyetujui pengajuan');
            header('Location: ' . BASEURL . 'KelolaPersetujuan');
            exit;
        }
    }

    public function tolak($id)
    {
        if ($this->models('Monitoring_ruangan_model')->updateStatusPengajuan($id, 'ditolak') > 0) {
            Session::setFlash('success', 'Pengajuan barang berhasil ditolak');
            header('Location: ' . BASEURL . 'KelolaPersetujuan');
            exit;
        } else {
            Session::setFlash('error', 'Gagal menolak pengajuan');
            header('Location: ' . BASEURL . 'KelolaPersetujuan');
            exit;
        }
    }
}
