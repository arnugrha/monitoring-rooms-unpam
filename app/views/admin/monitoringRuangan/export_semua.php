<?php
// export_semua.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Semua Inventaris Ruangan</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>RUANG</th>
                <?php 
                $i = 1;
                foreach($data['items'] as $item) : 
                ?>
                    <th><?= $item['nama_barang']; ?></th>
                    <th>Kondisi</th>
                <?php 
                $i++;
                endforeach; 
                ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['rooms'] as $room) : ?>
            <tr>
                <td><?= $room['kode_ruangan']; ?></td>
                <?php foreach($data['items'] as $item) : 
                    $id_barang = $item['id_barang'];
                    $detail = $data['matrix'][$room['kode_ruangan']][$id_barang] ?? null;
                    
                    $total = "";
                    $kondisi = "";
                    
                    if ($detail) {
                        $total = $detail['total_barang'];
                        if ($detail['kondisi_rusak'] == 0 && $detail['kondisi_baik'] == $detail['total_barang']) {
                            $kondisi = "Baik semua";
                        } elseif ($detail['kondisi_rusak'] > 0) {
                            $kondisi = "Rusak " . $detail['kondisi_rusak'];
                        } else {
                            $kondisi = "Baik"; // Fallback
                        }
                    }
                ?>
                    <td><?= $total; ?></td>
                    <td><?= $kondisi; ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
