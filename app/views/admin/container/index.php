<!-- Main Canvas -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
  <div class="space-y-2 text-center sm:text-left">
    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-on-surface font-headline leading-tight">Kelola Container</h2>
    <p class="text-slate-500 font-body text-sm md:text-base max-w-2xl">Master data unit penyimpanan (lemari/loker) yang terdaftar di setiap ruangan.</p>
  </div>

  <!-- Table Section -->
  <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-100">
    <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h4 class="text-lg font-extrabold text-on-surface font-headline">Daftar Container</h4>
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
          <input 
            type="text" 
            id="table-search"
            placeholder="Cari Container..."
            class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
          >
        </div>

        <a
          href="<?= BASEURL; ?>index.php?url=container/cetak_semua_qr"
          target="_blank"
          class="flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white text-primary border border-primary/20 rounded-lg text-xs font-bold shadow-sm hover:bg-slate-50 active:scale-[0.98] transition-all"
        >
          <span class="material-symbols-outlined text-lg">print</span>
          Cetak Semua QR
        </a>
        <a
          href="<?= BASEURL; ?>index.php?url=container/tambah"
          class="flex items-center justify-center gap-1.5 px-6 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
        >
          <span class="material-symbols-outlined text-lg">add</span>
          Tambah Container
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table id="interactive-table" class="w-full text-left border-collapse min-w-[600px]">
        <thead>
          <tr class="bg-slate-50/50">
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-16">No</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama/Jenis Container</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Ruangan</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">QR Code</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-32">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 text-sm">
          <?php $no = 1 ?>
          <?php foreach($data['containers'] as $container) : ?>
          <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
            <td class="px-6 py-4 text-center font-bold text-slate-400 row-no"><?= $no; ?></td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                  <span class="material-symbols-outlined text-lg">inventory_2</span>
                </div>
                <p class="font-bold text-on-surface search-target"><?= $container['nama_container']; ?></p>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase tracking-wider search-target"><?= $container['kode_ruangan']; ?></span>
            </td>
            <td class="px-6 py-4 text-center">
              <?php if($container['qr_data']) : ?>
                <div class="inline-block p-1 bg-white border border-slate-200 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer" onclick="window.open('https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=<?= urlencode($container['qr_data']); ?>', '_blank')">
                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=40x40&data=<?= urlencode($container['qr_data']); ?>" alt="QR" class="w-10 h-10">
                </div>
              <?php else : ?>
                <span class="text-[10px] text-slate-300 italic">No Data</span>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center justify-center gap-2">
                <a href="<?= BASEURL; ?>index.php?url=container/cetak_qr/<?= $container['id_container']; ?>" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Cetak QR">
                  <span class="material-symbols-outlined text-lg">print</span>
                </a>
                <a href="<?= BASEURL; ?>index.php?url=container/edit/<?= $container['id_container']; ?>" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                  <span class="material-symbols-outlined text-lg">edit</span>
                </a>
                <a href="<?= BASEURL; ?>index.php?url=container/hapus/<?= $container['id_container']; ?>" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus container ini?')">
                  <span class="material-symbols-outlined text-lg">delete</span>
                </a>
              </div>
            </td>
          </tr>
          <?php $no++ ?>
          <?php endforeach ?>
          
          <?php if (empty($data['containers'])) : ?>
          <tr>
            <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">Belum ada data container terdaftar.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30">
      <p id="pagination-summary" class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
        Menampilkan 0 - 0 dari 0 Container
      </p>
      <div id="pagination-controls" class="flex items-center gap-1.5">
        <!-- JS Injected by interactive.js -->
      </div>
    </div>
  </div>
</section>
