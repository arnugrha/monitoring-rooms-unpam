    <!-- TopAppBar -->
    <header class="sticky top-0 z-40 bg-white/70 backdrop-blur-xl shadow-sm flex justify-between items-center w-full px-4 md:px-8 py-2 md:py-3">
        <div class="flex items-center gap-3 md:gap-4">
            <!-- Hamburger Button -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-all active:scale-90">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
            <span class="text-lg md:text-xl font-black text-blue-800 font-headline tracking-tight">Monitoring Rooms</span>
        </div>
        <div class="flex items-center gap-3 md:gap-6">
            <div class="flex items-center gap-2 md:gap-4">
                <div class="relative">
                    <div onclick="toggleProfileMenu(event)" class="h-8 md:h-9 w-8 md:w-9 rounded-full overflow-hidden border-2 border-white shadow-sm shrink-0 cursor-pointer active:scale-95 transition-transform hover:ring-2 hover:ring-primary/20">
                        <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZNXWFP5f19k5eLQPjbRamvhZvP6cEC8028QZtSekcN5ZdGuuM1D9GqD51pav7A05Ogm8y3lJiy62BSHru7YKGsd9-pL0S9ZOU0Fl52j6eTYsDq9dNbYoSweVcH2vZJ9Z_qvgmhbUHCGCSDgXmdOVFGJUQmhB7POf399Na_40Hp3OX3OODTI9kd7ZQptWtt30IGZAECTwOcBsPqnfPiSdTORhUXkebZcE1wSKBUefHNqVSMjAJ4rhBbT1fi-OKs0JQFjzak8V_8MJh"/>
                    </div>
                    
                    <!-- Profile Dropdown Card -->
                    <div id="profile-card" class="absolute right-0 mt-3 w-56 bg-white rounded-md shadow-[0_10px_40px_rgba(0,0,0,0.12)] border border-slate-100 z-50 py-2 hidden animate-in fade-in fill-mode-both duration-200 origin-top-right transform scale-95 opacity-0">
                        <div class="px-4 py-3 border-b border-slate-50">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Account</p>
                            <p class="text-sm font-extrabold text-on-surface"><?= Session::user()['nama_lengkap']; ?></p>
                            <p class="text-[10px] text-slate-500 font-medium lowercase"><?= Session::user()['role']; ?> • <?= Session::user()['username']; ?></p>
                        </div>
                        <div class="pt-1 mt-1 border-t border-slate-50">
                            <a href="<?= BASEURL; ?>AuthController/logout" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<script>
    function toggleProfileMenu(event) {
        event.stopPropagation();
        const card = document.getElementById('profile-card');
        const isHidden = card.classList.contains('hidden');
        
        if (isHidden) {
            card.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            card.classList.add('scale-95', 'opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                card.classList.add('hidden');
            }, 200);
        }
    }

    // Close menu when clicking outside
    document.addEventListener('click', function() {
        const card = document.getElementById('profile-card');
        if (card && !card.classList.contains('hidden')) {
            card.classList.add('scale-95', 'opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                card.classList.add('hidden');
            }, 200);
        }
    });
</script>
