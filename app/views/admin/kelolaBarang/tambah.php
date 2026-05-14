<!-- Main Content Area -->
    <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
                <a href="<?= BASEURL ?>kelolaBarang" class="hover:text-blue-500">Kelola Barang</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Tambah Barang</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
                Tambah Barang Baru
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
                Lengkapi detail informasi barang untuk didaftarkan ke dalam sistem pemantauan pusat.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
            <form action="<?= BASEURL; ?>kelolaBarang/prosesTambah" method="post" class="space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Barang</label>
                        <input class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Masukan Nama Barang" name="nama_barang" type="text"/>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori Barang</label>
                        <div class="relative">
                            <select name="id_kategori" required
                                class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <?php foreach ($data['kategori'] as $kat) : ?>
                                    <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-300 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                    <a href="<?= BASEURL; ?>kelolaBarang" class="w-full sm:w-auto px-6 h-11 text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all" type="button" onclick="history.back()">
                        Batal
                    </a>
                    <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">save</span>
                        Simpan Barang
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
                    Pastikan informasi barang sesuai dengan fisik barang sebelum disimpan.
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