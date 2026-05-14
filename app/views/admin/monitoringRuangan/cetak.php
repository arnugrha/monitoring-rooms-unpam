<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 40px;
            color: #1e293b;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .info-box {
            font-size: 14px;
        }
        .info-box span {
            font-weight: bold;
            color: #334155;
            display: block;
            margin-bottom: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 15px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: 700; }
        
        .badge {
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-success { background-color: #f0fdf4; color: #166534; }
        .badge-danger { background-color: #fef2f2; color: #991b1b; }

        .footer-sign {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
        }
        .signature {
            text-align: center;
            width: 200px;
        }
        .signature .date {
            margin-bottom: 60px;
            font-size: 13px;
        }
        .signature .name {
            border-top: 1px solid #334155;
            padding-top: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            @page { margin: 2cm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Inventaris Ruangan</h1>
        <p>Sistem Monitoring Inventaris Ruangan - SMK Teratai Putih Global 2 Bekasi</p>
    </div>

    <div class="info-section">
        <div class="info-box">
            <span>Kode Ruangan:</span>
            <?= $data['ruangan']['kode_ruangan']; ?>
        </div>
        <div class="info-box">
            <span>Nama Ruangan:</span>
            <?= $data['ruangan']['nama_ruangan']; ?>
        </div>
        <div class="info-box">
            <span>Tanggal Cetak:</span>
            <?= date('d F Y'); ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="50" class="text-center">No</th>
                <th>Nama Barang</th>
                <th width="120" class="text-center">Total Barang</th>
                <th width="100" class="text-center">Baik</th>
                <th width="100" class="text-center">Rusak</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach($data['barang_ruangan'] as $barang) : ?>
            <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td class="font-bold"><?= $barang['nama_barang']; ?></td>
                <td class="text-center"><?= $barang['total_barang']; ?></td>
                <td class="text-center">
                    <span class="badge badge-success"><?= $barang['kondisi_baik']; ?></span>
                </td>
                <td class="text-center">
                    <span class="badge badge-danger"><?= $barang['kondisi_rusak']; ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer-sign">
        <div class="signature">
            <div class="date">Bekasi, <?= date('d F Y'); ?></div>
            <div class="name">Petugas Inventaris</div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            // window.onafterprint = function() {
            //     window.close();
            // };
        }
    </script>
</body>
</html>
