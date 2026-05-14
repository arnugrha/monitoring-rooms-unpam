<!DOCTYPE html>
<html>
<head>
    <title>Export Data Inventaris Ruangan <?= $data['ruangan']['kode_ruangan']; ?></title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="5" style="font-size: 16px; font-weight: bold;">LAPORAN INVENTARIS RUANGAN <?= $data['ruangan']['kode_ruangan']; ?></th>
            </tr>
            <tr>
                <th colspan="5" style="font-size: 14px; font-weight: bold;"><?= $data['ruangan']['nama_ruangan']; ?></th>
            </tr>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Total Barang</th>
                <th>Kondisi Baik</th>
                <th>Kondisi Rusak</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($data['barang_ruangan'] as $barang) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $barang['nama_barang']; ?></td>
                <td><?= $barang['total_barang']; ?></td>
                <td><?= $barang['kondisi_baik']; ?></td>
                <td><?= $barang['kondisi_rusak']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
