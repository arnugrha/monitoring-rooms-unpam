<!-- Main Content Area -->
    <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
                <a href="<?= BASEURL ?>monitoringRuangan" class="hover:text-blue-500">Monitoring Ruangan</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Tambah Barang Ruangan</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
                Tambah Barang Baru ke Ruangan
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
                Tambahkan barang baru ke ruangan dengan pemilihan kategori yang lebih terorganisir.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
            <form action="<?= BASEURL; ?>monitoringRuangan/simpan" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Searchable Room Selection -->
                    <?php
                    $preselected_kode = $data['preselected_kode_ruangan'] ?? '';
                    $preselected_nama = '';
                    if (!empty($preselected_kode)) {
                        foreach ($data['ruangan'] as $r) {
                            if ($r['kode_ruangan'] === $preselected_kode) {
                                $preselected_nama = $r['nama_ruangan'];
                                break;
                            }
                        }
                    }
                    ?>
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
                                    value="<?= !empty($preselected_kode) ? "$preselected_nama ($preselected_kode)" : "" ?>"
                                    <?= !empty($preselected_kode) ? "disabled" : "" ?>
                                    class="w-full h-11 pl-10 pr-10 <?= !empty($preselected_kode) ? "bg-slate-100 cursor-not-allowed text-slate-500 pointer-events-none" : "bg-slate-50" ?> border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300"
                                >
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-300" id="room-arrow"><?= !empty($preselected_kode) ? "lock" : "expand_more" ?></span>
                            </div>
                            
                            <!-- Hidden actual input for POST -->
                            <input type="hidden" name="kode_ruangan" id="kode_ruangan" value="<?= $preselected_kode ?>" required>

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

                    <div id="items-container" class="space-y-6">
                        <!-- Initial Item Row -->
                        <div class="item-row p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-primary uppercase tracking-widest label-barang">Barang #1</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Kategori -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                                    <select class="category-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach($data['kategori'] as $kat) : ?>
                                            <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Nama Barang -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Barang</label>
                                    <select name="id_barang[]" required disabled class="item-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                        <option value="">Pilih Barang</option>
                                    </select>
                                </div>
                                <!-- Total -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Total Barang</label>
                                    <input name="total_barang[]" required class="w-full h-11 px-4 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 10" type="number" min="1"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add More Button -->
                    <button type="button" id="add-item-btn" class="flex items-center gap-2 text-primary font-bold text-sm hover:text-primary-dark transition-colors ml-1 w-fit">
                        <span class="material-symbols-outlined text-lg">add_circle</span>
                        Tambah Barang Lain?
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                    <a href="<?= BASEURL; ?>monitoringRuangan" class="w-full sm:w-auto px-6 h-11 flex items-center justify-center text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all">
                        Batal
                    </a>
                    <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">save</span>
                        Simpan Semua Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mt-8">
            <div class="bg-blue-50/50 p-5 rounded-lg flex flex-col gap-3 border border-blue-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                    <span class="material-symbols-outlined text-xl">category</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Filter Kategori</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Pilih kategori terlebih dahulu untuk mempermudah pencarian barang yang ingin ditambahkan.
                </p>
            </div>
            <div class="bg-emerald-50/50 p-5 rounded-lg flex flex-col gap-3 border border-emerald-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">search</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Cari Ruangan</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Gunakan fitur ketik pada kolom ruangan untuk mencari kode ruangan dengan cepat.
                </p>
            </div>
            <div class="bg-amber-50/50 p-5 rounded-lg flex flex-col gap-3 border border-amber-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-amber-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">verified_user</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Data Valid</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Pastikan semua data yang diinputkan sudah sesuai sebelum menekan tombol simpan.
                </p>
            </div>
        </div>
    </section>

    <script>
        // Data barang dari server
        const allBarang = <?= json_encode($data['barang']); ?>;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Room Searchable Dropdown Logic
            const roomContainer = document.getElementById('room-select-container');
            const roomSearchInput = document.getElementById('room-search');
            const roomDropdown = document.getElementById('room-dropdown');
            const roomHiddenInput = document.getElementById('kode_ruangan');
            const roomArrow = document.getElementById('room-arrow');
            const roomOptions = document.querySelectorAll('.room-option');
            const roomNoResult = document.getElementById('no-room-result');

            // Toggle Dropdown
            roomSearchInput.addEventListener('click', (e) => {
                e.stopPropagation();
                roomDropdown.classList.remove('hidden');
                roomArrow.classList.add('rotate-180');
            });

            // Filter logic
            roomSearchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                let hasVisible = false;

                roomOptions.forEach(opt => {
                    const searchData = opt.getAttribute('data-search');
                    if (searchData.includes(term)) {
                        opt.classList.remove('hidden');
                        hasVisible = true;
                    } else {
                        opt.classList.add('hidden');
                    }
                });

                roomNoResult.classList.toggle('hidden', hasVisible);
                roomDropdown.classList.remove('hidden');
                roomArrow.classList.add('rotate-180');
            });

            // Select logic
            roomOptions.forEach(opt => {
                opt.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('span:first-child').textContent;
                    
                    roomSearchInput.value = `${text} (${value})`;
                    roomHiddenInput.value = value;
                    roomDropdown.classList.add('hidden');
                    roomArrow.classList.remove('rotate-180');
                });
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!roomContainer.contains(e.target)) {
                    roomDropdown.classList.add('hidden');
                    roomArrow.classList.remove('rotate-180');
                }
            });

            const container = document.getElementById('items-container');
            const addBtn = document.getElementById('add-item-btn');
            
            // Inisialisasi baris pertama
            initRow(container.querySelector('.item-row'));

            addBtn.addEventListener('click', function() {
                const rowCount = container.querySelectorAll('.item-row').length + 1;
                const newRow = document.createElement('div');
                newRow.className = 'item-row p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-4 animate-in fade-in slide-in-from-top-2 duration-300';
                newRow.innerHTML = `
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest label-barang">Barang #${rowCount}</span>
                        <button type="button" class="remove-item-btn text-rose-500 hover:text-rose-700 transition-colors">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                            <select class="category-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                <option value="">Pilih Kategori</option>
                                <?php foreach($data['kategori'] as $kat) : ?>
                                    <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Barang</label>
                            <select name="id_barang[]" required disabled class="item-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                <option value="">Pilih Barang</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Total Barang</label>
                            <input name="total_barang[]" required class="w-full h-11 px-4 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 10" type="number" min="1"/>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                initRow(newRow);
            });

            function initRow(row) {
                const categorySelect = row.querySelector('.category-select');
                const itemSelect = row.querySelector('.item-select');
                const removeBtn = row.querySelector('.remove-item-btn');

                categorySelect.addEventListener('change', function() {
                    const categoryId = this.value;
                    
                    // Clear and disable if no category selected
                    if (!categoryId) {
                        itemSelect.innerHTML = '<option value="">Pilih Barang</option>';
                        itemSelect.disabled = true;
                        return;
                    }

                    // Filter barang by category
                    const filteredBarang = allBarang.filter(b => b.id_kategori == categoryId);
                    
                    // Update item select
                    let options = '<option value="">Pilih Barang</option>';
                    filteredBarang.forEach(b => {
                        options += `<option value="${b.id_barang}">${b.nama_barang}</option>`;
                    });
                    
                    itemSelect.innerHTML = options;
                    itemSelect.disabled = false;
                });

                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        row.remove();
                        reorderLabels();
                    });
                }
            }

            function reorderLabels() {
                const rows = container.querySelectorAll('.item-row');
                rows.forEach((row, index) => {
                    row.querySelector('.label-barang').textContent = `Barang #${index + 1}`;
                });
            }
        });
    </script>