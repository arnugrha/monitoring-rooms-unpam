<body class="bg-surface text-on-surface selection:bg-primary-container selection:text-on-primary-container min-h-screen pb-16 md:pb-0">
<!-- TopAppBar -->
<header class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-4 md:px-8 py-3 md:py-4 bg-white/70 backdrop-blur-xl shadow-sm">
    <div class="flex items-center gap-4">
        <h1 class="text-lg md:text-xl font-black text-blue-800 font-headline tracking-tight">Buat Laporan - <?= $data['ruangan']['nama_ruangan'] ?? 'Ruangan'; ?></h1>
    </div>
    <div class="flex items-center gap-2 md:gap-4">
        <div class="hidden sm:flex items-center bg-surface-container px-4 py-2 rounded-full">
            <span class="material-symbols-outlined text-slate-400 text-sm">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-sm w-48 focus:outline-none" placeholder="Cari laporan..." type="text"/>
        </div>
        <button class="p-2 hover:bg-slate-100 rounded-full transition-all duration-300">
            <span class="material-symbols-outlined text-slate-600">notifications</span>
        </button>
        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full overflow-hidden border-2 border-primary-container">
            <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAvltUebAn6fxbUAopbMYXpNgcDNmhS_eY7IE8RcwR3X34nI7oEMkIW6QB1Ayx7LcUmh2-v2Q4KSQvnnENZeMli1SLTHejSvocYjrZGksxefU4-WbmANYZw56oQO0HiCG0jMoa6fkRIQZBgByvpfgfNk0dTmPcK7V1rjI5lNasX3HjFQMt74GdOktNDsFMfIYSSpRpmfJk4tdmwJf5h3uXhV8c45HYCjdzdyYAw8xom_gt_8oU8-A-IKzhBK2456cQ0EZPXxlzakhxm"/>
        </div>
    </div>
</header>

