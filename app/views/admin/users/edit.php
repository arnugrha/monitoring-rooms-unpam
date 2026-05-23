
<!-- Main Content Area -->
    <section class="p-4 md:p-6 lg:p-8 space-y-6 max-w-[800px] mx-auto">
        <!-- Header Section -->
        <div class="mb-8 text-center sm:text-left">
            <div class="flex items-center gap-2 text-slate-400 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2 justify-center sm:justify-start">
                <a href="<?= BASEURL ?>users" class="hover:text-blue-500">Kelola Users</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Edit User</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-on-surface font-headline leading-tight">
                Edit User: <?= $data['user']['username']; ?>
            </h1>
            <p class="text-slate-500 mt-2 text-sm md:text-base leading-relaxed">
                Perbarui informasi user di bawah ini.
            </p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg p-6 md:p-8 shadow-sm border border-slate-100">
            <form action="<?= BASEURL; ?>users/prosesUbah" method="post" class="space-y-6">
                <input type="hidden" name="id_user" value="<?= $data['user']['id_user']; ?>">
                <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Username</label>
                        <input class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 23101100868" type="text" name="username" value="<?= $data['user']['username']; ?>"/>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: Jhon Doe" type="text" name="nama_lengkap" value="<?= $data['user']['nama_lengkap']; ?>"/>
                    </div>

                    <div class="space-y-2" id="kelas-field">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Kode Kelas</label>
                        <input id="kode_kelas" class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Contoh: 06TPLP029" type="text" name="kode_kelas" value="<?= $data['user']['kode_kelas']; ?>"/>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Password</label>
                            <div class="flex flex-col gap-1">
                                <input class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300" placeholder="Masukkan password baru jika ingin mengubah" type="password" name="password"/>
                                <span class="text-[10px] text-slate-400 ml-1 italic">*Kosongkan jika tidak ingin mengubah password</span>
                            </div>
                        </div>
                    </div>
                        
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Role</label>
                        <div class="relative">
                            <select id="role" name="role" class="w-full h-11 px-4 bg-slate-50 border border-slate-300 text-slate-500 rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface">
                                <option disabled="" value="">Pilih Role</option>
                                <option value="Admin" <?= ($data['user']['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="Ketua kelas" <?= ($data['user']['role'] == 'Ketua kelas') ? 'selected' : ''; ?>>Ketua kelas</option>
                                <option value="OB" <?= ($data['user']['role'] == 'OB') ? 'selected' : ''; ?>>Office Boy</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2" id="ruangan-field">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Ruangan</label>
                        <div class="relative custom-select-container" id="room-select-container">
                            <div class="relative group">
                                <?php 
                                    $current_room_text = "Tidak ada ruangan";
                                    foreach($data['ruangan'] as $r) {
                                        if($data['user']['kode_ruangan'] == $r['kode_ruangan']) {
                                            $current_room_text = $r['nama_ruangan'] . " (" . $r['kode_ruangan'] . ")";
                                            break;
                                        }
                                    }
                                ?>
                                <input 
                                    type="text" 
                                    id="room-search"
                                    placeholder="Ketik/Cari Ruangan..."
                                    autocomplete="off"
                                    value="<?= ($data['user']['kode_ruangan']) ? $current_room_text : "Tidak ada ruangan"; ?>"
                                    class="w-full h-11 px-4 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none text-sm text-on-surface placeholder:text-slate-300"
                                >
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none transition-transform duration-300" id="room-arrow">expand_more</span>
                            </div>
                            
                            <!-- Hidden actual input for POST -->
                            <input type="hidden" name="kode_ruangan" id="kode_ruangan_hidden" value="<?= $data['user']['kode_ruangan']; ?>">

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

                <!-- Action Buttons -->
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-end gap-3 border-t border-slate-50">
                    <a href="<?= BASEURL; ?>users" class="w-full sm:w-auto px-10 h-11 bg-slate-400 text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm">
                        Batal
                    </a>
                    <button class="w-full sm:w-auto px-10 h-11 bg-primary text-white font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm" type="submit">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">save</span>
                        Update User
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
                    Pastikan informasi User sesuai sebelum melakukan pembaruan.
                </p>
            </div>
            <div class="bg-emerald-50/50 p-5 rounded-lg flex flex-col gap-3 border border-emerald-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">sync</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Sinkronisasi</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Perubahan akan langsung diterapkan ke seluruh sistem secara real-time.
                </p>
            </div>
            <div class="bg-amber-50/50 p-5 rounded-lg flex flex-col gap-3 border border-amber-100/50">
                <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-amber-600 shadow-sm">
                    <span class="material-symbols-outlined text-xl">verified_user</span>
                </div>
                <h3 class="font-bold text-on-surface text-xs md:text-sm">Keamanan</h3>
                <p class="text-[10px] md:text-xs text-slate-500 leading-relaxed">
                    Setiap pembaruan data akan tercatat dalam log aktivitas administrator otomatis.
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
            const ruanganField = document.getElementById('ruangan-field');
            const kelasInput = document.getElementById('kode_kelas');

            function toggleFields() {
                const role = roleSelect.value;
                if (role === 'Ketua kelas') {
                    ruanganField.classList.remove('hidden');
                    kelasInput.setAttribute('required', 'required');
                } else {
                    ruanganField.classList.add('hidden');
                    kelasInput.removeAttribute('required');
                    
                    // Clear room inputs when role is Admin or OB
                    searchInput.value = 'Tidak ada ruangan';
                    hiddenInput.value = '';
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
