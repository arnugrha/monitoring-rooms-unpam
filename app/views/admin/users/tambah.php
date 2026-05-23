<!-- Main Content Area -->
    <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
                <a href="<?= BASEURL ?>Users" class="hover:text-blue-500">Kelola User</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Tambah User</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
                Tambah User Baru
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
                Lengkapi detail informasi User untuk didaftarkan ke dalam sistem pemantauan pusat.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
            <form action="<?= BASEURL; ?>users/prosesTambah" method="post" class="space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Username</label>
                        <input class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 23101100868" type="text" name="username"/>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: Jhon Doe" type="text" name="nama_lengkap"/>
                    </div>

                    <div class="space-y-2" id="kelas-field">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kode Kelas</label>
                        <input id="kode_kelas" class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 06TPLP029" type="text" name="kode_kelas"/>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Password</label>
                            <div class="flex items-center gap-2">
                                <input class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Masukkan password" type="password"name="password"/>
                            </div>
                        </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Role</label>
                            <div class="relative">
                                <select id="role" name="role" class="w-full h-11 px-4 bg-slate-50 border border-slate-300 text-slate-500 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface">
                                    <option disabled="" selected="" value="">Pilih Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Ketua kelas">Ketua kelas</option>
                                    <option value="OB">Office Boy</option>
                                </select>
                                <!-- <span class="material-symbols-outlined absolute right-3 top-2.5 text-slate-300 pointer-events-none">expand_more</span> -->
                            </div>
                        </div>

                        <div class="space-y-2" id="ruangan-field">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Ruangan</label>
                            <div class="relative custom-select-container" id="room-select-container">
                                <div class="relative group">
                                    <input 
                                        type="text" 
                                        id="room-search"
                                        placeholder="Ketik/Cari Ruangan..."
                                        autocomplete="off"
                                        class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300"
                                    >
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-300" id="room-arrow">expand_more</span>
                                </div>
                                
                                <!-- Hidden actual input for POST -->
                                <input type="hidden" name="kode_ruangan" id="kode_ruangan_hidden">

                                <!-- Dropdown List -->
                                <div id="room-dropdown" class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl max-h-60 overflow-y-auto hidden">
                                    <div class="px-4 py-2.5 hover:bg-slate-50 cursor-pointer text-sm text-slate-700 flex justify-between items-center transition-colors room-option" data-value="" data-search="-">
                                        <span>Tidak ada ruangan</span>
                                        <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">-</span>
                                    </div>
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
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                    <a href="<?= BASEURL; ?>users" class="w-full sm:w-auto px-10 h-11 bg-slate-400 text-primary font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="button" onclick="history.back()">
                        Batal
                    </a>
                    <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">save</span>
                        Simpan Username
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mt-8">
            <div class="bg-blue-50/50 p-5 rounded-lg flex flex-col gap-3 border border-blue-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
                    <span class="material-symbols-outlined text-xl">info</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Validasi Data</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Pastikan informasi User sesuai dengan fisik User sebelum disimpan.
                </p>
            </div>
            <div class="bg-emerald-50/50 p-5 rounded-lg flex flex-col gap-3 border border-emerald-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">sync</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Sinkronisasi</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Data akan langsung terhubung dengan dashboard monitoring pusat secara real-time.
                </p>
            </div>
            <div class="bg-amber-50/50 p-5 rounded-lg flex flex-col gap-3 border border-amber-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-amber-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">verified_user</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Keamanan</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Setiap perubahan data akan tercatat dalam log aktivitas administrator otomatis.
                </p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('room-select-container');
            const searchInput = document.getElementById('room-search');
            const dropdown = document.getElementById('room-dropdown');
            const hiddenInput = document.getElementById('kode_ruangan_hidden');
            const arrow = document.getElementById('room-arrow');
            const options = document.querySelectorAll('.room-option');
            const noResult = document.getElementById('no-room-result');

            // Toggle Dropdown
            searchInput.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            });

            // Filter logic
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                let hasVisible = false;

                options.forEach(opt => {
                    const searchData = opt.getAttribute('data-search');
                    if (searchData.includes(term)) {
                        opt.classList.remove('hidden');
                        hasVisible = true;
                    } else {
                        opt.classList.add('hidden');
                    }
                });

                noResult.classList.toggle('hidden', hasVisible);
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            });

            // Select logic
            options.forEach(opt => {
                opt.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.querySelector('span:first-child').textContent;
                    
                    if (value === "") {
                        searchInput.value = "Tidak ada ruangan";
                    } else {
                        searchInput.value = `${text} (${value})`;
                    }
                    
                    hiddenInput.value = value;
                    dropdown.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                });
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                }
            });

            // Dynamic fields toggle based on selected role
            const roleSelect = document.getElementById('role');
            const kelasInput = document.getElementById('kode_kelas');

            function toggleFields() {
                const role = roleSelect.value;
                if (role === 'Ketua kelas') {
                    kelasInput.setAttribute('required', 'required');
                } else {
                    kelasInput.removeAttribute('required');
                }
            }

            roleSelect.addEventListener('change', toggleFields);
            toggleFields(); // Initial execution

            // Require room code specifically for Ketua kelas on submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (roleSelect.value === 'Ketua kelas') {
                    if (!hiddenInput.value) {
                        alert('Bagi Ketua kelas, silakan pilih Ruangan terlebih dahulu!');
                        e.preventDefault();
                    }
                }
            });
        });
    </script>