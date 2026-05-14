<!-- Main Content Area -->
<section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
    <!-- Header Section -->
    <div class="mb-8 text-center sm:text-left">
        <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
            <a href="<?= BASEURL ?>kelolaLaporan" class="hover:text-blue-500">Kelola Laporan</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Buat Laporan Baru</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
            Buat Laporan Inventaris
        </h1>
        <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
            Admin dapat membuat laporan kerusakan atau pemeliharaan secara langsung.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
        <form action="<?= BASEURL; ?>kelolaLaporan/prosesTambah" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ruangan (Searchable) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Ruangan</label>
                    <div class="relative">
                        <input list="list_ruangan" id="room_search" name="kode_ruangan" required 
                            class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-400" 
                            placeholder="Cari kode ruangan...">
                        <datalist id="list_ruangan">
                            <?php foreach($data['ruangan'] as $r) : ?>
                                <option value="<?= $r['kode_ruangan']; ?>"><?= $r['nama_ruangan']; ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                </div>

                <!-- Jenis Laporan -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Jenis Laporan</label>
                    <select name="jenis_laporan" required class="w-full h-11 px-4 bg-slate-50 border border-slate-300 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm">
                        <option value="Rusak">Kerusakan (Rusak)</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Kategori (Cascading) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kategori Barang</label>
                    <select id="category_select" required class="w-full h-11 px-4 bg-slate-50 border border-slate-300 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm">
                        <option value="">Pilih Kategori</option>
                        <?php foreach($data['kategori'] as $kat) : ?>
                            <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Barang (Cascading) -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Barang</label>
                    <select name="id_barang" id="item_select" required disabled class="w-full h-11 px-4 bg-slate-50 border border-slate-300 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm">
                        <option value="">Pilih Barang</option>
                    </select>
                </div>

                <!-- Jumlah Barang -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Jumlah</label>
                    <input name="jumlah_barang" type="number" min="1" value="1" required class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface">
                </div>

                <!-- Status Laporan -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Status Awal</label>
                    <select name="status_laporan" required class="w-full h-11 px-4 bg-slate-50 border border-slate-300 text-slate-600 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm">
                        <option value="Baru">Baru</option>
                        <option value="Proses">Dalam Proses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Deskripsi Masalah</label>
                <textarea name="deskripsi" required rows="4" class="w-full p-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 transition-all outline-none text-sm text-on-surface placeholder:text-slate-400" placeholder="Jelaskan detail kerusakan atau masalah barang..."></textarea>
            </div>

            <!-- Upload Foto -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Foto Bukti (Opsional)</label>
                <div class="relative group">
                    <input type="file" name="foto" accept="image/*" class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer text-xs text-slate-500 pt-2">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                <a href="<?= BASEURL; ?>kelolaLaporan" class="w-full sm:w-auto px-6 h-11 flex items-center justify-center text-slate-500 font-bold text-sm hover:bg-slate-50 rounded-lg transition-all">
                    Batal
                </a>
                <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">send</span>
                    Simpan Laporan
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    // Data barang global (untuk fallback atau referensi jika diperlukan)
    const allBarang = <?= json_encode($data['barang']); ?>;
    let roomItems = []; // Menyimpan barang yang ada di ruangan terpilih
    
    document.addEventListener('DOMContentLoaded', function() {
        const roomInput = document.getElementById('room_search');
        const categorySelect = document.getElementById('category_select');
        const itemSelect = document.getElementById('item_select');

        // Fungsi untuk mengambil barang berdasarkan ruangan
        async function fetchRoomItems(kodeRuangan) {
            if (!kodeRuangan) {
                roomItems = [];
                resetFilters();
                return;
            }

            try {
                const response = await fetch(`<?= BASEURL; ?>kelolaLaporan/getBarangByRuangan/${kodeRuangan}`);
                const data = await response.json();
                roomItems = data;
                
                // Reset category and items when room changes
                categorySelect.value = '';
                itemSelect.innerHTML = '<option value="">Pilih Barang</option>';
                itemSelect.disabled = true;
            } catch (error) {
                console.error('Error fetching room items:', error);
                roomItems = [];
            }
        }

        function resetFilters() {
            categorySelect.value = '';
            itemSelect.innerHTML = '<option value="">Pilih Barang</option>';
            itemSelect.disabled = true;
        }

        // Listener untuk perubahan ruangan
        roomInput.addEventListener('input', function() {
            const val = this.value;
            const options = document.getElementById('list_ruangan').options;
            let found = false;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === val) {
                    found = true;
                    break;
                }
            }
            
            if (found) {
                fetchRoomItems(val);
            } else {
                roomItems = [];
                resetFilters();
            }
        });

        // Listener untuk perubahan kategori
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            if (!categoryId || roomItems.length === 0) {
                itemSelect.innerHTML = '<option value="">Pilih Barang</option>';
                itemSelect.disabled = true;
                return;
            }

            // Filter barang yang ada di ruangan TERPILIH dan kategori TERPILIH
            const filteredBarang = roomItems.filter(b => b.id_kategori == categoryId);
            
            let options = '<option value="">Pilih Barang</option>';
            if (filteredBarang.length > 0) {
                filteredBarang.forEach(b => {
                    // Cari nama barang dari data global allBarang karena roomItems mungkin hanya punya ID
                    const barangDetail = allBarang.find(item => item.id_barang == b.id_barang);
                    const namaBarang = barangDetail ? barangDetail.nama_barang : 'Barang tidak dikenal';
                    options += `<option value="${b.id_barang}">${namaBarang}</option>`;
                });
                itemSelect.disabled = false;
            } else {
                options = '<option value="">Tidak ada barang di kategori ini</option>';
                itemSelect.disabled = true;
            }
            
            itemSelect.innerHTML = options;
        });
    });
</script>
