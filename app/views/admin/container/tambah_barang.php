<!-- Main Content Area -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
    <!-- Header Section -->
    <div class="mb-8 text-center sm:text-left">
        <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
            <a href="<?= BASEURL ?>index.php?url=container/index" class="hover:text-blue-500">Kelola Container</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Tambah Barang</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
            Isi Barang Container
        </h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
            Perbarui jumlah barang yang tersimpan di dalam <strong><?= $data['container']['nama_container']; ?></strong>.
        </p>
    </div>

    <!-- Container Info Card -->
    <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-5 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary shadow-sm">
                <span class="material-symbols-outlined text-2xl">inventory_2</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-sm md:text-base"><?= $data['container']['nama_container']; ?></h4>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Ruangan: <?= $data['container']['kode_ruangan']; ?></p>
            </div>
        </div>
        <div class="text-right hidden sm:block">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1.5">Jumlah Saat Ini</p>
            <div class="flex gap-2">
                <div class="px-2.5 py-1 bg-emerald-500 text-white rounded-md text-[10px] font-bold"><?= $data['container']['kondisi_baik']; ?> Baik</div>
                <div class="px-2.5 py-1 bg-red-500 text-white rounded-md text-[10px] font-bold"><?= $data['container']['kondisi_rusak']; ?> Rusak</div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100 mt-6">
        <form action="<?= BASEURL; ?>index.php?url=container/prosesTambahBarang" method="post" class="space-y-6">
            <input type="hidden" name="id_container" value="<?= $data['container']['id_container']; ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Jumlah Baik -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Jumlah Barang Baik</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-emerald-500 transition-colors">check_circle</span>
                        <input 
                            class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" 
                            placeholder="0" 
                            name="jumlah_baik" 
                            required
                            type="number"
                            min="0"
                        />
                    </div>
                </div>

                <!-- Jumlah Rusak -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Jumlah Barang Rusak</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-red-500 transition-colors">cancel</span>
                        <input 
                            class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-red-500/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" 
                            placeholder="0" 
                            name="jumlah_rusak" 
                            required
                            type="number"
                            min="0"
                        />
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                <a href="<?= BASEURL; ?>index.php?url=container/index" class="w-full sm:w-auto px-6 h-11 flex items-center justify-center text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all">
                    Kembali
                </a>
                <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">add_task</span>
                    Update Inventaris
                </button>
            </div>
            <p class="text-center text-[10px] text-slate-400 italic">
                * Angka yang Anda masukkan akan ditambahkan ke jumlah barang yang sudah ada saat ini.
            </p>
        </form>
    </div>
</section>
