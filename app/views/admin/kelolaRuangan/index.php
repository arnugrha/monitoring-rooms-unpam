<!-- Main Canvas -->
      <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="space-y-2">
          <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">Kelola Ruangan</h2>
          <p class="text-lg text-slate-500 font-body">Ringkasan data ruangan yang mencakup total ruangan, ruangan aktif, dan ruangan yang kosong.</p>
        </div>
    <!-- Statistics Bento Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Ruangan</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-primary font-headline">
                <?= $data['totalRuangan'] ?? 0 ?>
            </h3>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Ruangan Aktif</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-emerald-600 font-headline">
                <?= $data['totalAktif'] ?? 0 ?>
            </h3>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Maintenance</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-amber-600 font-headline">
                <?= $data['totalMaintenance'] ?? 0 ?>
            </h3>
        </div>
        <!-- <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Ruangan Kosong</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-600 font-headline">
                <?= $data['totalKosong'] ?? 0 ?>
            </h3>
        </div> -->
    </div>

    <!-- Success / Error Message -->
    <?php if (isset($_GET['success'])) : ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-700 text-sm font-medium flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">check_circle</span>
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])) : ?>
        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm font-medium flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">error</span>
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

        <!-- Table Section -->
    <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
        <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Daftar Ruangan</h4>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tampilkan</span>
                    <select id="table-entries" class="admin-select-sm">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" id="table-search" placeholder="Cari ruangan..." 
                        class="w-full md:w-64 pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
                </div>
                <div class="flex gap-2">
                    <a href="<?= BASEURL; ?>kelolaRuangan/cetakSemuaQR" target="_blank"
                        class="flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white text-primary border border-primary/20 rounded-lg text-xs font-bold shadow-sm hover:bg-slate-50 active:scale-[0.98] transition-all">
                        <span class="material-symbols-outlined text-lg">print</span>
                        Cetak Semua QR
                    </a>
                    <a href="<?= BASEURL; ?>kelolaRuangan/tambah"
                        class="flex items-center justify-center gap-1.5 px-5 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <span class="material-symbols-outlined text-lg">add</span>
                        Tambah Ruangan
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="interactive-table" class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Ruangan</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">QR Code</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th> 
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (!empty($data['ruangan'])) : ?>
                        <?php foreach ($data['ruangan'] as $row) : ?>
                            <tr class="table-row-data hover:bg-slate-50/50 transition-colors group">
                                <!-- Nama Ruangan -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-xl">co_present</span>
                                        </div>
                                        <div>
                                            <p class="search-target font-bold text-xs md:text-sm text-on-surface">
                                                <?= htmlspecialchars($row['nama_ruangan']) ?>
                                            </p>
                                            <p class="search-target text-[9px] md:text-[10px] text-slate-400 font-medium">
                                                <?= htmlspecialchars($row['kode_ruangan']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Lokasi -->
                                <td class="px-5 py-4 text-xs text-slate-500 search-target">
                                    <?= htmlspecialchars($row['lokasi'] ?? '-') ?>
                                </td>

                                <!-- QR Code -->
                                <td class="px-5 py-4">
                                    <?php if (!empty($row['qr_data'])) : ?>
                                        <div class="p-1.5 bg-white border border-slate-100 rounded-lg shadow-sm w-fit group-hover:border-primary/30 transition-colors">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=<?= urlencode($row['qr_data']) ?>" 
                                                 alt="QR Code <?= $row['kode_ruangan'] ?>"
                                                 class="w-12 h-12 md:w-14 md:h-14 object-contain">
                                        </div>
                                    <?php else : ?>
                                        <span class="text-slate-400 text-[10px] italic">Belum ada data</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Aksi -->
                                <td class="px-5 py-4">
                                     <div class="flex items-center justify-center gap-1.5 md:gap-2">
                                         <a href="<?= BASEURL ?>kelolaRuangan/cetakQR/<?= $row['kode_ruangan'] ?>" target="_blank"
                                             class="p-1.5 text-primary hover:bg-primary/5 rounded-md transition-colors" title="Cetak QR">
                                             <span class="material-symbols-outlined text-lg">print</span>
                                         </a>
                                         <a href="<?= BASEURL ?>kelolaRuangan/edit/<?= $row['kode_ruangan'] ?>"
                                             class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                                             <span class="material-symbols-outlined text-lg">edit</span>
                                         </a>
                                         <a href="<?= BASEURL ?>kelolaRuangan/hapus/<?= $row['kode_ruangan'] ?>"
                                             class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus"
                                             onclick="return confirm('Yakin ingin menghapus ruangan ini?')">
                                             <span class="material-symbols-outlined text-lg">delete</span>
                                         </a>
                                     </div>
                                 </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-400 text-sm font-medium">
                                Belum ada data ruangan
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="p-4 md:p-5 border-t border-slate-50 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div id="pagination-summary" class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-wider">
                <!-- JS Injected -->
            </div>
            <div id="pagination-controls" class="flex items-center gap-1.5">
                <!-- JS Injected -->
            </div>
        </div>
    </div>
</section>