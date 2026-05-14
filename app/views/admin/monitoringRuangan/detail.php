<!-- Main Canvas -->
      <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6 tracking-wide">
            <a class="hover:text-primary transition-colors" href="<?= BASEURL; ?>MonitoringRuangan">Monitoring Ruangan</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface">Detail Ruangan</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="space-y-1">
                <h2 class="headline-font text-on-primary-fixed-variant text-2xl font-extrabold tracking-tight">Detail Barang: Ruangan <?= $data['ruangan']['kode_ruangan']; ?></h2>
                <p class="text-slate-500 font-medium text-xs">Informasi detail inventaris untuk unit <?= $data['ruangan']['kode_ruangan']; ?></p>
            </div>
            <div class="flex gap-3">
                <a href="<?= BASEURL; ?>MonitoringRuangan/cetak/<?= $data['ruangan']['kode_ruangan']; ?>" target="_blank" class="flex items-center gap-2 px-4 py-2 text-xs bg-surface-container-lowest text-primary font-bold rounded-xl shadow-sm border border-outline-variant/20 hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-[18px]">print</span>
                    Cetak Laporan
                </a>
                <a href="<?= BASEURL; ?>MonitoringRuangan/export/<?= $data['ruangan']['kode_ruangan']; ?>" class="flex items-center gap-2 px-4 py-2 text-xs bg-primary text-on-primary font-bold rounded-xl shadow-[0_4px_14px_rgba(0,93,172,0.3)] hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export Excel
                </a>
            </div>
        </div>
        <!-- Statistics Bento Grid -->
        

        <!-- Table Section -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
          <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Daftar Inventaris</h4>
              <p class="text-[10px] md:text-xs text-slate-400 font-medium">
                Manajemen detail aset dan status ruangan terkini
              </p>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
              <thead>
                <tr class="bg-slate-50/50">
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">No</th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Barang</th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Total Barang
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Baik
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Rusak
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                <?php $i = 1; ?>
                <?php foreach($data['barang_ruangan'] as $barang) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors group">
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= $i++; ?></td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface"><?= $barang['nama_barang']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= $barang['total_barang']; ?></td>
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface">
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full"><?= $barang['kondisi_baik']; ?></span>
                  </td>
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface">
                    <span class="px-2 py-0.5 bg-red-50 text-error text-[10px] font-bold rounded-full"><?= $barang['kondisi_rusak']; ?></span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Table Footer / Pagination -->
          <div
            class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30"
          >
            <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
              Menampilkan 1 - 3 dari 128 Ruangan
            </p>
            <div class="flex items-center gap-1.5">
              <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
              </button>
              <button
                class="h-8 w-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-[10px] md:text-xs"
              >
                1
              </button>
              <button
                class="h-8 w-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 font-bold text-[10px] md:text-xs"
              >
                2
              </button>
              <button
                class="h-8 w-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 font-bold text-[10px] md:text-xs"
              >
                3
              </button>
              <button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
              </button>
            </div>
          </div>
        </div>
      </section>