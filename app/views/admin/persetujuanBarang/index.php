<!-- Main Canvas -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
  <div class="space-y-2">
    <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">Persetujuan Barang</h2>
    <p class="text-lg text-slate-500 font-body">Daftar pengajuan penambahan atau perubahan barang dari Ketua Kelas yang perlu ditinjau.</p>
  </div>

  <?php if(isset($_SESSION['flash'])) : ?>
  <div class="p-4 rounded-lg <?= $_SESSION['flash']['type'] === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' ?> flex items-center gap-3">
    <span class="material-symbols-outlined"><?= $_SESSION['flash']['type'] === 'success' ? 'check_circle' : 'error' ?></span>
    <p class="text-sm font-bold"><?= $_SESSION['flash']['message'] ?></p>
  </div>
  <?php unset($_SESSION['flash']); ?>
  <?php endif; ?>

  <!-- Table Section -->
  <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
    <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Daftar Pengajuan Pending</h4>
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
            placeholder="Cari Pengajuan..."
            class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
          >
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table id="interactive-table" class="w-full text-left border-collapse min-w-[900px]">
        <thead>
          <tr class="bg-slate-50/50">
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">No</th>
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ruangan</th>
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pengaju</th>
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Barang</th>
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Jumlah</th>
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
            <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <?php $no = 1 ?>
          <?php if(empty($data['pengajuan'])) : ?>
          <tr>
            <td colspan="7" class="px-5 py-10 text-center text-slate-400 font-medium italic">Tidak ada pengajuan yang perlu disetujui.</td>
          </tr>
          <?php endif; ?>
          <?php foreach($data['pengajuan'] as $p) : ?>
          <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
            <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface row-no"><?= $no; ?></td>
            <td class="px-5 py-4">
              <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $p['nama_ruangan']; ?></p>
              <p class="text-[10px] text-slate-500 font-medium"><?= $p['kode_ruangan']; ?></p>
            </td>
            <td class="px-5 py-4">
              <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $p['nama_lengkap'] ?? 'Unknown'; ?></p>
            </td>
            <td class="px-5 py-4 text-xs md:text-sm font-bold text-on-surface search-target"><?= $p['nama_barang']; ?></td>
            <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= $p['total_barang']; ?></td>
            <td class="px-5 py-4 text-xs text-slate-500 font-medium">
                <?= date('d M Y, H:i', strtotime($p['created_at'])); ?>
            </td>
            <td class="px-5 py-4 text-center">
              <div class="flex items-center justify-center gap-2">
                <a href="<?= BASEURL; ?>KelolaPersetujuan/setujui/<?= $p['id_ruangan_barang']; ?>" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold rounded-md hover:bg-emerald-100 transition-colors flex items-center gap-1" onclick="return confirm('Setujui pengajuan ini?')">
                  <span class="material-symbols-outlined text-sm">check</span>
                  Setujui
                </a>
                <a href="<?= BASEURL; ?>KelolaPersetujuan/tolak/<?= $p['id_ruangan_barang']; ?>" class="px-3 py-1.5 bg-red-50 text-error text-[10px] font-extrabold rounded-md hover:bg-red-100 transition-colors flex items-center gap-1" onclick="return confirm('Tolak pengajuan ini?')">
                  <span class="material-symbols-outlined text-sm">close</span>
                  Tolak
                </a>
              </div>
            </td>
          </tr>
          <?php $no++ ?>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30">
      <p id="pagination-summary" class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
        Menampilkan 0 - 0 dari 0 Pengajuan
      </p>
      <div id="pagination-controls" class="flex items-center gap-1.5">
        <!-- JS Injected -->
      </div>
    </div>
  </div>
</section>
