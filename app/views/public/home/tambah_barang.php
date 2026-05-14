<body class="bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container min-h-screen pb-16 md:pb-0">
<!-- TopAppBar -->
<header class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-4 md:px-8 py-3 md:py-4 bg-white/70 backdrop-blur-xl shadow-sm">
    <div class="flex items-center gap-4">
        <h1 class="text-lg md:text-xl font-black text-blue-800 font-headline tracking-tight">Tambah Barang - <?= $data['ruangan']['nama_ruangan'] ?? 'Ruangan'; ?></h1>
    </div>
    <div class="flex items-center gap-2 md:gap-4">
        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full overflow-hidden border-2 border-primary-container">
            <img alt="User profile" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name=<?= urlencode(Session::user()['nama_lengkap']); ?>&background=random"/>
        </div>
    </div>
</header>

<!-- Main Content Canvas -->
<main class="pt-20 md:pt-28 pb-20 md:pb-24 px-4 md:px-6 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- Header Text -->
        <div class="mb-8 md:mb-10 text-center md:text-left">
            <p class="text-primary font-semibold text-xs md:text-sm tracking-widest uppercase mb-2">Request Form</p>
            <h2 class="text-3xl md:text-4xl font-extrabold text-on-surface font-headline leading-tight">Pengajuan Barang Baru</h2>
            <p class="text-secondary mt-2 max-w-md mx-auto md:mx-0 text-sm md:text-base">Silakan pilih barang dan tentukan jumlah yang ingin ditambahkan ke ruangan <?= $data['ruangan']['nama_ruangan'] ?? 'Ruangan'; ?>.</p>
        </div>
        
        <!-- Form Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 md:p-10 lg:p-12 shadow-[0_12px_32px_rgba(25,28,29,0.06)]">
            <form action="<?= BASEURL; ?>index.php?url=Home/prosesTambahBarang" method="POST" class="space-y-8">
                
                <input type="hidden" name="kode_ruangan" value="<?= $data['ruangan']['kode_ruangan']; ?>">

                <div id="item-container" class="space-y-6">
                    <!-- Initial Item Row -->
                    <div class="item-row p-4 bg-surface-container-low rounded-xl border border-outline-variant/30 relative group">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Barang -->
                            <div>
                                <label class="block text-sm font-bold text-on-surface mb-2">Nama Barang</label>
                                <select name="id_barang[]" required class="w-full bg-white border-none rounded-md px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer text-sm outline-none">
                                    <option value="">Pilih barang...</option>
                                    <?php foreach($data['barang_list'] as $barang) : ?>
                                        <option value="<?= $barang['id_barang']; ?>"><?= $barang['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Jumlah Barang -->
                            <div>
                                <label class="block text-sm font-bold text-on-surface mb-2">Jumlah</label>
                                <input type="number" name="total_barang[]" value="1" min="1" required class="w-full bg-white border-none rounded-md px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary/20 transition-all text-sm outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add More Button -->
                <div class="flex justify-center">
                    <button type="button" id="add-item" class="flex items-center gap-2 text-primary hover:text-blue-700 font-bold text-sm transition-all py-2 px-4 rounded-lg hover:bg-primary/5">
                        <span class="material-symbols-outlined text-lg">add_circle</span>
                        Tambah Barang Lain
                    </button>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-6 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 text-xs text-secondary self-start sm:self-auto">
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">info</span>
                        <span>Pengajuan akan ditinjau oleh Admin.</span>
                    </div>
                    <div class="flex gap-3 w-full sm:w-auto justify-center items-center">
                        <a href="<?= BASEURL ?>index.php?url=Home" class="flex-1 sm:flex-none px-6 py-3 border border-outline-variant text-on-surface font-bold rounded-full hover:bg-surface-container-low transition-all text-center text-sm">
                            Batal
                        </a>
                        <button class="flex-1 sm:flex-none px-8 whitespace-nowrap py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-full active:scale-95 transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 text-sm" type="submit">
                            Kirim Pengajuan
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">send</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('item-container');
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        // Reset values
        newRow.querySelector('select').value = '';
        newRow.querySelector('input').value = '1';
        
        // Add remove button to new rows
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-all';
        removeBtn.innerHTML = '<span class="material-symbols-outlined text-xs">close</span>';
        removeBtn.onclick = function() {
            newRow.remove();
        };
        newRow.appendChild(removeBtn);
        
        container.appendChild(newRow);
    });
</script>
</body>
</html>
