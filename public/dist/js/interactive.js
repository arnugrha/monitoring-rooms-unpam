function toggleSidebar() {
  const sidebar = document.getElementById("main-sidebar");
  const overlay = document.getElementById("side-overlay");

  const isHidden = sidebar.classList.contains("-translate-x-full");

  if (isHidden) {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
    setTimeout(() => {
      overlay.classList.add("opacity-100");
      overlay.classList.remove("opacity-0");
    }, 10);
    document.body.style.overflow = "hidden";
  } else {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("opacity-0");
    overlay.classList.remove("opacity-100");
    setTimeout(() => {
      overlay.classList.add("hidden");
    }, 300);
    document.body.style.overflow = "";
  }
}

function toggleProfileMenu(event) {
  event.stopPropagation();
  const card = document.getElementById("profile-card");
  const isHidden = card.classList.contains("hidden");

  if (isHidden) {
    card.classList.remove("hidden");
    setTimeout(() => {
      card.classList.remove("scale-95", "opacity-0");
      card.classList.add("scale-100", "opacity-100");
    }, 10);
  } else {
    closeProfileMenu();
  }
}

function closeProfileMenu() {
  const card = document.getElementById("profile-card");
  if (card && !card.classList.contains("hidden")) {
    card.classList.add("scale-95", "opacity-0");
    card.classList.remove("scale-100", "opacity-100");
    setTimeout(() => {
      card.classList.add("hidden");
    }, 200);
  }
}

window.addEventListener("click", () => {
  closeProfileMenu();
});

// Sidebar Interactivity
document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.href;
    const sidebarLinks = document.querySelectorAll("#sidebar-nav a");

    const activeClasses = ["bg-[#e8f0fe]", "text-blue-700", "rounded-lg", "font-bold", "transition-all", "duration-200"];
    const inactiveClasses = ["text-slate-600", "hover:bg-slate-200/50", "rounded-lg", "transition-colors"];

    // Sidebar Dropdown Toggle
    const dropdownTriggers = document.querySelectorAll(".dropdown-trigger");
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener("click", () => {
            const dropdownId = trigger.getAttribute("data-dropdown");
            const menu = document.getElementById(dropdownId);
            const chevron = trigger.querySelector(".chevron");
            
            const isOpen = menu.classList.contains("grid-rows-[1fr]");
            
            if (!isOpen) {
                menu.classList.remove("grid-rows-[0fr]", "opacity-0");
                menu.classList.add("grid-rows-[1fr]", "opacity-100");
                chevron.classList.add("rotate-180");
            } else {
                menu.classList.remove("grid-rows-[1fr]", "opacity-100");
                menu.classList.add("grid-rows-[0fr]", "opacity-0");
                chevron.classList.remove("rotate-180");
            }
        });
    });

    sidebarLinks.forEach(link => {
        if (currentPath.includes(link.getAttribute("href"))) {
            link.classList.add(...activeClasses);
            link.classList.remove(...inactiveClasses);
            
            // Set icon to filled if it's material-symbols
            const icon = link.querySelector(".material-symbols-outlined");
            if (icon) {
                icon.style.fontVariationSettings = "'FILL' 1";
            }

            // If link is inside a dropdown, open the dropdown
            const parentDropdown = link.closest(".dropdown-menu");
            if (parentDropdown) {
                parentDropdown.classList.remove("grid-rows-[0fr]", "opacity-0");
                parentDropdown.classList.add("grid-rows-[1fr]", "opacity-100");
                const trigger = document.querySelector(`[data-dropdown="${parentDropdown.id}"]`);
                if (trigger) {
                    const chevron = trigger.querySelector(".chevron");
                    if (chevron) {
                        chevron.classList.add("rotate-180");
                    }
                }
            }
        } else {
            link.classList.add(...inactiveClasses);
            link.classList.remove(...activeClasses);
        }
    });

    // Initialize Table Interactivity if table exists
    const interactiveTable = document.getElementById('interactive-table');
    if (interactiveTable) {
        new DataTableManager(interactiveTable);
    }
});

class DataTableManager {
    constructor(table) {
        this.table = table;
        this.tbody = table.querySelector('tbody');
        this.originalRows = Array.from(this.tbody.querySelectorAll('.table-row-data'));
        this.filteredRows = [...this.originalRows];
        
        // UI Elements
        this.searchInput = document.getElementById('table-search');
        this.entriesSelect = document.getElementById('table-entries');
        this.summaryEl = document.getElementById('pagination-summary');
        this.controlsEl = document.getElementById('pagination-controls');

        // State
        this.rowsPerPage = parseInt(this.entriesSelect?.value) || 10;
        this.currentPage = 1;

        this.init();
    }

