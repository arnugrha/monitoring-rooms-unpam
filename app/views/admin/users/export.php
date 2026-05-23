<?php
// export.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Data Users</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>USERNAME</th>
                <th>NAMA_LENGKAP</th>
                <th>KODE_KELAS</th>
                <th>ROLE</th>
                <th>KODE_RUANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach($data['users'] as $user) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['nama_lengkap']; ?></td>
                <td><?= $user['kode_kelas']; ?></td>
                <td><?= $user['role']; ?></td>
                <td><?= (is_null($user['kode_ruangan'])) ? '-' : $user['kode_ruangan']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
