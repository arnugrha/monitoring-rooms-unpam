<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Monitoring Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0,1" />
</head>

<body class="bg-surface selection:bg-primary/20 min-h-screen">
    <main class="relative min-h-screen flex items-center justify-center my-6 px-4 py-8 md:py-0">

        <!-- Background Elements -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-[300px] md:w-[600px] h-[300px] md:h-[600px] bg-secondary-container/30 rounded-full blur-[80px] md:blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 w-[400px] md:w-[800px] h-[400px] md:h-[800px] bg-tertiary-fixed/10 rounded-full blur-[100px] md:blur-[150px]"></div>
        </div>

        <!-- Login Container -->
        <section class="relative z-10 w-full max-w-[420px]">
            <!-- Logo Area -->
            <div class="mb-8 md:mb-10 text-center">
                <!-- <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-primary-container text-on-primary-container shadow-lg mb-4">
                    <span class="material-symbols-outlined text-3xl">visibility</span>
                </div> -->
                <h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">Monitoring Rooms</h1>
                <p class="text-secondary font-medium tracking-wide text-xs uppercase">Access Professional Console</p>
            </div>

            <!-- Login Card -->
            <div class="glass-card bg-surface-container-lowest border border-white/40 shadow-[0px_12px_32px_rgba(25,28,29,0.06)] rounded-xl p-6 md:p-10">

                <!-- Flash Message Error -->
                <?php if ($flash = Session::getFlash('error')): ?>
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        <?= $flash ?>
                    </div>
                <?php endif; ?>

                <?php if ($flash = Session::getFlash('success')): ?>
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                        <?= $flash ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASEURL ?>index.php?url=AuthController/authenticate" class="space-y-6">
                    <!-- Username Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1" for="username">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline">
                                <span class="material-symbols-outlined text-xl">person</span>
                            </div>
                            <input class="block w-full pl-12 pr-4 py-3 bg-surface-container-high border-none rounded-md focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest text-on-surface placeholder:text-outline transition-all text-sm"
                                id="username" name="username" placeholder="Masukkan NIM Anda" type="text" required />
                        </div>
                        <p class="text-[10px] text-secondary font-medium ml-1">Gunakan NIM</p>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1" for="password">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline">
                                <span class="material-symbols-outlined text-xl">lock</span>
                            </div>
                            <input class="block w-full pl-12 pr-12 py-3 bg-surface-container-high border-none rounded-md focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest text-on-surface placeholder:text-outline transition-all text-sm"
                                id="password" name="password" placeholder="••••••••" type="password" required />
                            <button class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-on-surface transition-colors" type="button" onclick="togglePassword()">
                                <span class="material-symbols-outlined text-xl" id="eyeIcon">visibility</span>
                            </button>
                        </div>
                        <p class="text-[10px] text-secondary font-medium ml-1"> (8 Digit Username)</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-2/3 mx-auto block py-3 px-3 bg-sky-600 text-white font-bold text-sm rounded-xl shadow-md shadow-tertiary-fixed/20 hover:bg-blue-800 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                            Login ke Monitoring
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>

                    <div class="mt-6 flex items-center justify-between text-xs">
                        <a class="text-primary font-semibold hover:underline" href="#">Lupa Password?</a>
                        <a class="text-secondary hover:text-on-surface transition-colors flex items-center gap-1" href="#">
                            <span class="material-symbols-outlined text-base">help</span>
                            Bantuan
                        </a>
                    </div>
                </form>
            </div>

            <footer class="mt-8 text-center">
                <p class="text-outline text-[10px] font-medium">© 2026 Admin Central Monitoring Rooms. All Rights Reserved.</p>
            </footer>
        </section>
    </main>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.textContent = 'visibility_off';
            } else {
                password.type = 'password';
                eyeIcon.textContent = 'visibility';
            }
        }
    </script>
</body>

</html>