    init() {
        if (this.searchInput) {
            this.searchInput.addEventListener('input', () => {
                this.filterRows(this.searchInput.value);
                this.currentPage = 1;
                this.updateDisplay();
            });
        }

        if (this.entriesSelect) {
            this.entriesSelect.addEventListener('change', () => {
                this.rowsPerPage = parseInt(this.entriesSelect.value);
                this.currentPage = 1;
                this.updateDisplay();
            });
        }

        this.updateDisplay();
    }

    filterRows(query) {
        const q = query.toLowerCase().trim();
        if (!q) {
            this.filteredRows = [...this.originalRows];
            return;
        }

        this.filteredRows = this.originalRows.filter(row => {
            const targets = Array.from(row.querySelectorAll('.search-target'));
            return targets.some(t => t.textContent.toLowerCase().includes(q));
        });
    }

    updateDisplay() {
        const totalRows = this.filteredRows.length;
        const totalPages = Math.ceil(totalRows / this.rowsPerPage) || 1;

        if (this.currentPage > totalPages) this.currentPage = totalPages;

        const start = (this.currentPage - 1) * this.rowsPerPage;
        const end = Math.min(start + this.rowsPerPage, totalRows);

        // Hide all original rows
        this.originalRows.forEach(row => row.classList.add('hidden'));

        // Show rows for current page
        const pageRows = this.filteredRows.slice(start, end);
        pageRows.forEach((row, index) => {
            row.classList.remove('hidden');
            const noEl = row.querySelector('.row-no');
            if (noEl) noEl.textContent = start + index + 1;
        });

        this.updateSummary(start, end, totalRows);
        this.renderPagination(totalPages);
    }

    updateSummary(start, end, total) {
        if (!this.summaryEl) return;
        const text = total === 0 ? '0 data' : `${start + 1}-${end} dari ${total}`;
        this.summaryEl.textContent = `Menampilkan ${text}`;
    }

    renderPagination(totalPages) {
        if (!this.controlsEl) return;
        this.controlsEl.innerHTML = '';

        if (totalPages <= 1) {
            this.controlsEl.classList.add('hidden');
            return;
        }
        this.controlsEl.classList.remove('hidden');

        // Previous Button
        const prevBtn = this.createPaginationBtn('chevron_left', this.currentPage > 1);
        prevBtn.onclick = () => {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.updateDisplay();
            }
        };
        this.controlsEl.appendChild(prevBtn);

        // Compact Page Numbers (Current and neighbors)
        const range = 1; // Number of pages to show before/after current
        let startPage = Math.max(1, this.currentPage - range);
        let endPage = Math.min(totalPages, this.currentPage + range);

        if (startPage > 1) {
            this.controlsEl.appendChild(this.createPageLink(1));
            if (startPage > 2) this.controlsEl.appendChild(this.createDots());
        }

        for (let i = startPage; i <= endPage; i++) {
            this.controlsEl.appendChild(this.createPageLink(i));
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) this.controlsEl.appendChild(this.createDots());
            this.controlsEl.appendChild(this.createPageLink(totalPages));
        }

        // Next Button
        const nextBtn = this.createPaginationBtn('chevron_right', this.currentPage < totalPages);
        nextBtn.onclick = () => {
            if (this.currentPage < totalPages) {
                this.currentPage++;
                this.updateDisplay();
            }
        };
        this.controlsEl.appendChild(nextBtn);
    }

    createPageLink(page) {
        const btn = document.createElement('button');
        btn.className = `h-8 w-8 flex items-center justify-center rounded-lg font-bold text-[10px] md:text-xs transition-all ${
            this.currentPage === page 
            ? 'bg-primary text-white shadow-md' 
            : 'hover:bg-slate-100 text-slate-500'
        }`;
        btn.textContent = page;
        btn.onclick = () => {
            this.currentPage = page;
            this.updateDisplay();
        };
        return btn;
    }

    createDots() {
        const dots = document.createElement('span');
        dots.className = 'text-slate-300 px-1';
        dots.textContent = '...';
        return dots;
    }

    createPaginationBtn(icon, enabled) {
        const btn = document.createElement('button');
        btn.className = `p-1.5 rounded-lg transition-colors ${
            enabled ? 'hover:bg-slate-100 text-slate-500' : 'text-slate-200 cursor-not-allowed'
        }`;
        btn.disabled = !enabled;
        btn.innerHTML = `<span class="material-symbols-outlined text-lg">${icon}</span>`;
        return btn;
    }
}