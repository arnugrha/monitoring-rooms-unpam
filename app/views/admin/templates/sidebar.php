<!-- SideNavBar (Drawer for Mobile, Fixed Sidebar for Desktop) -->
<aside id="main-sidebar" class="fixed left-0 top-0 h-screen w-60 bg-slate-50 flex flex-col p-5 z-50 border-r border-slate-200/60 transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <div class="flex items-center justify-between mb-8 px-2">
        <div>
            <h1 class="text-lg font-bold text-blue-900 font-headline">Admin Central</h1>
            <p class="text-[10px] text-slate-500 font-medium tracking-wide uppercase">Monitoring Rooms</p>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden p-1 hover:bg-slate-200 rounded-full transition-colors text-slate-500">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>
    <nav id="sidebar-nav" class="flex-1 space-y-1">
        <a href="<?= BASEURL; ?>dashboard" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors group">
            <span class="material-symbols-outlined text-xl">dashboard</span>
            <span class="text-sm font-headline">Dashboard</span>
        </a>
        <a href="<?= BASEURL; ?>users" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors group">
            <span class="material-symbols-outlined text-xl">group</span>
            <span class="text-sm font-headline">User</span>
        </a>

        <!-- Master Data Dropdown -->
        <div class="dropdown-container flex flex-col-reverse">
            <div id="master-data" class="dropdown-menu grid grid-rows-[0fr] opacity-0 transition-all duration-500 ease-in-out ml-6 pl-4 border-l border-slate-200 mb-1">
                <div class="overflow-hidden space-y-1">
                    <a href="<?= BASEURL; ?>kelolaBarang" class="flex items-center gap-3 px-3.5 py-2 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-sm">inventory_2</span>
                        <span class="text-sm font-headline">Master Data Barang</span>
                    </a>
                    <a href="<?= BASEURL; ?>kelolaRuangan" class="flex items-center gap-3 px-3.5 py-2 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-sm">meeting_room</span>
                        <span class="text-sm font-headline">Master Data Ruangan</span>
                    </a>
                    <a href="<?= BASEURL; ?>container" class="flex items-center gap-3 px-3.5 py-2 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-sm">meeting_room</span>
                        <span class="text-sm font-headline">Master Data Container</span>
                    </a>
                </div>
            </div>
            <button class="dropdown-trigger flex items-center justify-between w-full px-3.5 py-2.5 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors group" data-dropdown="master-data">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-xl">database</span>
                    <span class="text-sm font-headline">Master Data</span>
                </div>
                <span class="material-symbols-outlined text-sm transition-transform duration-200 chevron inline-block">expand_more</span>
            </button>
        </div>

        <!-- Monitoring Dropdown -->
        <div class="dropdown-container flex flex-col-reverse">
            <div id="monitoring" class="dropdown-menu grid grid-rows-[0fr] opacity-0 transition-all duration-500 ease-in-out ml-6 pl-4 border-l border-slate-200 mb-1">
                <div class="overflow-hidden space-y-1">
                    <a href="<?= BASEURL; ?>MonitoringRuangan" class="flex items-center gap-3 px-3.5 py-2 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-sm">analytics</span>
                        <span class="text-sm font-headline">Barang Ruangan</span>
                    </a>
                    <a href="<?= BASEURL; ?>KelolaPersetujuan" class="flex items-center gap-3 px-3.5 py-2 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-sm">fact_check</span>
                        <span class="text-sm font-headline">Persetujuan</span>
                    </a>
                    <a href="<?= BASEURL; ?>BarangContainer" class="flex items-center gap-3 px-3.5 py-2 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-sm">inventory_2</span>
                        <span class="text-sm font-headline">Barang Container</span>
                    </a>
                </div>
            </div>
            <button class="dropdown-trigger flex items-center justify-between w-full px-3.5 py-2.5 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors group" data-dropdown="monitoring">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-xl">query_stats</span>
                    <span class="text-sm font-headline">Monitoring</span>
                </div>
                <span class="material-symbols-outlined text-sm transition-transform duration-200 chevron inline-block">expand_more</span>
            </button>
        </div>

        <a href="<?= BASEURL; ?>kelolaLaporan" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
            <span class="material-symbols-outlined text-xl">assessment</span>
            <span class="text-sm font-headline">Kelola Laporan</span>
        </a>
        <a href="<?= BASEURL; ?>historyExport" class="flex items-center gap-3 px-3.5 py-2.5 text-slate-600 hover:bg-slate-200/50 rounded-lg transition-colors">
            <span class="material-symbols-outlined text-xl">history</span>
            <span class="text-sm font-headline">History Export</span>
        </a>
    </nav>
</aside>
<!-- Main Content Area -->
<main class="lg:ml-60 min-h-screen transition-all">