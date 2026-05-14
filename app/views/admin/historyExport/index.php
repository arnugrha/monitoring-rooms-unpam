<!-- Main Canvas -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1400px] mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="space-y-2">
            <h2 class="text-4xl font-extrabold tracking-tight text-on-surface font-headline">History Export</h2>
            <p class="text-lg text-slate-500 font-body">Daftar riwayat export data yang dilakukan oleh administrator.</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-slate-100">
        <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h4 class="text-base md:text-lg font-extrabold text-on-surface font-headline">Riwayat Export</h4>
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
                        placeholder="Cari Riwayat..."
                        class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all w-full md:w-64"
                    >
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="interactive-table" class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center" style="width: 80px;">No</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Judul Export</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center" style="width: 250px;">Tanggal Export</th>
                        <th class="px-5 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($data['history'])): ?>
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-slate-400 font-medium italic">Belum ada riwayat export.</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1 ?>
                        <?php foreach($data['history'] as $export) : ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group table-row-data">
                            <td class="px-5 py-4 text-center text-xs md:text-sm font-bold text-on-surface row-no"><?= $no; ?></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                        <span class="material-symbols-outlined text-lg">description</span>
                                    </div>
                                    <p class="font-bold text-xs md:text-sm text-on-surface search-target"><?= $export['judul']; ?></p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-50 border border-slate-100 rounded-full">
                                    <span class="material-symbols-outlined text-slate-400 text-xs">calendar_today</span>
                                    <span class="text-xs font-bold text-slate-600 uppercase"><?= date('d M Y, H:i', strtotime($export['created_at'])); ?></span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="<?= BASEURL; ?>export/<?= $export['judul']; ?>" download="<?= $export['judul']; ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-lg text-[10px] font-bold transition-all">
                                    <span class="material-symbols-outlined text-sm">download</span>
                                    Download
                                </a>
                            </td>
                        </tr>
                        <?php $no++ ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer / Pagination -->
        <div class="p-5 md:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-50 bg-slate-50/30">
            <p id="pagination-summary" class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-tight">
                Menampilkan 0 - 0 dari 0 Riwayat
            </p>
            <div id="pagination-controls" class="flex items-center gap-1.5">
                <!-- JS Injected -->
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('table-search');
    const entriesSelect = document.getElementById('table-entries');
    const rows = Array.from(document.querySelectorAll('.table-row-data'));
    const summary = document.getElementById('pagination-summary');
    const controls = document.getElementById('pagination-controls');

    let currentPage = 1;
    let filteredRows = [...rows];

    function updateTable() {
        const entriesPerPage = parseInt(entriesSelect.value);
        const totalEntries = filteredRows.length;
        const totalPages = Math.ceil(totalEntries / entriesPerPage);

        if (currentPage > totalPages) currentPage = Math.max(1, totalPages);

        const start = (currentPage - 1) * entriesPerPage;
        const end = Math.min(start + entriesPerPage, totalEntries);

        rows.forEach(row => row.classList.add('hidden'));
        filteredRows.slice(start, end).forEach((row, index) => {
            row.classList.remove('hidden');
            // Update number based on filtered results
            row.querySelector('.row-no').textContent = start + index + 1;
        });

        summary.textContent = `Menampilkan ${totalEntries > 0 ? start + 1 : 0} - ${end} dari ${totalEntries} Riwayat`;
        
        // Render controls
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        controls.innerHTML = '';
        if (totalPages <= 1) return;

        const createBtn = (label, page, active = false, disabled = false) => {
            const btn = document.createElement('button');
            btn.className = `w-8 h-8 rounded flex items-center justify-center text-[10px] font-bold transition-all ${
                active ? 'bg-primary text-white shadow-sm' : 
                disabled ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100'
            }`;
            btn.textContent = label;
            if (!disabled && page !== currentPage) {
                btn.onclick = () => {
                    currentPage = page;
                    updateTable();
                };
            }
            return btn;
        };

        controls.appendChild(createBtn('«', 1, false, currentPage === 1));
        
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                controls.appendChild(createBtn(i, i, i === currentPage));
            } else if (i === currentPage - 2 || i === currentPage + 2) {
                const span = document.createElement('span');
                span.className = 'text-slate-300 text-[10px]';
                span.textContent = '...';
                controls.appendChild(span);
            }
        }

        controls.appendChild(createBtn('»', totalPages, false, currentPage === totalPages));
    }

    searchInput.addEventListener('input', () => {
        const term = searchInput.value.toLowerCase();
        filteredRows = rows.filter(row => {
            const text = row.querySelector('.search-target').textContent.toLowerCase();
            return text.includes(term);
        });
        currentPage = 1;
        updateTable();
    });

    entriesSelect.addEventListener('change', () => {
        currentPage = 1;
        updateTable();
    });

    updateTable();
});
</script>
