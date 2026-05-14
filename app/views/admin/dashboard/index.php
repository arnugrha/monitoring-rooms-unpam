    <!-- Dashboard Body -->
    <section class="p-4 md:p-6 lg:p-8 space-y-4 md:space-y-8 max-w-[1400px] mx-auto">
        <!-- Hero Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-5">
            <!-- Total Barang Card -->
            <a href="<?= BASEURL; ?>MonitoringRuangan" class="md:col-span-2 bg-primary-container text-on-primary-container p-5 md:p-6 rounded-lg shadow-lg flex flex-col justify-between relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="font-medium opacity-80 mb-1 text-xs md:text-sm text-white/90">Total Barang Tersedia</p>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold font-headline tracking-tighter text-white"><?= number_format($data['total_barang_baik'], 0, ',', '.'); ?></h2>
                </div>
                <div class="mt-4 md:mt-6 flex items-center gap-2 text-[10px] md:text-xs relative z-10 font-bold text-white/90">
                    <span class="material-symbols-outlined text-tertiary-fixed text-lg">inventory_2</span>
                    <span>Tersedia di seluruh ruangan</span>
                </div>
                <!-- Decorative Element -->
                <div class="absolute -right-8 -bottom-8 w-32 md:w-40 h-32 md:h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            </a>
            
            <!-- Laporan Masuk -->
            <a href="<?= BASEURL; ?>kelolaLaporan" class="bg-white p-5 md:p-6 rounded-lg shadow-sm flex flex-col justify-between border border-slate-100 hover:shadow-md transition-shadow">
                <div>
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-secondary-container text-secondary flex items-center justify-center rounded-xl mb-3">
                        <span class="material-symbols-outlined text-xl md:text-2xl">description</span>
                    </div>
                    <p class="text-slate-500 font-medium text-xs md:text-sm">Total Laporan</p>
                    <h3 class="text-2xl md:text-3xl font-extrabold font-headline mt-0.5"><?= $data['total_laporan']; ?></h3>
                </div>
                <p class="text-[10px] text-slate-400 mt-3 font-medium italic"><?= $data['laporan_hari_ini']; ?> laporan baru hari ini</p>
            </a>
            
            <!-- Add Room CTA -->
            <a href="<?= BASEURL; ?>kelolaRuangan/tambah" class="bg-[#ffcc00] p-5 md:p-6 rounded-lg shadow-md flex flex-col justify-center items-center text-center space-y-2 md:space-y-3 hover:bg-[#ffbb00] transition-all cursor-pointer group active:scale-[0.98]">
                <div class="w-10 md:w-12 h-10 md:h-12 bg-white rounded-full flex items-center justify-center shadow focus:shadow-lg group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-black text-xl md:text-2xl font-bold">add</span>
                </div>
                <p class="font-headline font-extrabold text-black text-[13px] md:text-sm leading-tight">Tambah Ruangan</p>
            </a>
        </div>

        <!-- Issues & Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Secondary Stats Column -->
            <div class="space-y-3 md:space-y-4">
                <a href="<?= BASEURL; ?>MonitoringRuangan/?status=rusak" class="bg-white p-4 md:p-5 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="shrink-0 w-10 md:w-12 h-10 md:h-12 bg-error-container text-error flex items-center justify-center rounded-full">
                        <span class="material-symbols-outlined text-xl md:text-2xl">report_problem</span>
                    </div>
                    <div>
                        <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Barang Rusak</p>
                        <h4 class="text-xl md:text-2xl font-extrabold font-headline"><?= $data['total_barang_rusak']; ?> Unit</h4>
                    </div>
                </a>
                <a href="<?= BASEURL; ?>kelolaRuangan" class="bg-white p-4 md:p-5 rounded-xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="shrink-0 w-10 md:w-12 h-10 md:h-12 bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center rounded-full">
                        <span class="material-symbols-outlined text-xl md:text-2xl">meeting_room</span>
                    </div>
                    <div>
                        <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Total Ruangan</p>
                        <h4 class="text-xl md:text-2xl font-extrabold font-headline"><?= $data['total_ruangan']; ?> Ruang</h4>
                    </div>
                </a>
                <!-- Quick Actions Card -->
                <div class="bg-white p-5 md:p-6 rounded-lg shadow-sm space-y-4 border border-slate-100">
                    <h5 class="font-extrabold font-headline text-sm md:text-base">Quick Access</h5>
                    <div class="grid grid-cols-2 gap-2 md:gap-3">
                        <a href="<?= BASEURL ?>kelolaRuangan/cetakSemuaQr" target="_blank" class="py-2.5 px-3 bg-surface text-[10px] md:text-xs font-bold rounded-lg hover:bg-primary-fixed hover:text-on-primary-fixed transition-colors border border-slate-100">Cetak Barcode</a>
                        <a class="py-2.5 px-3 bg-surface text-[10px] md:text-xs font-bold rounded-lg hover:bg-primary-fixed hover:text-on-primary-fixed transition-colors border border-slate-100">Export PDF</a>
                        <a class="py-2.5 px-3 bg-surface text-[10px] md:text-xs font-bold rounded-lg hover:bg-primary-fixed hover:text-on-primary-fixed transition-colors border border-slate-100">Scan QR</a>
                        <a href="<?= BASEURL ?>kelolaLaporan" class="py-2.5 px-3 bg-surface text-[10px] md:text-xs font-bold rounded-lg hover:bg-primary-fixed hover:text-on-primary-fixed transition-colors border border-slate-100">Verifikasi</a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Stage: Room Distribution Chart -->
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-lg shadow-sm flex flex-col border border-slate-100">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6">
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold font-headline">Laporan Perbulan</h3>
                        <p class="text-slate-400 text-xs mt-0.5 font-medium">Statistik jumlah laporan yang masuk setiap bulannya.</p>
                    </div>
                    <a href="<?= BASEURL; ?>kelolaLaporan" class="flex items-center gap-1 text-primary font-bold text-xs hover:underline underline-offset-4">
                        View Details <span class="material-symbols-outlined text-xs">arrow_forward</span>
                    </a>
                </div>
                <!-- Visual Bar Chart Representation -->
                <div class="flex-1 flex items-end justify-between gap-2.5 md:gap-4 min-h-[220px] pt-10 overflow-x-auto pb-4">
                    <?php 
                    $max_reports = 0;
                    foreach ($data['monthly_reports'] as $report) {
                        if ($report['total'] > $max_reports) $max_reports = $report['total'];
                    }
                    if ($max_reports == 0) $max_reports = 1; // Avoid division by zero
                    
                    foreach ($data['monthly_reports'] as $report) : 
                        $height = ($report['total'] / $max_reports) * 100;
                    ?>
                    <!-- Bar -->
                    <div class="flex-1 flex flex-col items-center group min-w-[32px]">
                        <div class="w-full max-w-[40px] bg-slate-50 rounded-t-lg md:rounded-t-xl relative group-hover:bg-slate-100 transition-all duration-300 h-full">
                            <div class="absolute inset-x-0 bottom-0 bg-primary/80 rounded-t-lg md:rounded-t-xl transition-all duration-500" style="height: <?= $height; ?>%"></div>
                            <!-- Tooltip -->
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[9px] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none font-bold">
                                <?= $report['total']; ?>
                            </div>
                        </div>
                        <span class="text-[9px] md:text-[10px] font-bold text-slate-400 mt-2.5 uppercase tracking-wider"><?= substr($report['bulan'], 0, 3); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg p-5 md:p-8 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6 md:mb-8">
                <h3 class="text-lg md:text-xl font-extrabold font-headline">Aktivitas Terbaru</h3>
                <div class="flex gap-2">
                    <span class="px-3.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-full border border-blue-100 cursor-pointer">Logs</span>
                </div>
            </div>
            <div class="space-y-4">
                <?php if (empty($data['recent_activities'])) : ?>
                <p class="text-xs text-slate-400 italic text-center py-4">Belum ada aktivitas terbaru.</p>
                <?php else : ?>
                    <?php foreach ($data['recent_activities'] as $activity) : ?>
                    <!-- Activity Item -->
                    <div class="flex items-center justify-between group transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <?php 
                            $icon = 'report';
                            $bgColor = 'bg-blue-50';
                            $textColor = 'text-primary';
                            
                            if (strtolower($activity['status_laporan']) == 'selesai') {
                                $icon = 'check_circle';
                                $bgColor = 'bg-emerald-50';
                                $textColor = 'text-emerald-600';
                            } else if (strtolower($activity['status_laporan']) == 'proses') {
                                $icon = 'pending';
                                $bgColor = 'bg-amber-50';
                                $textColor = 'text-amber-600';
                            } else if (strtolower($activity['status_laporan']) == 'baru') {
                                $icon = 'notification_important';
                                $bgColor = 'bg-red-50';
                                $textColor = 'text-error';
                            }
                            ?>
                            <div class="shrink-0 h-9 w-9 rounded-full <?= $bgColor; ?> flex items-center justify-center <?= $textColor; ?>">
                                <span class="material-symbols-outlined text-lg"><?= $icon; ?></span>
                            </div>
                            <div>
                                <h5 class="font-extrabold text-xs text-on-surface"><?= $activity['jenis_laporan']; ?> - <?= $activity['nama_ruangan']; ?></h5>
                                <p class="text-[10px] text-slate-500 mt-0.5"><?= $activity['nama_barang']; ?> (<?= $activity['status_laporan']; ?>) oleh <?= $activity['nama_lengkap']; ?>.</p>
                            </div>
                        </div>
                        <span class="text-[9px] font-bold text-slate-300 uppercase shrink-0 px-2 font-headline">
                            <?php 
                            $time_ago = strtotime($activity['created_at']);
                            $diff = time() - $time_ago;
                            if ($diff < 60) echo 'Sekarang';
                            else if ($diff < 3600) echo floor($diff / 60) . 'm';
                            else if ($diff < 86400) echo floor($diff / 3600) . 'j';
                            else echo floor($diff / 86400) . 'h';
                            ?>
                        </span>
                    </div>
                    <!-- Divider -->
                    <div class="h-px bg-slate-50 w-full"></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
