<!-- Main Canvas -->
      <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
        <div class="space-y-2">
          <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">Kelola Users</h2>
          <p class="text-lg text-slate-500 font-body">Users yang bisa mengakses website ini.</p>
        </div>
        <!-- Statistics Bento Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-primary font-headline"><?= $data['totalUsers']; ?></h3>
          </div>
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Admin</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-error font-headline"><?= $data['totalAdmin']; ?></h3>
          </div>
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Ketua Kelas</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-amber-600 font-headline"><?= $data['totalKetuaKelas']; ?></h3>
          </div>
          <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Office Boy</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-emerald-700  font-headline"><?= $data['totalOb']; ?></h3>
          </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
          <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">DAFTAR USERS</h4>
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
                  placeholder="Cari User..."
                  class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
                >
              </div>
              <a
                href="<?= BASEURL; ?>users/tambah"
                class="flex items-center justify-center gap-1.5 px-5 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
              >
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Users
              </a>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table id="interactive-table" class="w-full text-left border-collapse min-w-[700px]">
              <thead>
                <tr class="bg-slate-50/50">
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest ">
                    No
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest ">
                    Username
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Nama Lengkap
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Ruangan
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Role
                  </th>
                  <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                <?php $no = 1 ?>
                <?php foreach($data['users'] as $user) : ?>
                <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
                  <td class="px-5 py-4 text-xs md:text-sm font-bold text-on-surface row-no"><?= $no; ?></td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $user['username']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $user['nama_lengkap']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= (is_null($user['kode_ruangan'])) ? '-' : $user['kode_ruangan']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div>
                        <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $user['role']; ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4">
                    <div class="flex items-center justify-center gap-1.5 md:gap-2">
                      <!-- <button class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Detail">
                        <span class="material-symbols-outlined text-lg">info</span>
                      </button> -->
                      <a href="<?= BASEURL; ?>users/edit/<?= $user['id_user']; ?>" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                        <span class="material-symbols-outlined text-lg">edit</span>
                      </a>
                      <a href="<?= BASEURL; ?>users/hapus/<?= $user['id_user']; ?>" class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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
              Menampilkan 0 - 0 dari 0 Users
            </p>
            <div id="pagination-controls" class="flex items-center gap-1.5">
              <!-- Buttons will be injected via JS -->
            </div>
          </div>
        </div>
      </section>