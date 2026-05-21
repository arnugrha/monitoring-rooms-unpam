<!-- Main Content Area -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
    <!-- Header Section -->
    <div class="mb-8 text-center sm:text-left">
        <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
            <a href="<?= BASEURL ?>index.php?url=container/index" class="hover:text-blue-500">Kelola Container</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Tambah Container</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
            Tambah Container Baru
        </h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed text-balance">
            Daftarkan unit penyimpanan baru (lemari, loker, rak) ke dalam ruangan sebagai master data.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
        <form action="<?= BASEURL; ?>index.php?url=container/prosesTambah" method="post" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                
                <!-- Searchable Room Dropdown -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Pilih Ruangan</label>
                    <div class="relative custom-select-container" id="room-select-container">
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-primary transition-colors">meeting_room</span>
                            <input 
                                type="text" 
                                id="room-search"
                                placeholder="Ketik/Cari Ruangan..."
                                autocomplete="off"
                                class="w-full h-11 pl-10 pr-10 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300"
                            >
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-300" id="room-arrow">expand_more</span>
                        </div>
                        
                        <!-- Hidden actual input for POST -->
                        <input type="hidden" name="kode_ruangan" id="kode_ruangan" required>

                        <!-- Dropdown List -->
                        <div id="room-dropdown" class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl max-h-60 overflow-y-auto hidden">
                            <?php foreach($data['ruangan'] as $r) : ?>
                                <div 
                                    class="px-4 py-2.5 hover:bg-slate-50 cursor-pointer text-sm text-slate-700 flex justify-between items-center transition-colors room-option"
                                    data-value="<?= $r['kode_ruangan']; ?>"
                                    data-search="<?= strtolower($r['nama_ruangan'] . ' ' . $r['kode_ruangan']); ?>"
                                >
                                    <span><?= $r['nama_ruangan']; ?></span>
                                    <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded"><?= $r['kode_ruangan']; ?></span>
                                </div>
                            <?php endforeach; ?>
                            <div id="no-room-result" class="px-4 py-3 text-sm text-slate-400 italic hidden text-center">
                                Ruangan tidak ditemukan...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nama Container (Item Type Selection) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Container</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-primary transition-colors">inventory_2</span>
                        <select name="id_barang" required
                            class="w-full h-11 pl-10 pr-4 bg-slate-50 border border-slate-200 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface">
                            <option value="" disabled selected>Pilih Jenis/Nama Container</option>
                            <?php foreach ($data['barang'] as $b) : ?>
                                <option value="<?= $b['id_barang']; ?>"><?= $b['nama_barang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                <a href="<?= BASEURL; ?>index.php?url=container/index" class="w-full sm:w-auto px-6 h-11 flex items-center justify-center text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all">
                    Batal
                </a>
                <button 
                    class="w-full sm:w-auto px-6 h-11 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-all flex items-center justify-center gap-2 text-sm" 
                    type="submit"
                    name="submit_action"
                    value="save"
                >
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Saja
                </button>
                <button 
                    class="w-full sm:w-auto px-8 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" 
                    type="submit"
                    name="submit_action"
                    value="save_and_add"
                >
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                    Simpan & Tambah Barang
                </button>
            </div>
        </form>
    </div>

    <!-- Script for Searchable Dropdown -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('room-select-container');
            const searchInput = document.getElementById('room-search');
            const hiddenInput = document.getElementById('kode_ruangan');
            const dropdown = document.getElementById('room-dropdown');
            const arrow = document.getElementById('room-arrow');
            const options = document.querySelectorAll('.room-option');
            const noResult = document.getElementById('no-room-result');

            // Toggle dropdown
            searchInput.addEventListener('click', () => {
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            });

            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                }
            });

            // Filter logic
            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                let hasMatch = false;

                options.forEach(opt => {
                    if (opt.dataset.search.includes(term)) {
                        opt.classList.remove('hidden');
                        hasMatch = true;
                    } else {
                        opt.classList.add('hidden');
                    }
                });

                noResult.classList.toggle('hidden', hasMatch);
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            });

            // Option selection
            options.forEach(opt => {
                opt.addEventListener('click', () => {
                    const value = opt.dataset.value;
                    const text = opt.querySelector('span:first-child').textContent;
                    
                    searchInput.value = text + ' (' + value + ')';
                    hiddenInput.value = value;
                    
                    dropdown.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                });
            });
        });
    </script>
</section>
