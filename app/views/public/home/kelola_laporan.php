<body class="bg-surface text-on-surface antialiased min-h-screen pb-16 md:pb-0">
<!-- TopAppBar -->
<header class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-4 md:px-8 py-3 md:py-4 bg-white/70 backdrop-blur-xl shadow-sm">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL; ?>index.php?url=Home/index/<?= $data['ruangan']['kode_ruangan']; ?>" class="p-2 hover:bg-slate-100 rounded-full transition-all">
            <span class="material-symbols-outlined text-slate-600">arrow_back</span>
        </a>
        <h1 class="text-lg md:text-xl font-black text-blue-800 font-headline tracking-tight">Kelola Laporan - <?= $data['ruangan']['nama_ruangan']; ?></h1>
    </div>
    <div class="flex items-center gap-4">
        <!-- Room Switcher Dropdown -->
        <div class="hidden md:block">
            <select onchange="window.location.href='<?= BASEURL ?>index.php?url=Home/kelola_laporan/'+this.value" 
                    class="bg-slate-100 border-none rounded-xl text-[10px] font-black uppercase tracking-wider py-2.5 px-4 focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer hover:bg-slate-200 transition-all">
                <?php foreach($data['ruangan_list'] as $r): ?>
                    <option value="<?= $r['kode_ruangan'] ?>" <?= $r['kode_ruangan'] == $data['ruangan']['kode_ruangan'] ? 'selected' : '' ?>>
                        <?= $r['nama_ruangan'] ?> (<?= $r['kode_ruangan'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-container">
            <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAvltUebAn6fxbUAopbMYXpNgcDNmhS_eY7IE8RcwR3X34nI7oEMkIW6QB1Ayx7LcUmh2-v2Q4KSQvnnENZeMli1SLTHejSvocYjrZGksxefU4-WbmANYZw56oQO0HiCG0jMoa6fkRIQZBgByvpfgfNk0dTmPcK7V1rjI5lNasX3HjFQMt74GdOktNDsFMfIYSSpRpmfJk4tdmwJf5h3uXhV8c45HYCjdzdyYAw8xom_gt_8oU8-A-IKzhBK2456cQ0EZPXxlzakhxm"/>
        </div>
    </div>
</header>

<main class="pt-24 md:pt-32 pb-20 px-4 md:px-6 max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-on-surface font-headline mb-2">Daftar Keluhan Ruangan</h2>
        <p class="text-secondary">Update status perbaikan barang di ruangan <?= $data['ruangan']['kode_ruangan']; ?>.</p>
    </div>

    <!-- Mobile Room Switcher -->
    <div class="md:hidden mb-8">
        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4 mb-2 block">Cek Ruangan Lain</label>
        <div class="relative">
            <select onchange="window.location.href='<?= BASEURL ?>index.php?url=Home/kelola_laporan/'+this.value" 
                    class="w-full bg-white border border-slate-200 rounded-3xl py-4 pl-6 pr-12 text-sm font-bold shadow-sm appearance-none outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                <?php foreach($data['ruangan_list'] as $r): ?>
                    <option value="<?= $r['kode_ruangan'] ?>" <?= $r['kode_ruangan'] == $data['ruangan']['kode_ruangan'] ? 'selected' : '' ?>>
                        <?= $r['nama_ruangan'] ?> (<?= $r['kode_ruangan'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="material-symbols-outlined absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">unfold_more</span>
        </div>
    </div>

    <div class="space-y-4">
        <?php if(empty($data['laporan'])): ?>
            <div class="bg-white p-12 rounded-3xl border border-dashed border-outline-variant text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">inventory_2</span>
                <p class="text-secondary font-medium">Tidak ada laporan aktif di ruangan ini.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['laporan'] as $laporan): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden hover:shadow-md transition-all duration-300">
                    <div class="p-6 md:p-8 flex flex-col md:flex-row gap-6">
                        <!-- Image/Icon -->
                        <div class="w-full md:w-48 h-48 rounded-2xl bg-surface-container overflow-hidden flex-shrink-0">
                            <?php if($laporan['foto']): ?>
                                <img src="<?= BASEURL; ?>uploads/laporan/<?= $laporan['foto']; ?>" class="w-full h-full object-cover" alt="Foto Laporan">
                            <?php else: ?>
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-2">
                                    <span class="material-symbols-outlined text-4xl">image_not_supported</span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-wider rounded-full"><?= $laporan['jenis_laporan']; ?></span>
                                        <?php if($laporan['id_container']): ?>
                                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-[10px] font-black uppercase tracking-wider rounded-full">Container: <?= $laporan['nama_container'] ?? 'Unknown'; ?></span>
                                        <?php endif; ?>
                                        <span class="text-secondary text-xs font-medium"><?= date('d M Y, H:i', strtotime($laporan['created_at'])); ?></span>
                                    </div>
                                    <div class="flex items-center gap-2 px-4 py-1.5 rounded-full border <?= $laporan['status_laporan'] == 'Baru' ? 'bg-orange-50 border-orange-200 text-orange-600' : ($laporan['status_laporan'] == 'Proses' ? 'bg-blue-50 border-blue-200 text-blue-600' : 'bg-green-50 border-green-200 text-green-600'); ?>">
                                        <span class="w-2 h-2 rounded-full <?= $laporan['status_laporan'] == 'Baru' ? 'bg-orange-500' : ($laporan['status_laporan'] == 'Proses' ? 'bg-blue-500' : 'bg-green-500'); ?>"></span>
                                        <span class="text-xs font-black uppercase tracking-widest"><?= $laporan['status_laporan']; ?></span>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-on-surface mb-2"><?= $laporan['nama_barang']; ?></h3>
                                <p class="text-secondary text-sm leading-relaxed mb-4"><?= $laporan['deskripsi']; ?></p>
                                <div class="flex items-center gap-2 text-xs text-outline font-medium">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    Pelapor: <?= $laporan['nama_lengkap']; ?>
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-surface-container flex flex-wrap gap-3">
                                <?php if($laporan['status_laporan'] !== 'Selesai'): ?>
                                    <form action="<?= BASEURL; ?>index.php?url=Home/update_status_laporan" method="POST" class="inline">
                                        <input type="hidden" name="id_laporan" value="<?= $laporan['id_laporan']; ?>">
                                        <input type="hidden" name="kode_ruangan" value="<?= $laporan['kode_ruangan']; ?>">
                                        <input type="hidden" name="status" value="Proses">
                                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-full transition-all active:scale-95 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">handyman</span>
                                            Tandai Sedang Diperbaiki
                                        </button>
                                    </form>
                                    <form action="<?= BASEURL; ?>index.php?url=Home/update_status_laporan" method="POST" class="inline">
                                        <input type="hidden" name="id_laporan" value="<?= $laporan['id_laporan']; ?>">
                                        <input type="hidden" name="kode_ruangan" value="<?= $laporan['kode_ruangan']; ?>">
                                        <input type="hidden" name="status" value="Selesai">
                                        <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-full transition-all active:scale-95 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">check_circle</span>
                                            Selesai Diperbaiki
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="text-green-600 flex items-center gap-2 font-bold text-sm italic">
                                        <span class="material-symbols-outlined">verified</span>
                                        Laporan ini telah diselesaikan
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
</body>
