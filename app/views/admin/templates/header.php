<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Monitoring Rooms - <?= $data['judul']; ?></title>
    <!-- Use local output.css -->
    <link href="<?= BASEURL; ?>dist/css/output.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-surface text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed antialiased">

<!-- Overlay Backdrop (Mobile) -->
<div id="side-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 z-40 hidden backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

<!-- Global Alert System -->
<?php if (Session::has('_flash')) : ?>
    <div class="fixed top-20 right-4 z-[100] space-y-3 pointer-events-none">
        <?php foreach ($_SESSION['_flash'] as $type => $message) : ?>
            <?php 
                $bgColor = $type === 'success' ? 'bg-emerald-50' : 'bg-red-50';
                $textColor = $type === 'success' ? 'text-emerald-800' : 'text-red-800';
                $borderColor = $type === 'success' ? 'border-emerald-200' : 'border-red-200';
                $icon = $type === 'success' ? 'check_circle' : 'error';
                $iconColor = $type === 'success' ? 'text-emerald-500' : 'text-red-500';
            ?>
            <div id="alert-<?= $type ?>" class="pointer-events-auto flex items-center gap-3 px-5 py-4 <?= $bgColor ?> <?= $textColor ?> border <?= $borderColor ?> rounded-2xl shadow-xl shadow-black/5 min-w-[320px] animate-in slide-in-from-right duration-500">
                <span class="material-symbols-outlined <?= $iconColor ?>"><?= $icon ?></span>
                <p class="text-sm font-bold tracking-tight"><?= Session::getFlash($type) ?></p>
                <button onclick="this.parentElement.remove()" class="ml-auto p-1 hover:bg-black/5 rounded-full transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-lg opacity-40">close</span>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const el = document.getElementById('alert-<?= $type ?>');
                    if (el) {
                        el.classList.add('animate-out', 'fade-out', 'slide-out-to-right', 'duration-500');
                        setTimeout(() => el.remove(), 500);
                    }
                }, 5000);
            </script>
        <?php endforeach; ?>
    </div>
<?php endif; ?>