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
                <a href="<?= BASEURL; ?>MonitoringRuangan/tambah?preselected_kode_ruangan=<?= $data['ruangan']['kode_ruangan']; ?>" class="flex items-center gap-2 px-4 py-2 text-xs bg-primary text-white font-bold rounded-xl shadow-md shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                    Tambah Barang
                </a>
                <a href="<?= BASEURL; ?>MonitoringRuangan/export/<?= $data['ruangan']['kode_ruangan']; ?>" class="flex items-center gap-2 px-4 py-2 text-xs bg-primary text-on-primary font-bold rounded-xl shadow-[0_4px_14px_rgba(0,93,172,0.3)] hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Export Excel
                </a>
            </div>
        </div>
        <!-- Statistics Bento Grid -->
        

        <!-- Table Section -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100 pb-2">
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
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Aksi
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
                        <?php if($barang['nama_kategori'] == 'Container' && !empty($barang['id_container'])): ?>
                            <a href="<?= BASEURL; ?>MonitoringRuangan/detailContainer/<?= $barang['id_container']; ?>" class="text-primary hover:underline group-hover:text-primary transition-colors flex items-center gap-1 w-max">
                                <p class="font-bold text-xs md:text-sm"><?= $barang['nama_barang']; ?></p>
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                            </a>
                        <?php else: ?>
                            <p class="font-bold text-xs md:text-sm text-on-surface"><?= $barang['nama_barang']; ?></p>
                        <?php endif; ?>
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
                  <td class="px-5 py-4">
                    <div class="flex items-center justify-center">
                      <a href="<?= BASEURL; ?>MonitoringRuangan/hapusBarang/<?= $data['ruangan']['kode_ruangan']; ?>/<?= $barang['id_barang']; ?>" class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus Barang" onclick="return confirm('Apakah Anda yakin ingin menghapus barang <?= $barang['nama_barang']; ?> dari ruangan ini?')">
                        <span class="material-symbols-outlined text-lg">delete</span>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>