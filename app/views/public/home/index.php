<body class="bg-surface font-body text-on-surface antialiased min-h-screen pb-12">
<!-- Main Container -->
<main class="max-w-5xl mx-auto px-4 pb-8 pt-4 md:pb-12 md:pt-8 mt-4">
    
    <!-- Header Section -->
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
    
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <span class="inline-block px-3 py-1 bg-primary text-on-primary text-[10px] font-bold rounded-full mb-3 tracking-wider uppercase">Active Room</span>
            <h1 class="font-headline text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight mb-[0.2rem]">Monitoring <?= isset($data['ruangan']['kode_ruangan']) ? $data['ruangan']['kode_ruangan'] : 'Ruangan'; ?> </h1>
            <p class="text-xs text-slate-500 font-medium mb-2">Teknik Informatika Universitas Pamulang</p>
            <p class="text-secondary text-sm md:text-base font-medium">Kelola inventaris dan log pemantauan aset dalam satu jendela.</p>
        </div>
        <div class="flex gap-3">
            <?php if(Session::isLoggedIn() && Session::role() === 'OB'): ?>
            <a href="<?= BASEURL ?>index.php?url=Home/kelola_laporan/<?= $data['ruangan']['kode_ruangan']; ?>" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full shadow-md shadow-blue-500/20 transition-all active:scale-95 whitespace-nowrap">
                <span class="material-symbols-outlined text-lg">edit_note</span>
                Kelola Laporan
            </a>
            <?php endif; ?>
            <a href="<?= BASEURL ?>index.php?url=Home/laporan/<?= isset($data['ruangan']['kode_ruangan']) ? $data['ruangan']['kode_ruangan'] : ''; ?>" class="flex items-center gap-2 bg-[#ffcc00] hover:bg-[#e6b800] text-black font-semibold py-3 px-6 rounded-full shadow-md shadow-yellow-500/20 transition-all active:scale-95 whitespace-nowrap">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                Buat Laporan
            </a>
            <?php if(Session::isLoggedIn()): ?>
            <a href="<?= BASEURL ?>index.php?url=AuthController/logout" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-black font-semibold py-3 px-6 rounded-full shadow-md transition-all active:scale-95 whitespace-nowrap" onclick="return confirm('Yakin ingin logout?')">
                <span class="material-symbols-outlined text-lg">logout</span>
                Logout
            </a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Inventory Box -->
    <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 p-6 md:p-8 mb-8 overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-headline text-xl font-bold text-on-surface">Inventaris Barang</h2>
            <div class="flex gap-2">
                <?php if(Session::isLoggedIn() && Session::role() === 'Ketua kelas'): ?>
                <a href="<?= BASEURL ?>index.php?url=Home/tambah_barang/<?= $data['ruangan']['kode_ruangan']; ?>" class="flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-full transition-all active:scale-95 shadow-sm">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Tambah Barang
                </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if(Session::isLoggedIn() && Session::role() === 'OB'): ?>
        <!-- Room Switcher for OB -->
        <div class="mb-6 p-4 bg-blue-50/50 border border-blue-100 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center">
                    <span class="material-symbols-outlined">swap_horiz</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-blue-900">Pindah Ruangan</h3>
                    <p class="text-[10px] text-blue-600 font-medium font-body">Cek inventaris di ruangan lain tanpa harus login ulang.</p>
                </div>
            </div>
            <!-- Custom Searchable Dropdown -->
            <div class="relative w-full md:w-64" id="room-switcher-container">
                <div class="relative">
                    <input type="text" 
                           id="room-search-input"
                           placeholder="Cari & pilih ruangan..." 
                           readonly
                           class="w-full bg-white border border-blue-200 rounded-xl py-2.5 pl-10 pr-4 text-xs font-bold shadow-sm outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer"
                           value="<?= $data['ruangan']['nama_ruangan'] ?> (<?= $data['ruangan']['kode_ruangan'] ?>)">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-blue-400 text-sm">search</span>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-blue-400 text-sm pointer-events-none transition-transform duration-300" id="dropdown-icon">expand_more</span>
                </div>
                
                <!-- Dropdown Menu -->
                <div id="room-dropdown-menu" 
                     class="hidden absolute left-0 right-0 mt-2 bg-white border border-blue-100 rounded-xl shadow-xl z-[100] max-h-60 overflow-y-auto overflow-x-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                    <div class="p-2 border-b border-blue-50 sticky top-0 bg-white z-10">
                        <input type="text" 
                               id="room-filter-field"
                               placeholder="Ketik nama atau kode..." 
                               class="w-full px-3 py-2 text-xs bg-blue-50 border-none rounded-lg focus:ring-0 outline-none font-medium"
                               autocomplete="off">
                    </div>
                    <div class="p-1" id="room-list-items">
                        <?php foreach($data['ruangan_list'] as $r): ?>
                            <div class="room-item flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-bold text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer transition-colors group" 
                                 data-value="<?= $r['kode_ruangan'] ?>"
                                 data-search="<?= strtolower($r['nama_ruangan'] . ' ' . $r['kode_ruangan']) ?>">
                                <div class="flex flex-col">
                                    <span><?= $r['nama_ruangan'] ?></span>
                                    <span class="text-[9px] opacity-70 font-medium group-hover:text-blue-100"><?= $r['kode_ruangan'] ?></span>
                                </div>
                                <?php if($r['kode_ruangan'] == $data['ruangan']['kode_ruangan']): ?>
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="no-room-found" class="hidden p-4 text-center text-[10px] text-slate-400 font-medium">
                        Ruangan tidak ditemukan.
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const container = document.getElementById('room-switcher-container');
                    const searchInput = document.getElementById('room-search-input');
                    const filterField = document.getElementById('room-filter-field');
                    const dropdownMenu = document.getElementById('room-dropdown-menu');
                    const roomItems = document.querySelectorAll('.room-item');
                    const noFound = document.getElementById('no-room-found');
                    const icon = document.getElementById('dropdown-icon');

                    // Toggle Dropdown
                    searchInput.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const isHidden = dropdownMenu.classList.contains('hidden');
                        
                        // Close all other instances if any
                        dropdownMenu.classList.toggle('hidden');
                        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                        
                        if(isHidden) {
                            filterField.focus();
                            filterField.value = '';
                            roomItems.forEach(item => item.classList.remove('hidden'));
                            noFound.classList.add('hidden');
                        }
                    });

                    // Search/Filter Logic
                    filterField.addEventListener('input', (e) => {
                        const term = e.target.value.toLowerCase();
                        let foundCount = 0;

                        roomItems.forEach(item => {
                            const searchData = item.getAttribute('data-search');
                            if(searchData.includes(term)) {
                                item.classList.remove('hidden');
                                foundCount++;
                            } else {
                                item.classList.add('hidden');
                            }
                        });

                        noFound.classList.toggle('hidden', foundCount > 0);
                    });

                    // Select Logic
                    roomItems.forEach(item => {
                        item.addEventListener('click', () => {
                            const value = item.getAttribute('data-value');
                            window.location.href = `<?= BASEURL ?>index.php?url=Home/index/${value}`;
                        });
                    });

                    // Close on click outside
                    document.addEventListener('click', (e) => {
                        if (!container.contains(e.target)) {
                            dropdownMenu.classList.add('hidden');
                            icon.style.transform = 'rotate(0deg)';
                        }
                    });
                });
            </script>
        </div>
        <?php endif; ?>

        <!-- Table Container -->
        <div class="overflow-x-auto -mx-6 md:mx-0 px-6 md:px-0">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[11px] font-semibold text-secondary uppercase tracking-wider border-b border-surface-container-high">
                        <th class="pb-4 pt-2 font-medium text-left">No</th>
                        <th class="pb-4 pt-2 font-medium text-center md:text-left">Nama Barang</th>
                        <th class="pb-4 pt-2 font-medium w-20 text-center">Baik</th>
                        <th class="pb-4 pt-2 font-medium w-20 text-center">Rusak</th>
                        <th class="pb-4 pt-2 font-medium w-24 text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium">
                <?php 
                $no = 1;
                if(isset($data['brg']) && is_array($data['brg']) && !empty($data['brg'])): 
                    foreach($data['brg'] as $barang): 
                ?>
                    <tr class="border-b border-surface-container-high/50 group hover:bg-surface-container-low transition-colors">
                        <td class="py-4 font-bold text-blue-500"><?= $no; ?></td>
                        <td class="py-4 md:text-left text-center">
                            <?php if($barang['nama_kategori'] == 'Container' && $barang['id_container']) : ?>
                                <a href="<?= BASEURL; ?>index.php?url=Home/container/<?= $barang['id_container']; ?>" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 transition-colors group">
                                    <span class="font-bold border-b border-transparent group-hover:border-blue-800"><?= isset($barang['nama_barang']) ? $barang['nama_barang'] : '-'; ?></span>
                                    <span class="material-symbols-outlined text-sm">arrow_outward</span>
                                </a>
                            <?php else : ?>
                                <span class="text-on-surface font-semibold"><?= isset($barang['nama_barang']) ? $barang['nama_barang'] : '-'; ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 text-center font-bold text-blue-500"><?= isset($barang['kondisi_baik']) ? $barang['kondisi_baik'] : '0'; ?></td>
                        <td class="py-4 text-center font-bold text-red-500"><?= isset($barang['kondisi_rusak']) ? $barang['kondisi_rusak'] : '0'; ?></td>
                        <td class="py-4 text-center font-bold text-primary"><?= isset($barang['total_barang']) ? $barang['total_barang'] : '0'; ?></td>
                    </tr>
                <?php 
                    $no++;
                    endforeach;
                else: 
                ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl">inventory</span>
                                <p>Belum ada data barang di ruangan ini</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- History Section -->
    <?php if(isset($data['riwayat_laporan']) && is_array($data['riwayat_laporan']) && !empty($data['riwayat_laporan']) && Session::isLoggedIn() == 'true'): ?>
    <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 p-6 md:p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-headline text-xl font-bold text-on-surface">Riwayat Laporan Terakhir</h2>
            <?php if(count($data['riwayat_laporan']) > 3): ?>
            <button onclick="toggleAllLaporan()" id="btn-lihat-semua-laporan" class="flex items-center gap-1 text-primary text-sm font-bold hover:gap-2 transition-all">
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
    <?php endif; ?>
    <?php if(isset($data['riwayat_pengajuan']) && is_array($data['riwayat_pengajuan']) && !empty($data['riwayat_pengajuan']) && Session::isLoggedIn() == 'true'): ?>
    <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 p-6 md:p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-headline text-xl font-bold text-on-surface">Riwayat Pengajuan Barang</h2>
            <?php if(count($data['riwayat_pengajuan']) > 3): ?>
            <button onclick="toggleAllSubmissions()" id="btn-lihat-semua" class="flex items-center gap-1 text-primary text-sm font-bold hover:gap-2 transition-all">
                Lihat Semua
                <span class="material-symbols-outlined text-sm">arrow_downward</span>
            </button>
            <?php endif; ?>
        </div>
        
        <div class="space-y-4">
            <?php 
            $displayed_pengajuan = array_slice($data['riwayat_pengajuan'], 0, 3);
            $hidden_pengajuan = array_slice($data['riwayat_pengajuan'], 3);
            
            foreach($displayed_pengajuan as $pengajuan): ?>
            <div class="group flex flex-col md:flex-row md:items-center justify-between p-4 md:p-5 rounded-2xl bg-surface-container-low/30 border border-outline-variant/20 hover:border-primary/30 hover:bg-white hover:shadow-md transition-all duration-300 gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface text-sm md:text-base mb-1"><?= $pengajuan['nama_barang']; ?> (<?= $pengajuan['total_barang']; ?> unit)</h3>
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                <span class="material-symbols-outlined text-sm">person</span>
                                <?= $pengajuan['nama_lengkap'] ?? 'Unknown'; ?>
                            </div>
                            <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                <?= date('d M Y', strtotime($pengajuan['created_at'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between md:justify-end gap-6 pl-16 md:pl-0">
                    <div class="flex flex-col md:items-end">
                        <span class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Status</span>
                        <div class="flex items-center gap-2">
                            <?php 
                                $status_color = 'bg-blue-500';
                                $text_color = 'text-blue-500';
                                if($pengajuan['status_pengajuan'] == 'disetujui') {
                                    $status_color = 'bg-green-500';
                                    $text_color = 'text-green-500';
                                } else if($pengajuan['status_pengajuan'] == 'ditolak') {
                                    $status_color = 'bg-red-500';
                                    $text_color = 'text-red-500';
                                }
                            ?>
                            <span class="w-2 h-2 rounded-full <?= $status_color; ?>"></span>
                            <span class="text-sm font-bold <?= $text_color; ?>">
                                <?= ucfirst($pengajuan['status_pengajuan']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <div id="hidden-submissions" class="hidden space-y-4">
                <?php foreach($hidden_pengajuan as $pengajuan): ?>
                <div class="group flex flex-col md:flex-row md:items-center justify-between p-4 md:p-5 rounded-2xl bg-surface-container-low/30 border border-outline-variant/20 hover:border-primary/30 hover:bg-white hover:shadow-md transition-all duration-300 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-on-surface text-sm md:text-base mb-1"><?= $pengajuan['nama_barang']; ?> (<?= $pengajuan['total_barang']; ?> unit)</h3>
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    <?= $pengajuan['nama_lengkap'] ?? 'Unknown'; ?>
                                </div>
                                <div class="flex items-center gap-1.5 text-secondary text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    <?= date('d M Y', strtotime($pengajuan['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between md:justify-end gap-6 pl-16 md:pl-0">
                        <div class="flex flex-col md:items-end">
                            <span class="text-[10px] text-outline font-bold uppercase tracking-widest mb-1">Status</span>
                            <div class="flex items-center gap-2">
                                <?php 
                                    $status_color = 'bg-blue-500';
                                    $text_color = 'text-blue-500';
                                    if($pengajuan['status_pengajuan'] == 'disetujui') {
                                        $status_color = 'bg-green-500';
                                        $text_color = 'text-green-500';
                                    } else if($pengajuan['status_pengajuan'] == 'ditolak') {
                                        $status_color = 'bg-red-500';
                                        $text_color = 'text-red-500';
                                    }
                                ?>
                                <span class="w-2 h-2 rounded-full <?= $status_color; ?>"></span>
                                <span class="text-sm font-bold <?= $text_color; ?>">
                                    <?= ucfirst($pengajuan['status_pengajuan']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <script>
        function toggleAllSubmissions() {
            const hiddenDiv = document.getElementById('hidden-submissions');
            const btn = document.getElementById('btn-lihat-semua');
            
            if (hiddenDiv.classList.contains('hidden')) {
                hiddenDiv.classList.remove('hidden');
                btn.innerHTML = 'Sembunyikan <span class="material-symbols-outlined text-sm">arrow_upward</span>';
            } else {
                hiddenDiv.classList.add('hidden');
                btn.innerHTML = 'Lihat Semua <span class="material-symbols-outlined text-sm">arrow_downward</span>';
            }
        }

        function toggleAllLaporan() {
            const hiddenDiv = document.getElementById('hidden-laporan');
            const btn = document.getElementById('btn-lihat-semua-laporan');
            
            if (hiddenDiv.classList.contains('hidden')) {
                hiddenDiv.classList.remove('hidden');
                btn.innerHTML = 'Sembunyikan <span class="material-symbols-outlined text-sm">arrow_upward</span>';
            } else {
                hiddenDiv.classList.add('hidden');
                btn.innerHTML = 'Lihat Semua <span class="material-symbols-outlined text-sm">arrow_downward</span>';
            }
        }
    </script>
</main>

</body>
</html>