
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
    <!-- Header -->
    <div class="mb-8 text-center sm:text-left">
        <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
            <a href="<?= BASEURL ?>kelolaRuangan" class="hover:text-blue-500">Kelola Ruangan</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Edit Ruangan</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
            Edit Ruangan: <?= htmlspecialchars($data['ruangan']['nama_ruangan'] ?? ''); ?>
        </h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
            Perbarui detail informasi ruangan yang tersedia di sistem.
        </p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
        <form action="<?= BASEURL; ?>KelolaRuangan/edit/<?= $data['ruangan']['kode_ruangan']; ?>" method="post">
            <input type="hidden" name="kode_lama" value="<?= htmlspecialchars($data['ruangan']['kode_ruangan'] ?? ''); ?>">

            <div class="grid grid-cols-1 gap-6">
                <!-- Nama Ruangan -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm"
                        value="<?= htmlspecialchars($data['ruangan']['nama_ruangan'] ?? ''); ?>" required />
                </div>

                <!-- Kode Ruangan -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kode Ruangan</label>
                    <input type="text" name="kode_ruangan" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm"
                        value="<?= htmlspecialchars($data['ruangan']['kode_ruangan'] ?? ''); ?>" required />
                </div>

                <!-- Lokasi -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Lokasi</label>
                    <input type="text" name="lokasi" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm"
                        value="<?= htmlspecialchars($data['ruangan']['lokasi'] ?? ''); ?>" required />
                </div>
                <!-- QR Data -->
                <!-- <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">QR Data</label>
                    <input type="text" name="qr_data" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm"
                        value="<?= htmlspecialchars($data['ruangan']['qr_data'] ?? ''); ?>" required />
                </div> -->

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Status Ruangan</label>
                    <select name="status_ruangan" id="status_ruangan" class="w-full h-11 px-4 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm">
                        <option value="aktif" <?= ($data['ruangan']['status_ruangan'] === 'aktif') ? 'selected' : ''; ?> >Aktif</option>
                        <option value="maintance" <?= ($data['ruangan']['status_ruangan'] === 'maintance') ? 'selected' : ''; ?> >Maintance</option>
                        <option value="non aktif" <?= ($data['ruangan']['status_ruangan'] === 'non aktif') ? 'selected' : ''; ?> >Non Aktif</option>
                    </select>
                </div>
                </div>
            </div>

            <!-- Error Message -->
            <?php if (isset($data['error'])) : ?>
                <script>alert('<?= $data['error'] ?>');</script>
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <!-- Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                <a href="<?= BASEURL; ?>kelolaRuangan" class="w-full sm:w-auto px-6 h-11 text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all text-center leading-[2.75rem]">
                    Batal
                </a>
                <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Update Ruangan
                </button>
            </div>
        </form>
    </div>
</section>