<!-- Main Content Area -->
    <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
                <a href="<?= BASEURL ?>kelolaRuangan" class="hover:text-blue-500">Kelola Ruangan</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Tambah Ruangan</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
                Tambah Ruangan Baru
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
                Lengkapi detail informasi Ruangan untuk didaftarkan ke dalam sistem pemantauan pusat.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
<form method="POST" action="<?= BASEURL; ?>KelolaRuangan/tambah">
    <div class="grid grid-cols-1 gap-6">

        <!-- Nama Ruangan -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Ruangan</label>
            <input class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" 
                placeholder="Contoh: Ruang Kelas A1" 
                type="text" 
                name="nama_ruangan" required/>
        </div>

        <!-- Kode Ruangan -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kode Ruangan</label>
            <input class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" 
                placeholder="Contoh: RK-A1" 
                type="text" 
                name="kode_ruangan" required/>
        </div>

        <!-- Lokasi -->
        <div class="space-y-2">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Lokasi</label>
            <input class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" 
                placeholder="Contoh: Gedung A Lantai 2" 
                type="text" 
                name="lokasi" required/>
        </div>

        <!-- QR Data -->
        

    </div>

    <!-- Error Message -->
    <?php if (isset($data['error'])) : ?>
        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
            <?= $data['error'] ?>
        </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
        <a href="<?= BASEURL; ?>kelolaRuangan" 
            class="w-full sm:w-auto px-6 h-11 text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all flex items-center justify-center">
            Batal
        </a>
        <button class="w-full sm:w-auto px-6 h-11 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-all flex items-center justify-center gap-2 text-sm" 
            name="action" value="save" type="submit">
            <span class="material-symbols-outlined text-lg">save</span>
            Simpan Saja
        </button>
        <button class="w-full sm:w-auto px-8 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" 
            name="action" value="save_and_add_items" type="submit">
            <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">add_circle</span>
            Simpan & Tambah Barang
        </button>
    </div>
</form>
        </div>

        <!-- Help Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mt-8">
            <div class="bg-blue-50/50 p-5 rounded-lg flex flex-col gap-3 border border-blue-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                    <span class="material-symbols-outlined text-xl">info</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Validasi Data</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Pastikan informasi Ruangan sesuai dengan fisik Ruangan sebelum disimpan.
                </p>
            </div>
            <div class="bg-emerald-50/50 p-5 rounded-lg flex flex-col gap-3 border border-emerald-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">sync</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Sinkronisasi</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Data akan langsung terhubung dengan dashboard monitoring pusat secara real-time.
                </p>
            </div>
            <div class="bg-amber-50/50 p-5 rounded-lg flex flex-col gap-3 border border-amber-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-amber-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">verified_user</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Keamanan</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Setiap perubahan data akan tercatat dalam log aktivitas administrator otomatis.
                </p>
            </div>
        </div>
    </section>