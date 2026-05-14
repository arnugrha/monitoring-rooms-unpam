<!-- Main Canvas -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
    <div class="space-y-2">
        <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">Kelola Laporan</h2>
        <p class="text-lg text-slate-500 font-body">Daftar laporan kerusakan dan kehilangan barang dari pengguna.</p>
    </div>

    <!-- Statistics Bento Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5">
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Laporan</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-primary font-headline">
                <?= $data['total_laporan'] ?? 0 ?>
            </h3>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Laporan Baru</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-red-500 font-headline">
                <?= $data['total_baru'] ?? 0 ?>
            </h3>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Proses Perbaikan</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-amber-600 font-headline">
                <?= $data['total_proses'] ?? 0 ?>
            </h3>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-slate-100 transition-all hover:shadow-md">
            <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-emerald-700 font-headline">
                <?= $data['total_selesai'] ?? 0 ?>
            </h3>
        </div>
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
                <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Daftar Laporan</h4>
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
                    <input type="text" id="table-search" placeholder="Cari laporan..." 
                        class="w-full md:w-64 pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
                </div>
                <a href="<?= BASEURL; ?>kelolaLaporan/tambah"
                    class="flex items-center justify-center gap-1.5 px-5 py-2.5 bg-primary text-white rounded-lg text-xs font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Tambah Laporan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="interactive-table" class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest min-w-[180px]">Jenis Laporan</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pelapor</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ruangan</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Jumlah</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Tanggal</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Foto</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (!empty($data['laporan'])) : ?>
                        <?php foreach ($data['laporan'] as $row) : ?>
                            <tr class="table-row-data hover:bg-slate-50/50 transition-colors group">
                                <!-- Jenis Laporan -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-xl">description</span>
                                        </div>
                                        <div>
                                            <p class="search-target font-bold text-xs md:text-sm text-on-surface">
                                                <?= htmlspecialchars($row['jenis_laporan']) ?>
                                            </p>
                                            <p class="search-target text-[9px] md:text-[10px] text-slate-400 font-medium">
                                                <?= htmlspecialchars($row['nama_barang']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Pelapor -->
                                <td class="px-5 py-4 text-xs text-slate-500 search-target">
                                    <?php
                                    $userModel = $this->models('User_model');
                                    $user = $userModel->getUserById($row['id_user']);
                                    echo htmlspecialchars($user['username'] ?? 'User Tidak Dikenal');
                                    ?>
                                </td>

                                <!-- Ruangan -->
                                <td class="px-5 py-4 text-xs text-slate-500 search-target">
                                    <?= htmlspecialchars($row['kode_ruangan'] ?? 'Ruangan Tidak Dikenal'); ?>
                                </td>

                                <!-- Jumlah Barang -->
                                <td class="px-5 py-4 text-center text-xs font-bold text-on-surface">
                                    <?= $row['jumlah_barang'] ?? 0 ?>
                                </td>

                                <!-- Tanggal -->
                                <td class="px-5 py-4 text-center text-xs text-slate-500">
                                    <?= date('d M Y', strtotime($row['created_at'])) ?>
                                </td>

                                <!-- Foto -->
                                <td class="px-5 py-4 text-center">
                                    <?php if (!empty($row['foto'])) : ?>
                                        <a href="<?= BASEURL ?>uploads/laporan/<?= $row['foto'] ?>" target="_blank"
                                            class="inline-flex items-center justify-center p-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 transition-colors">
                                            <span class="material-symbols-outlined text-lg">image</span>
                                        </a>
                                    <?php else : ?>
                                        <span class="text-[10px] text-slate-300 font-bold">Tidak ada</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td class="px-5 py-4 text-center">
                                    <?php
                                    $status = $row['status_laporan'];
                                    $statusClass = match ($status) {
                                        'Baru'    => 'bg-red-50 text-red-600',
                                        'Proses'  => 'bg-amber-50 text-amber-700',
                                        'Selesai' => 'bg-emerald-50 text-emerald-700',
                                        default   => 'bg-slate-50 text-slate-500',
                                    };
                                    ?>
                                    <span class="px-2 py-1 text-[10px] font-bold rounded-full <?= $statusClass ?> search-target">
                                        <?= htmlspecialchars($status) ?>
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-1.5 md:gap-2">
                                        <a href="<?= BASEURL ?>kelolaLaporan/edit/<?= $row['id_laporan'] ?>"
                                            class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        <a href="<?= BASEURL ?>kelolaLaporan/hapus/<?= $row['id_laporan'] ?>"
                                            class="p-1.5 text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-400 text-sm font-medium">
                                Tidak ada laporan yang ditemukan.
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