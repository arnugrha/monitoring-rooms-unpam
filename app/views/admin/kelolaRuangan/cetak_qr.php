<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 20px;
            background-color: #fff;
        }
        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            justify-items: center;
        }
        .qr-item {
            text-align: center;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            width: 200px;
            height: 200px;
            background-color: white;
        }
        .qr-title {
            font-weight: 800;
            font-size: 14px;
            color: #1e293b;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .qr-image {
            width: 140px;
            height: 140px;
            display: block;
            margin: 0 auto;
        }
        .qr-code-text {
            font-size: 10px;
            color: #64748b;
            margin-top: 8px;
            word-break: break-all;
        }

        @media print {
            body { padding: 0; }
            .qr-item {
                border: 1px solid #cbd5e1;
                break-inside: avoid;
            }
            .no-print { display: none; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #005dac; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
            Cetak Sekarang
        </button>
        <p style="font-size: 12px; color: #64748b; margin-top: 8px;">Tips: Atur layout ke Landscape jika diperlukan di pengaturan print browser.</p>
    </div>

    <div class="qr-grid">
        <?php foreach ($data['ruangan'] as $row) : ?>
            <?php if (!empty($row['qr_data'])) : ?>
                <div class="qr-item">
                    <div class="qr-title">Ruangan <?= $row['kode_ruangan'] ?></div>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($row['qr_data']) ?>" 
                         alt="QR Code <?= $row['kode_ruangan'] ?>"
                         class="qr-image">
                    <div class="qr-code-text"><?= $row['nama_ruangan'] ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 1000); // Give time for images to load
        }
    </script>
</body>
</html>
