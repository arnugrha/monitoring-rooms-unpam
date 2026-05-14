<!-- Main Canvas -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6 tracking-wide">
        <a class="hover:text-primary transition-colors" href="<?= BASEURL; ?>BarangContainer">Monitoring Barang Container</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface">Detail Isi Container</span>
    </nav>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div class="space-y-1">
            <h2 class="headline-font text-on-primary-fixed-variant text-2xl font-extrabold tracking-tight">
                Detail Isi: <?= $data['container_info']['nama_container']; ?>
            </h2>
            <p class="text-slate-500 font-medium text-xs">
                Lokasi: <?= $data['container_info']['nama_ruangan']; ?> (<?= $data['container_info']['kode_ruangan']; ?>)
            </p>
        </div>
        <div class="flex gap-3">
            <a href="<?= BASEURL; ?>BarangContainer" class="flex items-center gap-2 px-4 py-2 text-xs bg-surface-container-lowest text-slate-500 font-bold rounded-xl shadow-sm border border-outline-variant/20 hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
        <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Daftar Barang di Dalam Container</h4>
                <p class="text-[10px] md:text-xs text-slate-400 font-medium">
                    Inventaris aset yang tersimpan di dalam unit <?= $data['container_info']['nama_container']; ?>
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-16">No</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Barang</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Total</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Baik</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Rusak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $i = 1; ?>
                    <?php foreach($data['items'] as $item) : ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= $i++; ?></td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-bold text-xs md:text-sm text-on-surface"><?= $item['nama_barang']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface"><?= ($item['kondisi_baik'] + $item['kondisi_rusak']); ?></td>
                        <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface">
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full"><?= $item['kondisi_baik']; ?></span>
                        </td>
                        <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface">
                            <span class="px-2 py-0.5 bg-red-50 text-error text-[10px] font-bold rounded-full"><?= $item['kondisi_rusak']; ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($data['items'])) : ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Container ini kosong.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30">
            <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
                Total Kuantitas: <?= array_sum(array_map(function($item) { return $item['kondisi_baik'] + $item['kondisi_rusak']; }, $data['items'])); ?> Items
            </p>
        </div>
    </div>
</section>
