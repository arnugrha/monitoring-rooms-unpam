<!-- Main Canvas -->
      <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
          <div class="space-y-2">
            <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">Kelola Barang Ruangan</h2>
            <p class="text-lg text-slate-500 font-body">Ringkasan data ruangan yang mencakup total ruangan, ruangan aktif, dan ruangan yang kosong.</p>
          </div>
          
          <?php if (isset($data['status_filter']) && $data['status_filter'] == 'rusak') : ?>
          <div class="flex items-center gap-3 animate-in fade-in slide-in-from-right duration-500">
            <div class="px-3 py-1.5 bg-red-50 border border-red-100 rounded-lg flex items-center gap-2">
              <span class="material-symbols-outlined text-error text-sm">report_problem</span>
              <span class="text-[10px] font-bold text-error uppercase tracking-wider">Filter: Barang Rusak</span>
            </div>
            <a href="<?= BASEURL; ?>MonitoringRuangan" class="text-[10px] font-bold text-slate-400 hover:text-primary transition-colors uppercase tracking-widest flex items-center gap-1 group">
              Tampilkan Semua
              <span class="material-symbols-outlined text-xs group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
            </a>
          </div>
          <?php endif; ?>
        </div>
        <!-- Statistics Bento Grid -->
        

        <!-- Table Section -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
          <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Daftar Inventaris</h4>
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
                  placeholder="Cari Ruangan..."
                  class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
                >
              </div>
              <a
                href="<?= BASEURL; ?>MonitoringRuangan/tambah"
                class="flex items-center justify-center gap-1.5 px-5 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
              >
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah
              </a>

              <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="flex items-center justify-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-lg shadow-emerald-600/20 transition-all">
                  <span class="material-symbols-outlined text-lg">upload_file</span>
                  Import
              </button>
              <a href="<?= BASEURL; ?>MonitoringRuangan/exportSemua" class="flex items-center justify-center gap-1.5 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold shadow-lg shadow-amber-500/20 transition-all">
                  <span class="material-symbols-outlined text-lg">download</span>
                  Export
              </a>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table id="interactive-table" class="w-full text-left border-collapse min-w-[700px]">
              <thead>
                <tr class="bg-slate-50/50">
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">No</th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kode Ruangan</th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Total Barang
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Kondisi Baik
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Kondisi Rusak
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                <?php $no = 1 ?>
                <?php foreach($data['dataBarangRuangan'] as $ruangan) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface row-no"><?= $no; ?></td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $ruangan['kode_ruangan']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= $ruangan['total_barang']; ?></td>
                  <td class="px-5 py-4 text-center">
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full"
                      ><?= $ruangan['total_baik']; ?></span
                    >
                  </td>
                  <td class="px-5 py-4 text-center">
                    <span class="px-2 py-0.5 bg-red-50 text-error text-[10px] font-bold rounded-full"><?= $ruangan['total_rusak']; ?></span>
                  </td>
                  <td class="px-5 py-4">
                    <div class="flex items-center justify-center gap-1.5 md:gap-2">
                      <a href="<?= BASEURL; ?>MonitoringRuangan/detail/<?= $ruangan['kode_ruangan']; ?>" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Detail">
                        <span class="material-symbols-outlined text-lg">info</span>
                      </a>
                      <a href="<?= BASEURL; ?>MonitoringRuangan/edit/<?= $ruangan['kode_ruangan']; ?>" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                        <span class="material-symbols-outlined text-lg">edit</span>
                      </a>
                      <a href="<?= BASEURL; ?>MonitoringRuangan/hapus/<?= $ruangan['kode_ruangan']; ?>" class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus semua data barang di ruangan ini?')">
                        <span class="material-symbols-outlined text-lg">delete</span>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php $no++ ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Table Footer / Pagination -->
          <div
            class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30"
          >
            <p id="pagination-summary" class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
              Menampilkan 0 - 0 dari 0 Ruangan
            </p>
            <div id="pagination-controls" class="flex items-center gap-1.5">
              <!-- JS Injected -->
            </div>
          </div>
        </div>
      </section>

    <!-- Modal Import -->
    <div id="importModal" class="fixed inset-0 z-[100] hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden animate-in zoom-in-95 duration-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-on-surface">Import Data Barang CSV</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-slate-400 hover:text-error transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="<?= BASEURL; ?>MonitoringRuangan/importCSV" method="post" enctype="multipart/form-data" class="p-6">
                <div class="mb-6 space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest">Pilih File CSV</label>
                    <input type="file" name="file_csv" accept=".csv" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all outline-none">
                    <p class="text-[10px] text-slate-400 mt-2 font-medium">Format header (Wide): <span class="font-bold text-slate-600">RUANG, Papan Tulis, Kondisi, Meja, Kondisi 2, dst.</span></p>
                    <p class="text-[10px] text-slate-400 font-medium">Simpan file Excel Anda sebagai CSV sebelum di-upload.</p>
                </div>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-50 rounded-lg transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-emerald-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Upload Data</button>
                </div>
            </form>
        </div>
    </div>