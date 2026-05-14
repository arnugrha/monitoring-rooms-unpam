<body class="bg-surface font-body text-on-surface antialiased min-h-screen pb-12">
<!-- Main Container -->
<main class="max-w-5xl mx-auto px-4 pb-8 pt-4 md:pb-12 md:pt-8 mt-4">
    
    <!-- Logos Section -->
    <div class="flex justify-center md:justify-end items-center mb-4 md:mb-6">
        <div class="flex justify-center items-center gap-2">
            <a href="https://unpam.ac.id/" target="_blank" class="py-2 px-1.5 overflow-hidden bg-white w-14 h-12 rounded-[.6rem] shadow-lg hover:bg-gray-200 hover:scale-110 transition-all duration-500">
                <img src="<?= BASEURL; ?>dist/img/unpam.png" alt="logo unpam" class="w-full h-full">
            </a>
            <a href="" class="py-2 px-1.5 overflow-hidden bg-white w-14 h-12 rounded-[.6rem] shadow-lg hover:bg-gray-200 hover:scale-110 transition-all duration-500">
                <img src="<?= BASEURL; ?>dist/img/sasmita.png" alt="logo unpam" class="w-full h-full">
            </a>
            <a href="https://ftiunpam.com/" target="_blank" class="py-2 px-1.5 overflow-hidden bg-white w-14 h-12 rounded-[.6rem] shadow-lg hover:bg-gray-200 hover:scale-110 transition-all duration-500">
                <img src="<?= BASEURL; ?>dist/img/fti.png" alt="logo unpam" class="w-full h-full">
            </a>
        </div>
    </div>
    
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <span class="inline-block px-3 py-1 bg-primary text-on-primary text-[10px] font-bold rounded-full mb-3 tracking-wider uppercase">Active Container</span>
            <h1 class="font-headline text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight mb-[0.2rem]">
                <?= $data['container']['nama_container']; ?>
            </h1>
            <p class="text-xs text-slate-500 font-medium mb-2">Unit ID: #<?= str_pad($data['container']['id_container'], 4, '0', STR_PAD_LEFT); ?></p>
            <div class="flex items-center gap-2 text-secondary text-sm md:text-base font-medium">
                <span class="material-symbols-outlined text-base">meeting_room</span>
                <span>Terletak di <?= $data['container']['nama_ruangan']; ?> (<?= $data['container']['kode_ruangan']; ?>)</span>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?= BASEURL ?>index.php?url=Home/laporan_container/<?= $data['container']['id_container']; ?>" class="flex items-center gap-2 bg-[#ffcc00] hover:bg-[#e6b800] text-black font-semibold py-3 px-6 rounded-full shadow-md shadow-yellow-500/20 transition-all active:scale-95 whitespace-nowrap">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                Buat Laporan
            </a>
            <a href="<?= BASEURL; ?>index.php?url=Home/index/<?= $data['container']['kode_ruangan']; ?>" class="flex items-center gap-2 bg-white border border-outline-variant/30 hover:bg-slate-50 text-on-surface font-semibold py-3 px-6 rounded-full shadow-sm transition-all active:scale-95 whitespace-nowrap">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </div>
    </header>

    <!-- Main Content: Item List Only -->
    <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 p-6 md:p-8 overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-headline text-xl font-bold text-on-surface">Isi Container</h2>
            <div class="w-10 h-10 rounded-2xl bg-primary/5 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[11px] font-semibold text-secondary uppercase tracking-wider border-b border-surface-container-high">
                        <th class="pb-4 pt-2 font-medium text-left w-12">No</th>
                        <th class="pb-4 pt-2 font-medium">Nama Barang</th>
                        <th class="pb-4 pt-2 font-medium w-20 text-center">Baik</th>
                        <th class="pb-4 pt-2 font-medium w-20 text-center">Rusak</th>
                        <th class="pb-4 pt-2 font-medium w-24 text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium">
                <?php 
                $no = 1;
                if(!empty($data['items'])): 
                    foreach($data['items'] as $item): 
                        $total = $item['kondisi_baik'] + $item['kondisi_rusak'];
                ?>
                    <tr class="border-b border-surface-container-high/50 group hover:bg-surface-container-low transition-colors">
                        <td class="py-4 font-bold text-blue-500"><?= $no; ?></td>
                        <td class="py-4">
                            <span class="text-on-surface font-semibold"><?= $item['nama_barang']; ?></span>
                        </td>
                        <td class="py-4 text-center font-bold text-emerald-500"><?= $item['kondisi_baik']; ?></td>
                        <td class="py-4 text-center font-bold text-red-500"><?= $item['kondisi_rusak']; ?></td>
                        <td class="py-4 text-center font-bold text-primary"><?= $total; ?></td>
                    </tr>
                <?php 
                    $no++;
                    endforeach;
                else: 
                ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl opacity-20">inbox</span>
                                <p class="italic text-sm">Container ini belum terisi barang.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Report History Section -->
    <?php if(isset($data['riwayat_laporan']) && is_array($data['riwayat_laporan']) && !empty($data['riwayat_laporan'])): ?>
    <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 p-6 md:p-8 mt-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-headline text-xl font-bold text-on-surface">Riwayat Laporan Terakhir (Container)</h2>
            <?php if(count($data['riwayat_laporan']) > 3): ?>
            <button onclick="toggleAllLaporan()" id="btn-lihat-laporan" class="flex items-center gap-1 text-primary text-sm font-bold hover:gap-2 transition-all">
                Lihat Semua
                <span class="material-symbols-outlined text-sm">arrow_downward</span>
            </button>
            <?php endif; ?>
        </div>
        
        <div class="space-y-4">
            <?php 
            $displayed_laporan = array_slice($data['riwayat_laporan'], 0, 3);
            $hidden_laporan = array_slice($data['riwayat_laporan'], 3);
            
            foreach($displayed_laporan as $laporan): ?>
            <div class="group flex flex-col md:flex-row md:items-center justify-between p-4 md:p-5 rounded-2xl bg-surface-container-low/30 border border-outline-variant/20 hover:border-primary/30 hover:bg-white hover:shadow-md transition-all duration-300 gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined">report</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface text-sm md:text-base mb-1"><?= $laporan['nama_barang']; ?></h3>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[10px] px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-bold uppercase tracking-wider"><?= $laporan['jenis_laporan']; ?></span>
                            <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                <?= date('d M Y', strtotime($laporan['created_at'])); ?>
                            </div>
                            <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                <span class="material-symbols-outlined text-sm">person</span>
                                <?= $laporan['nama_lengkap']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between md:justify-end gap-6 pl-16 md:pl-0">
                    <div class="flex flex-col md:items-end">
                        <span class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Status</span>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full <?= $laporan['status_laporan'] == 'Baru' ? 'bg-orange-500' : ($laporan['status_laporan'] == 'Proses' ? 'bg-blue-500' : 'bg-green-500'); ?>"></span>
                            <span class="text-sm font-bold <?= $laporan['status_laporan'] == 'Baru' ? 'text-orange-500' : ($laporan['status_laporan'] == 'Proses' ? 'text-blue-500' : 'text-green-500'); ?>">
                                <?= $laporan['status_laporan']; ?>
                            </span>
                        </div>
                    </div>
                    <button class="p-2 hover:bg-primary/10 hover:text-primary text-outline rounded-full transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>

            <div id="hidden-laporan" class="hidden space-y-4">
                <?php foreach($hidden_laporan as $laporan): ?>
                <div class="group flex flex-col md:flex-row md:items-center justify-between p-4 md:p-5 rounded-2xl bg-surface-container-low/30 border border-outline-variant/20 hover:border-primary/30 hover:bg-white hover:shadow-md transition-all duration-300 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined">report</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-on-surface text-sm md:text-base mb-1"><?= $laporan['nama_barang']; ?></h3>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="text-[10px] px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full font-bold uppercase tracking-wider"><?= $laporan['jenis_laporan']; ?></span>
                                <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    <?= date('d M Y', strtotime($laporan['created_at'])); ?>
                                </div>
                                <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    <?= $laporan['nama_lengkap']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between md:justify-end gap-6 pl-16 md:pl-0">
                        <div class="flex flex-col md:items-end">
                            <span class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Status</span>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full <?= $laporan['status_laporan'] == 'Baru' ? 'bg-orange-500' : ($laporan['status_laporan'] == 'Proses' ? 'bg-blue-500' : 'bg-green-500'); ?>"></span>
                                <span class="text-sm font-bold <?= $laporan['status_laporan'] == 'Baru' ? 'text-orange-500' : ($laporan['status_laporan'] == 'Proses' ? 'text-blue-500' : 'text-green-500'); ?>">
                                    <?= $laporan['status_laporan']; ?>
                                </span>
                            </div>
                        </div>
                        <button class="p-2 hover:bg-primary/10 hover:text-primary text-outline rounded-full transition-colors">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script>
        function toggleAllLaporan() {
            const hiddenDiv = document.getElementById('hidden-laporan');
            const btn = document.getElementById('btn-lihat-laporan');
            
            if (hiddenDiv.classList.contains('hidden')) {
                hiddenDiv.classList.remove('hidden');
                btn.innerHTML = 'Sembunyikan <span class="material-symbols-outlined text-sm">arrow_upward</span>';
            } else {
                hiddenDiv.classList.add('hidden');
                btn.innerHTML = 'Lihat Semua <span class="material-symbols-outlined text-sm">arrow_downward</span>';
            }
        }
    </script>
    <?php endif; ?>
</main>
</body>
</html>
