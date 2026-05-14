<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: white;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .container-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .qr-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            page-break-inside: avoid;
            background: #fff;
        }
        .qr-image {
            width: 180px;
            height: 180px;
            margin-bottom: 15px;
        }
        .container-name {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 5px 0;
            color: #0f172a;
            text-transform: uppercase;
        }
        .room-info {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .url-box {
            font-family: monospace;
            font-size: 9px;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 4px;
            color: #334155;
            word-break: break-all;
            max-width: 100%;
        }
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Cetak Halaman</button>

    <div class="container-wrapper">
        <?php 
        $items = isset($data['containers']) ? $data['containers'] : [$data['container']];
        foreach($items as $c) : 
        ?>
            <div class="qr-card">
                <div class="room-info"><?= $c['nama_ruangan']; ?> - <?= $c['kode_ruangan']; ?></div>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= urlencode($c['qr_data']); ?>" alt="QR Code" class="qr-image">
                <div class="container-name"><?= $c['nama_container']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
