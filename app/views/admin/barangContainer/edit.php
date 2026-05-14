<!-- Main Content Area -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[1000px] mx-auto">
    <!-- Header Section -->
    <div class="mb-8 text-center sm:text-left">
        <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
            <a href="<?= BASEURL ?>BarangContainer" class="hover:text-blue-500">Monitoring Barang Container</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Edit Isi Container</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
            Update Isi: <?= $data['container_info']['nama_barang']; ?>
        </h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
            Sesuaikan barang-barang yang tersimpan di dalam unit <?= $data['container_info']['nama_barang']; ?>.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
        <form action="<?= BASEURL; ?>BarangContainer/prosesEdit" method="POST" class="space-y-6">
            <input type="hidden" name="id_container" value="<?= $data['container_info']['id_container']; ?>">
            
            <div class="grid grid-cols-1 gap-6">
                
                <!-- Container Info (Readonly) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Unit Container</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">inventory_2</span>
                        <input type="text" readonly 
                            class="w-full h-11 pl-10 pr-4 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-500 outline-none"
                            value="<?= $data['container_info']['nama_barang']; ?> - <?= $data['container_info']['nama_ruangan']; ?> (<?= $data['container_info']['kode_ruangan']; ?>)">
                    </div>
                </div>

                <!-- Dynamic Items Container -->
                <div id="items-container" class="space-y-4">
                    <?php if (!empty($data['current_items'])) : ?>
                        <?php foreach ($data['current_items'] as $index => $item) : ?>
                        <div class="item-row p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-primary uppercase tracking-widest label-barang">Barang #<?= $index + 1; ?></span>
                                <button type="button" class="remove-item-btn text-rose-500 hover:text-rose-700 transition-colors">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Kategori -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori</label>
                                    <?php 
                                        // Find category of current item
                                        $current_item_master = array_filter($data['barang'], function($b) use ($item) {
                                            return $b['id_barang'] == $item['id_barang'];
                                        });
                                        $current_item_master = reset($current_item_master);
                                        $current_kat_id = $current_item_master ? $current_item_master['id_kategori'] : '';
                                    ?>
                                    <select class="category-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach($data['kategori'] as $kat) : ?>
                                            <option value="<?= $kat['id_kategori']; ?>" <?= ($kat['id_kategori'] == $current_kat_id) ? 'selected' : ''; ?>>
                                                <?= $kat['nama_kategori']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Nama Barang -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Barang</label>
                                    <select name="id_barang[]" required class="item-select w-full h-11 px-4 bg-white border border-slate-200 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-xs">
                                        <option value="<?= $item['id_barang']; ?>"><?= $item['nama_barang']; ?></option>
                                        <?php 
                                            // Show other items in the same category
                                            foreach ($data['barang'] as $b) {
                                                if ($b['id_kategori'] == $current_kat_id && $b['id_barang'] != $item['id_barang']) {
                                                    echo "<option value='{$b['id_barang']}'>{$b['nama_barang']}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <!-- Total Barang -->
                                <div class="space-y-2">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Total Barang</label>
                                    <input name="total_barang[]" required value="<?= ($item['kondisi_baik'] + $item['kondisi_rusak']); ?>" min="1" class="w-full h-11 px-4 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface" type="number"/>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- If empty, show one empty row -->
                        <div class="item-row p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-primary uppercase tracking-widest label-barang">Barang #1</span>
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
                                    <input name="total_barang[]" required value="1" min="1" class="w-full h-11 px-4 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface" type="number"/>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Add More Button -->
                <button type="button" id="add-item-btn" class="flex items-center gap-2 text-primary font-bold text-sm hover:text-primary-dark transition-colors ml-1 w-fit">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    Tambah Baris Barang?
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                <a href="<?= BASEURL; ?>BarangContainer" class="w-full sm:w-auto px-6 h-11 flex items-center justify-center text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all">
                    Batal
                </a>
                <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">save</span>
                    Perbarui Isi Container
                </button>
            </div>
        </form>
    </div>

    <script>
        const allBarang = <?= json_encode($data['barang']); ?>;
        
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('items-container');
            const addBtn = document.getElementById('add-item-btn');
            
            // Initialize existing rows
            container.querySelectorAll('.item-row').forEach(row => initRow(row));

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
                            <input name="total_barang[]" required value="1" min="1" class="w-full h-11 px-4 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface" type="number"/>
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
                    if (!categoryId) {
                        itemSelect.innerHTML = '<option value="">Pilih Barang</option>';
                        itemSelect.disabled = true;
                        return;
                    }
                    const filteredBarang = allBarang.filter(b => b.id_kategori == categoryId);
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
</section>
