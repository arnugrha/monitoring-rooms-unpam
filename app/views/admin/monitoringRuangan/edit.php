<!-- Main Content Area -->
    <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
                <a href="<?= BASEURL ?>monitoringRuangan" class="hover:text-blue-500">Monitoring Ruangan</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Edit Barang Ruangan</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
                Edit Barang di Ruangan: <?= $data['ruangan_selected']['kode_ruangan']; ?>
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
                Ubah atau tambahkan barang pada ruangan ini dengan pemilihan kategori yang terorganisir.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
            <form action="<?= BASEURL; ?>monitoringRuangan/simpanUbah" method="POST" class="space-y-6">
                <input type="hidden" name="kode_ruangan" value="<?= $data['ruangan_selected']['kode_ruangan']; ?>">
                
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Ruangan</label>
                        <div class="relative">
                            <select disabled class="w-full h-11 px-4 bg-slate-100 border border-slate-300 text-slate-500 rounded-lg appearance-none outline-none text-sm text-on-surface">
                                <option selected><?= $data['ruangan_selected']['kode_ruangan']; ?></option>
                            </select>
                            <p class="text-[10px] text-slate-400 mt-1 ml-1">* Ruangan tidak dapat diubah saat mengedit detail barang.</p>
                        </div>
                    </div>

                    <div id="items-container" class="space-y-6">
                        <?php if (empty($data['barang_ruangan'])) : ?>
                            <!-- Initial Item Row if empty -->
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
                        <?php else : ?>
                            <?php foreach($data['barang_ruangan'] as $index => $item) : ?>
                                <div class="item-row p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest label-barang">Barang #<?= $index + 1; ?></span>
                                        <?php if ($index > 0) : ?>
                                            <button type="button" class="remove-item-btn text-rose-500 hover:text-rose-700 transition-colors">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Kategori -->
                                        <div class="space-y-2">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                                            <select class="category-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                                <option value="">Pilih Kategori</option>
                                                <?php foreach($data['kategori'] as $kat) : ?>
                                                    <option value="<?= $kat['id_kategori']; ?>" <?= ($kat['id_kategori'] == $item['id_kategori']) ? 'selected' : ''; ?>>
                                                        <?= $kat['nama_kategori']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- Nama Barang -->
                                        <div class="space-y-2">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Barang</label>
                                            <select name="id_barang[]" required class="item-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs" data-selected="<?= $item['id_barang']; ?>">
                                                <option value="">Pilih Barang</option>
                                            </select>
                                        </div>
                                        <!-- Total -->
                                        <div class="space-y-2">
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Total Barang</label>
                                            <input name="total_barang[]" value="<?= $item['total_barang']; ?>" required class="w-full h-11 px-4 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 10" type="number" min="1"/>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                        Simpan Perubahan
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
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Grup Kategori</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Barang kini dikelompokkan berdasarkan kategori untuk memudahkan manajemen data.
                </p>
            </div>
            <div class="bg-emerald-50/50 p-5 rounded-lg flex flex-col gap-3 border border-emerald-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">sync</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Auto Refresh</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Daftar barang akan otomatis diperbarui setiap kali Anda mengganti kategori.
                </p>
            </div>
            <div class="bg-amber-50/50 p-5 rounded-lg flex flex-col gap-3 border border-amber-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-amber-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">verified_user</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Audit Log</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Setiap perubahan jumlah atau jenis barang akan tercatat dalam log aktivitas.
                </p>
            </div>
        </div>
    </section>

    <script>
        // Data barang dari server
        const allBarang = <?= json_encode($data['barang']); ?>;
        
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('items-container');
            const addBtn = document.getElementById('add-item-btn');
            
            // Inisialisasi baris yang sudah ada
            container.querySelectorAll('.item-row').forEach(row => {
                initRow(row);
                
                // Jika sudah ada kategori terpilih (saat edit), trigger filter manual
                const categorySelect = row.querySelector('.category-select');
                if (categorySelect.value) {
                    const itemSelect = row.querySelector('.item-select');
                    const selectedId = itemSelect.getAttribute('data-selected');
                    filterItems(categorySelect.value, itemSelect, selectedId);
                }
            });

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
                updateRemoveButtons();
            });

            function initRow(row) {
                const categorySelect = row.querySelector('.category-select');
                const itemSelect = row.querySelector('.item-select');
                const removeBtn = row.querySelector('.remove-item-btn');

                categorySelect.addEventListener('change', function() {
                    filterItems(this.value, itemSelect);
                });

                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        row.remove();
                        reorderLabels();
                        updateRemoveButtons();
                    });
                }
            }

            function filterItems(categoryId, itemSelect, selectedId = null) {
                if (!categoryId) {
                    itemSelect.innerHTML = '<option value="">Pilih Barang</option>';
                    itemSelect.disabled = true;
                    return;
                }

                const filteredBarang = allBarang.filter(b => b.id_kategori == categoryId);
                let options = '<option value="">Pilih Barang</option>';
                filteredBarang.forEach(b => {
                    const selected = (selectedId && b.id_barang == selectedId) ? 'selected' : '';
                    options += `<option value="${b.id_barang}" ${selected}>${b.nama_barang}</option>`;
                });
                
                itemSelect.innerHTML = options;
                itemSelect.disabled = false;
            }

            function updateRemoveButtons() {
                const rows = container.querySelectorAll('.item-row');
                rows.forEach((row, index) => {
                    let removeBtn = row.querySelector('.remove-item-btn');
                    if (index === 0 && removeBtn) {
                        removeBtn.remove();
                    } else if (index > 0 && !removeBtn) {
                        const header = row.querySelector('.flex.justify-between.items-center');
                        const newBtn = document.createElement('button');
                        newBtn.type = 'button';
                        newBtn.className = 'remove-item-btn text-rose-500 hover:text-rose-700 transition-colors';
                        newBtn.innerHTML = '<span class="material-symbols-outlined text-lg">delete</span>';
                        header.appendChild(newBtn);
                        newBtn.addEventListener('click', function() {
                            row.remove();
                            reorderLabels();
                            updateRemoveButtons();
                        });
                    }
                });
            }

            function reorderLabels() {
                const rows = container.querySelectorAll('.item-row');
                rows.forEach((row, index) => {
                    row.querySelector('.label-barang').textContent = `Barang #${index + 1}`;
                });
            }
        });
    </script>
