<?php

class HistoryExport extends Controller {
    public function index() {
        if(Session::isLoggedIn() && Session::role() !== 'Admin'):
            header("Location: " . BASEURL);
            exit;
        endif;

        $data = [
            'judul' => 'History Export - Admin',
            'history' => $this->models('HistoryExport_model')->getAllExports()
        ];

        $this->views('admin/templates/header', $data);
        $this->views('admin/templates/sidebar', $data);
        $this->views('admin/templates/navbar');
        $this->views('admin/historyExport/index', $data);
        $this->views('admin/templates/footer', $data);
    }
}