<!-- Main Content Canvas -->
<main class="pt-20 md:pt-28 pb-20 md:pb-24 px-4 md:px-6 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- Header Text -->
        <div class="mb-8 md:mb-10 text-center md:text-left">
            <p class="text-primary font-semibold text-xs md:text-sm tracking-widest uppercase mb-2">Submission Form</p>
            <h2 class="text-3xl md:text-4xl font-extrabold text-on-surface font-headline leading-tight">Lapor Kerusakan</h2>
            <p class="text-secondary mt-2 max-w-md mx-auto md:mx-0 text-sm md:text-base">Silakan isi detail laporan untuk barang di <?= $data['ruangan']['nama_ruangan'] ?? 'Ruangan'; ?> (<?= $data['ruangan']['kode_ruangan'] ?? '-'; ?>) dengan tepat.</p>
        </div>
        
        <!-- Form Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 md:p-10 lg:p-12 shadow-[0_12px_32px_rgba(25,28,29,0.06)]">
            <form action="<?= BASEURL; ?>index.php?url=Home/prosesLaporan" method="POST" enctype="multipart/form-data" class="space-y-8 md:space-y-10">
                
                <input type="hidden" name="id_user" value="<?= $data['user']['id_user']; ?>">
                <input type="hidden" name="kode_ruangan" value="<?= $data['ruangan']['kode_ruangan']; ?>">
                <?php if(isset($data['id_container'])): ?>
                    <input type="hidden" name="id_container" value="<?= $data['id_container']; ?>">
                <?php endif; ?>

                <!-- Nama Barang -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                    <div>
                        <label class="font-headline font-bold text-on-surface text-base md:text-lg">Nama Barang</label>
                        <p class="text-xs text-outline mt-1 leading-relaxed">Pilih barang yang bermasalah dari <?= isset($data['id_container']) ? 'isi container ini' : 'inventaris ruangan ini'; ?>.</p>
                    </div>
                    <div class="md:col-span-2">
                        <select name="id_barang" id="id_barang" required class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 md:py-4 text-on-surface focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all cursor-pointer text-sm md:text-base outline-none">
                            <option value="" data-stock="0">Pilih barang...</option>
                            <?php foreach($data['items'] as $item) : ?>
                                <option value="<?= $item['id_barang']; ?>" data-stock="<?= $item['kondisi_baik']; ?>"><?= $item['nama_barang']; ?> (Tersedia: <?= $item['kondisi_baik']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Jumlah Barang -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                    <div>
                        <label class="font-headline font-bold text-on-surface text-base md:text-lg">Jumlah</label>
                        <p class="text-xs text-outline mt-1 leading-relaxed">Jumlah barang yang dilaporkan.</p>
                    </div>
                    <div class="md:col-span-2">
                        <input type="number" name="jumlah_barang" id="jumlah_barang" value="1" min="1" required class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 md:py-4 text-on-surface focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-sm md:text-base outline-none">
                        <p id="stock-error" class="text-red-500 text-xs font-bold mt-2 hidden flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">warning</span>
                            Jumlah melebihi stok tersedia!
                        </p>
                    </div>
                </div>
                
                <!-- Jenis Laporan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                    <div>
                        <label class="font-headline font-bold text-on-surface text-base md:text-lg">Jenis Laporan</label>
                        <p class="text-xs text-outline mt-1 leading-relaxed">Kategori masalah yang dilaporkan.</p>
                    </div>
                    <div class="md:col-span-2 flex flex-col gap-4">
                        <div class="flex flex-wrap gap-3 md:gap-4">
                            <label class="flex-1 min-w-[100px] md:min-w-[120px] cursor-pointer">
                                <input checked="" name="jenis_laporan" class="hidden peer" type="radio" value="rusak" onchange="toggleOtherInput(this)"/>
                                <div class="px-4 md:px-6 py-3 md:py-4 bg-surface-container-low rounded-md text-center font-medium text-secondary text-sm md:text-base peer-checked:bg-[#1976d2] peer-checked:text-white transition-all">
                                    Rusak
                                </div>
                            </label>
                            <label class="flex-1 min-w-[100px] md:min-w-[120px] cursor-pointer">
                                <input class="hidden peer" name="jenis_laporan" type="radio" value="lainnya" onchange="toggleOtherInput(this)"/>
                                <div class="px-4 md:px-6 py-3 md:py-4 bg-surface-container-low rounded-md text-center font-medium text-secondary text-sm md:text-base peer-checked:bg-[#1976d2] peer-checked:text-white transition-all">
                                    Lainnya
                                </div>
                            </label>
                        </div>
                        <!-- Additional Input for "Lainnya" -->
                        <div id="otherReportContainer" class="hidden">
                            <input type="text" id="jenis_laporan_lainnya" placeholder="Sebutkan keluhan lainnya..." class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 md:py-4 text-on-surface focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-sm md:text-base outline-none">
                        </div>
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                    <div>
                        <label class="font-headline font-bold text-on-surface text-base md:text-lg">Deskripsi</label>
                        <p class="text-xs text-outline mt-1 leading-relaxed">Detail mengenai kondisi atau kronologi kejadian.</p>
                    </div>
                    <div class="md:col-span-2">
                        <textarea name="deskripsi" required class="w-full bg-surface-container-low border-none rounded-md px-4 py-3 md:py-4 text-on-surface focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all resize-none text-sm md:text-base outline-none" placeholder="Jelaskan detail laporan di sini..." rows="4"></textarea>
                    </div>
                </div>
                
                <!-- Upload Foto -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                    <div>
                        <label class="font-headline font-bold text-on-surface text-base md:text-lg">Upload Foto</label>
                        <p class="text-xs text-outline mt-1 leading-relaxed">Unggah bukti visual (Max. 5MB).</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="group relative bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl md:rounded-2xl p-6 md:p-10 flex flex-col items-center justify-center hover:bg-surface-container hover:border-primary/30 transition-all cursor-pointer">
                            <input type="file" name="foto" id="fotoInput" class="hidden" accept="image/*" onchange="previewImage(this)">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-3 md:mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary text-2xl md:text-3xl" style="font-variation-settings: 'FILL' 1;">cloud_upload</span>
                            </div>
                            <p class="text-on-surface font-semibold text-sm md:text-base" id="uploadStatus">Tarik file ke sini</p>
                            <p class="text-xs md:text-sm text-secondary text-center mt-1">Atau klik untuk menelusuri dari perangkat</p>
                        </label>
                        
                        <!-- Preview Area -->
                        <div id="imagePreview" class="mt-4 md:mt-6 flex gap-3 md:gap-4 overflow-x-auto pb-2 hidden">
                            <div class="relative min-w-[80px] h-[80px] md:min-w-[100px] md:h-[100px] rounded-lg overflow-hidden bg-surface-container group">
                                <img id="previewImg" class="w-full h-full object-cover" alt="Uploaded preview" src=""/>
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" onclick="removeImage()" class="p-1 bg-error text-white rounded-full shadow-md hover:bg-red-700 transition-colors">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-6 md:pt-8 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4 md:gap-6">
                    <div class="flex items-center gap-2 text-xs md:text-sm text-secondary self-start sm:self-auto">
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">info</span>
                        <span>Pastikan data sudah benar sebelum mengirim.</span>
                    </div>
                    <button id="submit-btn" class="w-full sm:w-auto px-8 md:px-10 py-3 md:py-4 bg-[#ffcc00] hover:bg-[#ffbb00] disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed disabled:shadow-none text-black font-extrabold rounded-full active:scale-95 transition-all shadow-lg shadow-yellow-500/30 flex items-center justify-center gap-2 text-sm md:text-base" type="submit">
                        Kirim Laporan
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">send</span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer Help Section -->
        <div class="mt-8 md:mt-10 text-center md:text-left mb-10">
            <h3 class="font-headline font-bold text-base md:text-lg mb-1 md:mb-2 text-on-surface">Butuh Bantuan?</h3>
            <p class="text-secondary text-xs md:text-sm">Jika barang tidak ditemukan dalam daftar, silakan hubungi <a class="text-primary font-bold underline underline-offset-4 hover:text-blue-800 transition-colors" href="#">Divisi Inventaris</a> atau kunjungi ruang pusat bantuan di Lantai 2.</p>
        </div>
    </div>
</main>

    <script>
        function toggleOtherInput(input) {
            const container = document.getElementById('otherReportContainer');
            const otherInput = document.getElementById('jenis_laporan_lainnya');
            if (input.value === 'lainnya' && input.checked) {
                container.classList.remove('hidden');
                otherInput.setAttribute('name', 'jenis_laporan');
                input.removeAttribute('name');
            } else {
                container.classList.add('hidden');
                otherInput.removeAttribute('name');
                const radios = document.getElementsByName('jenis_laporan');
                // radio name is already correct if this function is called on radio change
            }
        }

        // Specifically for radio button changes to ensure name consistency
        document.querySelectorAll('input[type=radio][name=jenis_laporan]').forEach(radio => {
            radio.addEventListener('change', function() {
                const otherInput = document.getElementById('jenis_laporan_lainnya');
                if (this.value !== 'lainnya') {
                    otherInput.removeAttribute('name');
                    this.name = 'jenis_laporan';
                }
            });
        });

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const status = document.getElementById('uploadStatus');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                    status.textContent = input.files[0].name;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage() {
            const input = document.getElementById('fotoInput');
            const preview = document.getElementById('imagePreview');
            const status = document.getElementById('uploadStatus');
            
            input.value = '';
            preview.classList.add('hidden');
            status.textContent = 'Tarik file ke sini';
        }

        // Real-time Stock Validation
        const idBarang = document.getElementById('id_barang');
        const jumlahBarang = document.getElementById('jumlah_barang');
        const submitBtn = document.getElementById('submit-btn');
        const stockError = document.getElementById('stock-error');

        function validateStock() {
            const selectedOption = idBarang.options[idBarang.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const requested = parseInt(jumlahBarang.value) || 0;

            if (requested > stock && stock > 0) {
                stockError.classList.remove('hidden');
                submitBtn.disabled = true;
            } else {
                stockError.classList.add('hidden');
                submitBtn.disabled = false;
            }
        }

        idBarang.addEventListener('change', validateStock);
        jumlahBarang.addEventListener('input', validateStock);
    </script>
</body>
</html>
</html>