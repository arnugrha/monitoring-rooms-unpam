<!-- Main Canvas -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
  <div class="space-y-2 text-center sm:text-left">
    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-on-surface font-headline leading-tight">Monitoring Barang Container</h2>
    <p class="text-slate-500 font-body text-sm md:text-base max-w-2xl">Daftar unit penyimpanan yang memiliki inventaris barang di dalamnya.</p>
  </div>

  <!-- Table Section -->
  <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-100">
    <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h4 class="text-lg font-extrabold text-on-surface font-headline">Daftar Isi Container</h4>
        <div class="flex items-center gap-2 mt-1">
          <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tampilkan</span>
          <select id="table-entries" class="admin-select-sm">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="25">25</option>
          </select>
        </div>
      </div>
      <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
        <div class="relative group">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-primary transition-colors">search</span>
          <input 
            type="text" 
            id="table-search"
            placeholder="Cari Container atau Ruangan..."
            class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
          >
        </div>
        <a
          href="<?= BASEURL; ?>BarangContainer/tambah"
          class="flex items-center justify-center gap-1.5 px-6 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
        >
          <span class="material-symbols-outlined text-lg">add</span>
          Tambah Barang Container
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table id="interactive-table" class="w-full text-left border-collapse min-w-[800px]">
        <thead>
          <tr class="bg-slate-50/50">
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-16">No</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Container & Ruangan</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Total Baik</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Total Rusak</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Jumlah Items</th>
            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-32">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 text-sm">
          <?php $no = 1 ?>
          <?php foreach($data['containers'] as $c) : ?>
          <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
            <td class="px-6 py-4 text-center font-bold text-slate-400 row-no"><?= $no; ?></td>
            <td class="px-6 py-4">
              <div class="flex flex-col">
                <span class="font-bold text-on-surface search-target"><?= $c['nama_container']; ?></span>
                <span class="text-[10px] text-slate-400 flex items-center gap-1 mt-0.5">
                  <span class="search-target"><?= $c['nama_ruangan']; ?> (<?= $c['kode_ruangan']; ?>)</span>
                </span>
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <span class="text-green-600 font-bold"><?= $c['total_baik']; ?></span>
            </td>
            <td class="px-6 py-4 text-center">
              <span class="text-red-500 font-bold"><?= $c['total_rusak']; ?></span>
            </td>
            <td class="px-6 py-4 text-center">
              <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase tracking-wider"><?= $c['jumlah_items']; ?> Total</span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center justify-center gap-2">
                <a href="<?= BASEURL; ?>BarangContainer/detail/<?= $c['id_container']; ?>" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-all" title="Lihat Detail">
                  <span class="material-symbols-outlined text-lg">info</span>
                </a>
                <a href="<?= BASEURL; ?>BarangContainer/edit/<?= $c['id_container']; ?>" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit Isi">
                  <span class="material-symbols-outlined text-lg">edit</span>
                </a>
                <a href="<?= BASEURL; ?>BarangContainer/hapus/<?= $c['id_container']; ?>" 
                   onclick="return confirm('Apakah Anda yakin ingin mengosongkan seluruh barang di dalam container ini?')"
                   class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Kosongkan Container">
                  <span class="material-symbols-outlined text-lg">delete</span>
                </a>
              </div>
            </td>
          </tr>
          <?php $no++ ?>
          <?php endforeach ?>
          
          <?php if (empty($data['containers'])) : ?>
          <tr>
            <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Belum ada container yang berisi barang.</td>
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
