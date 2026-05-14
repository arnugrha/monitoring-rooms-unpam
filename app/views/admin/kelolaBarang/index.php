<!-- Main Canvas -->
      <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="space-y-2">
          <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">Kelola Barang</h2>
          <p class="text-lg text-slate-500 font-body">Daftar data barang yang mencakup total barang, kondisi barang baik, barang rusak, dan barang yang hilang.</p>
        </div>
        <!-- Statistics Bento Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Barang</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-primary font-headline"><?= $data['totalBarang']; ?></h3>
          </div>
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Kondisi Baik</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-emerald-600 font-headline"><?= $data['totalBaik']; ?></h3>
          </div>
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Rusak</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-error font-headline"><?= $data['totalRusak']; ?></h3>
          </div>
        </div>

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
                  placeholder="Cari Barang..."
                  class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
                >
              </div>

              <button
                onclick="toggleModal('category-modal')"
                class="flex items-center justify-center gap-1.5 px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-lg text-xs font-bold hover:bg-slate-50 active:scale-[0.98] transition-all"
              >
                <span class="material-symbols-outlined text-lg">category</span>
                Kelola Kategori
              </button>
              <a
                href="<?= BASEURL; ?>kelolaBarang/tambah"
                class="flex items-center justify-center gap-1.5 px-5 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
              >
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Barang
              </a>
            </div>

            <script>
              function printSingleQR() {
                const kode = document.getElementById('print-room-qr').value;
                if (!kode) {
                  alert('Silakan pilih ruangan terlebih dahulu!');
                  return;
                }
                window.open('<?= BASEURL ?>kelolaRuangan/cetakQR/' + kode, '_blank');
              }
            </script>
          </div>

          <div class="overflow-x-auto">
            <table id="interactive-table" class="w-full text-left border-collapse min-w-[700px]">
              <thead>
                <tr class="bg-slate-50/50">
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    No
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Barang</th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Kategori</th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Total
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
                <?php $no = 1 ?>
                <?php foreach($data['barang'] as $barang) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface row-no"><?= $no; ?></td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $barang['nama_barang']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4 text-center">
                    <?php if (!empty($barang['kategori'])) : ?>
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-md uppercase tracking-wider search-target"><?= $barang['kategori']; ?></span>
                    <?php else : ?>
                    <span class="text-[10px] text-slate-300 italic">Uncategorized</span>
                    <?php endif; ?>
                  </td>
                  <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= $barang['total_keseluruhan']; ?></td>
                  <td class="px-5 py-4 text-center">
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full"
                      ><?= $barang['total_baik']; ?></span
                    >
                  </td>
                  <td class="px-5 py-4 text-center">
                    <span class="px-2 py-0.5 bg-red-50 text-error text-[10px] font-bold rounded-full"><?= $barang['total_rusak']; ?></span>
                  </td>
                  <td class="px-5 py-4">
                    <div class="flex items-center justify-center gap-1.5 md:gap-2">
                      <a href="<?= BASEURL; ?>kelolaBarang/edit/<?= $barang['id_barang']; ?>" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                        <span class="material-symbols-outlined text-lg">edit</span>
                      </a>
                      <a href="<?= BASEURL; ?>kelolaBarang/hapus/<?= $barang['id_barang']; ?>" class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                        <span class="material-symbols-outlined text-lg">delete</span>
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
          <div
            class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30"
          >
            <p id="pagination-summary" class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
              Menampilkan 0 - 0 dari 0 Barang
            </p>
            <div id="pagination-controls" class="flex items-center gap-1.5">
              <!-- JS Injected -->
            </div>
          </div>
        </div>
      </section>

      <!-- Category Management Modal -->
      <div id="category-modal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
          <div class="flex items-center justify-center min-h-screen p-4">
              <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="toggleModal('category-modal')"></div>
              
              <div class="relative bg-white rounded-2xl shadow-2xl w-[90%] md:w-1/2 overflow-hidden animate-in fade-in zoom-in duration-200">
                  <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                      <div>
                          <h3 class="text-xl font-bold text-on-surface font-headline">Kelola Kategori</h3>
                          <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah, atau hapus kategori barang inventaris.</p>
                      </div>
                      <button onclick="toggleModal('category-modal')" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                          <span class="material-symbols-outlined">close</span>
                      </button>
                  </div>

                  <div class="p-6 md:p-8 space-y-8">
                      <!-- Add Category Form -->
                      <div class="bg-primary/5 p-5 rounded-2xl border border-primary/10">
                          <label class="block text-[10px] font-bold text-primary uppercase tracking-widest mb-3 ml-1">Kategori Baru</label>
                          <form action="<?= BASEURL ?>kelolaBarang/tambahKategori" method="POST" class="flex gap-3">
                              <input type="text" name="nama_kategori" placeholder="Contoh: Alat Kebersihan" required
                                  class="flex-1 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                              <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary-dark shadow-lg shadow-primary/20 active:scale-95 transition-all flex items-center gap-2">
                                  <span class="material-symbols-outlined text-lg">add</span>
                                  Tambah
                              </button>
                          </form>
                      </div>

                      <!-- Category List -->
                      <div class="space-y-3">
                          <div class="flex items-center justify-between px-1">
                              <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Daftar Kategori Terdaftar</h4>
                              <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-full"><?= count($data['kategori']) ?> Total</span>
                          </div>
                          
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                              <?php if (!empty($data['kategori'])) : ?>
                                  <?php foreach ($data['kategori'] as $kat) : ?>
                                  <div class="group relative bg-white border border-slate-100 rounded-2xl p-4 hover:shadow-md hover:border-primary/20 transition-all duration-300">
                                      <!-- View State -->
                                      <div id="view-kat-<?= $kat['id_kategori'] ?>" class="flex items-center justify-between">
                                          <div class="flex items-center gap-3">
                                              <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                                  <span class="material-symbols-outlined text-lg">label</span>
                                              </div>
                                              <span class="text-sm font-bold text-slate-700"><?= $kat['nama_kategori'] ?></span>
                                          </div>
                                          <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                              <button onclick="toggleEditKategori(<?= $kat['id_kategori'] ?>, true)" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition-all" title="Edit">
                                                  <span class="material-symbols-outlined text-lg">edit_note</span>
                                              </button>
                                              <a href="<?= BASEURL ?>kelolaBarang/hapusKategori/<?= $kat['id_kategori'] ?>" 
                                                 onclick="return confirm('Hapus kategori ini? Semua barang dengan kategori ini akan menjadi Uncategorized.')"
                                                 class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus">
                                                  <span class="material-symbols-outlined text-lg">delete</span>
                                              </a>
                                          </div>
                                      </div>

                                      <!-- Edit State (Hidden by default) -->
                                      <form id="edit-kat-<?= $kat['id_kategori'] ?>" action="<?= BASEURL ?>kelolaBarang/prosesUbahKategori" method="POST" class="hidden flex items-center gap-2">
                                          <input type="hidden" name="id_kategori" value="<?= $kat['id_kategori'] ?>">
                                          <input type="text" name="nama_kategori" value="<?= $kat['nama_kategori'] ?>" required
                                              class="flex-1 px-3 py-1.5 bg-slate-50 border border-primary/30 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                          <div class="flex gap-1">
                                              <button type="submit" class="p-2 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all shadow-sm shadow-emerald-200">
                                                  <span class="material-symbols-outlined text-lg">check</span>
                                              </button>
                                              <button type="button" onclick="toggleEditKategori(<?= $kat['id_kategori'] ?>, false)" class="p-2 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all">
                                                  <span class="material-symbols-outlined text-lg">close</span>
                                              </button>
                                          </div>
                                      </form>
                                  </div>
                                  <?php endforeach; ?>
                              <?php else : ?>
                                  <div class="col-span-full py-12 flex flex-col items-center justify-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                                      <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">category_off</span>
                                      <p class="text-sm text-slate-400 font-medium">Belum ada kategori terdaftar</p>
                                  </div>
                              <?php endif; ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <script>
          function toggleModal(id) {
              const modal = document.getElementById(id);
              modal.classList.toggle('hidden');
              if (!modal.classList.contains('hidden')) {
                  document.body.style.overflow = 'hidden';
              } else {
                  document.body.style.overflow = 'auto';
              }
          }

          function toggleEditKategori(id, isEdit) {
              const viewDiv = document.getElementById(`view-kat-${id}`);
              const editForm = document.getElementById(`edit-kat-${id}`);
              
              if (isEdit) {
                  viewDiv.classList.add('hidden');
                  editForm.classList.remove('hidden');
                  editForm.querySelector('input[type="text"]').focus();
              } else {
                  viewDiv.classList.remove('hidden');
                  editForm.classList.add('hidden');
              }
          }
      </script>
