<?php
  class User_model {
    private $db;
    private $table = "user";

    public function __construct()
    {
      $this->db = new Database();
    }

    public function getAllUser()
    {
      $this->db->query("SELECT 
                          u.id_user,
                          u.username, 
                          u.nama_lengkap, 
                          u.role, 
                          u.kode_kelas,
                          r.kode_ruangan
                        FROM user u
                        LEFT JOIN ruangan r ON u.kode_ruangan = r.kode_ruangan
                        WHERE u.delete_at = 1;
                      ");
      return $this->db->resultSet();
    }

    public function getUserById($id)
    {
      $this->db->query("SELECT u.*, r.kode_ruangan FROM " . $this->table . " u LEFT JOIN ruangan r ON u.kode_ruangan = r.kode_ruangan WHERE u.id_user = :id AND u.delete_at = 1");
      $this->db->bind('id', $id);
      return $this->db->single();
    }

    public function getUsersTotal()
    {
      $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE delete_at = 1");
      $result = $this->db->single();
      return $result['total'];
    }

    public function getTotalAdmin()
    {
      $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE role= :role AND delete_at = 1");
      $this->db->bind('role', 'Admin');
      $result = $this->db->single();
      return $result['total'];
    }

    public function getTotalKetuaKelas()
    {
      $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE role= :role AND delete_at = 1");
      $this->db->bind('role', 'Ketua kelas');
      $result = $this->db->single();
      return $result['total'];
    }

    public function getTotalOb()
    {
      $this->db->query("SELECT COUNT(*) as total FROM " . $this->table . " WHERE role= :role AND delete_at = 1");
      $this->db->bind('role', 'OB');
      $result = $this->db->single();
      return $result['total'];
    }

    public function hapusDataUser($id)
    {
      $this->db->query("UPDATE " . $this->table . " SET delete_at = 0 WHERE id_user = :id");
      $this->db->bind('id', $id);
      $this->db->execute();
      return 1;
    }

    public function tambahDataUser($data)
    {
      $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, kode_kelas, role, kode_ruangan) 
                VALUES (:username, :password, :nama_lengkap, :kode_kelas, :role, :kode_ruangan)";
      
      $this->db->query($query);
      $this->db->bind('username', $data['username']);
      $this->db->bind('password', $data['password']);
      $this->db->bind('nama_lengkap', $data['nama_lengkap']);
      $this->db->bind('role', $data['role']);

      // Setup logic for optional/role-specific fields
      $kode_kelas = !empty($data['kode_kelas']) ? $data['kode_kelas'] : '-';
      $kode_ruangan = null;
      if ($data['role'] === 'Ketua kelas') {
          $kode_ruangan = !empty($data['kode_ruangan']) ? $data['kode_ruangan'] : null;
      }
      $this->db->bind('kode_kelas', $kode_kelas);
      $this->db->bind('kode_ruangan', $kode_ruangan);

      $this->db->execute();

      return 1;
    }

    public function ubahDataUser($data)
    {
      if (empty($data['password'])) {
        $query = "UPDATE " . $this->table . " SET 
                  username = :username,
                  nama_lengkap = :nama_lengkap,
                  role = :role,
                  kode_kelas = :kode_kelas,
                  kode_ruangan = :kode_ruangan
                  WHERE id_user = :id_user";
      } else {
        $query = "UPDATE " . $this->table . " SET 
                  username = :username,
                  password = :password,
                  nama_lengkap = :nama_lengkap,
                  role = :role,
                  kode_kelas = :kode_kelas,
                  kode_ruangan = :kode_ruangan
                  WHERE id_user = :id_user";
      }
      
      $this->db->query($query);
      $this->db->bind('username', $data['username']);
      if (!empty($data['password'])) {
        $this->db->bind('password', $data['password']);
      }
      $this->db->bind('nama_lengkap', $data['nama_lengkap']);
      $this->db->bind('role', $data['role']);
      $this->db->bind('id_user', $data['id_user']);

      // Setup logic for optional/role-specific fields
      $kode_kelas = !empty($data['kode_kelas']) ? $data['kode_kelas'] : '-';
      $kode_ruangan = null;
      if ($data['role'] === 'Ketua kelas') {
          $kode_ruangan = !empty($data['kode_ruangan']) ? $data['kode_ruangan'] : null;
      }
      $this->db->bind('kode_kelas', $kode_kelas);
      $this->db->bind('kode_ruangan', $kode_ruangan);

      $this->db->execute();

      return 1;
    }

    // Cari user berdasarkan username (NIM)
    public function getUserByUsername($username) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE username = :username AND delete_at = 1");
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function importUserCSV($username, $nama_lengkap, $kode_kelas, $password, $role, $kode_ruangan) {
      // Check if user already exists (active or soft-deleted)
      $this->db->query("SELECT * FROM " . $this->table . " WHERE username = :username");
      $this->db->bind('username', $username);
      $existing = $this->db->single();

      // Setup logic for optional/role-specific fields
      $final_kode_kelas = !empty($kode_kelas) ? $kode_kelas : '-';
      $final_kode_ruangan = null;
      if ($role === 'Ketua kelas') {
          $final_kode_ruangan = !empty($kode_ruangan) ? $kode_ruangan : null;
      }

      if ($existing) {
          // Update existing user, reactivate if deleted (delete_at = 1)
          $query = "UPDATE " . $this->table . " SET 
                    nama_lengkap = :nama_lengkap,
                    kode_kelas = :kode_kelas,
                    role = :role,
                    kode_ruangan = :kode_ruangan,
                    delete_at = 1";
          
          if (!empty($password)) {
              $query .= ", password = :password";
          }
          $query .= " WHERE username = :username";

          $this->db->query($query);
          $this->db->bind('nama_lengkap', $nama_lengkap);
          $this->db->bind('kode_kelas', $final_kode_kelas);
          $this->db->bind('role', $role);
          $this->db->bind('kode_ruangan', $final_kode_ruangan);
          $this->db->bind('username', $username);
          if (!empty($password)) {
              $this->db->bind('password', $password);
          }
          $this->db->execute();
      } else {
          // Insert new user
          $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, kode_kelas, role, kode_ruangan, delete_at) 
                    VALUES (:username, :password, :nama_lengkap, :kode_kelas, :role, :kode_ruangan, 1)";
          $this->db->query($query);
          $this->db->bind('username', $username);
          $this->db->bind('password', $password);
          $this->db->bind('nama_lengkap', $nama_lengkap);
          $this->db->bind('kode_kelas', $final_kode_kelas);
          $this->db->bind('role', $role);
          $this->db->bind('kode_ruangan', $final_kode_ruangan);
          $this->db->execute();
      }
      return true;
    }

  }