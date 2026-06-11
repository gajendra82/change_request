/* CRMS — UI Interactions */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initSidebar();
        initLucide();
        initTableFilters();
        initWizard();
        initDropZone();
        initCostCalculator();
        initDraftAutoSave();
    });

    /* ── Sidebar ── */
    function initSidebar() {
        const sidebar = document.getElementById('crmsSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');
        if (!sidebar) return;

        const collapsed = localStorage.getItem('crms-sidebar-collapsed') === 'true';
        if (collapsed && window.innerWidth >= 992) {
            sidebar.classList.add('collapsed');
            document.body.classList.add('sidebar-collapsed');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    sidebar.classList.toggle('mobile-open');
                    overlay?.classList.toggle('show');
                } else {
                    sidebar.classList.toggle('collapsed');
                    document.body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('crms-sidebar-collapsed', sidebar.classList.contains('collapsed'));
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', function () {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('show');
            });
        }
    }

    /* ── Lucide Icons ── */
    function initLucide() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    /* ── Table Filters ── */
    function initTableFilters() {
        const wrapper = document.querySelector('[data-crms-filters]');
        if (!wrapper) return;

        const table = wrapper.querySelector('.datatable');
        if (!table || typeof $ === 'undefined' || !$.fn.DataTable) return;

        const dt = $(table).DataTable();
        const searchInput = wrapper.querySelector('[data-filter-search]');
        const statusFilter = wrapper.querySelector('[data-filter-status]');
        const priorityFilter = wrapper.querySelector('[data-filter-priority]');
        const dateFrom = wrapper.querySelector('[data-filter-date-from]');
        const dateTo = wrapper.querySelector('[data-filter-date-to]');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                dt.search(this.value).draw();
            });
        }

        function applyCustomFilters() {
            $.fn.dataTable.ext.search.push(function (settings, data) {
                if (settings.nTable !== table) return true;

                const statusCol = parseInt(wrapper.dataset.statusCol || '4');
                const priorityCol = parseInt(wrapper.dataset.priorityCol || '3');
                const dateCol = parseInt(wrapper.dataset.dateCol || '5');

                if (statusFilter?.value && data[statusCol]) {
                    const status = data[statusCol].toLowerCase();
                    if (!status.includes(statusFilter.value.toLowerCase())) return false;
                }

                if (priorityFilter?.value && data[priorityCol]) {
                    const priority = data[priorityCol].toLowerCase();
                    if (!priority.includes(priorityFilter.value.toLowerCase())) return false;
                }

                if ((dateFrom?.value || dateTo?.value) && data[dateCol]) {
                    const cellDate = parseTableDate(data[dateCol]);
                    if (dateFrom?.value && cellDate < new Date(dateFrom.value)) return false;
                    if (dateTo?.value && cellDate > new Date(dateTo.value)) return false;
                }

                return true;
            });
            dt.draw();
        }

        [statusFilter, priorityFilter, dateFrom, dateTo].forEach(function (el) {
            if (el) el.addEventListener('change', applyCustomFilters);
        });
    }

    function parseTableDate(str) {
        const cleaned = str.replace(/<[^>]*>/g, '').trim();
        const d = new Date(cleaned);
        return isNaN(d) ? new Date() : d;
    }

    /* ── Multi-step Wizard ── */
    function initWizard() {
        const wizard = document.getElementById('crWizard');
        if (!wizard) return;

        let currentStep = 1;
        const totalSteps = 4;
        const panels = wizard.querySelectorAll('.wizard-panel');
        const steps = wizard.querySelectorAll('.wizard-step');
        const btnNext = document.getElementById('wizardNext');
        const btnPrev = document.getElementById('wizardPrev');
        const btnSubmit = document.getElementById('wizardSubmit');
        const reviewTitle = document.getElementById('reviewTitle');
        const reviewDescription = document.getElementById('reviewDescription');
        const reviewPriority = document.getElementById('reviewPriority');

        function showStep(step) {
            currentStep = step;
            panels.forEach(function (p) {
                p.classList.toggle('active', parseInt(p.dataset.step) === step);
            });
            steps.forEach(function (s) {
                const sNum = parseInt(s.dataset.step);
                s.classList.remove('active', 'completed');
                if (sNum < step) s.classList.add('completed');
                if (sNum === step) s.classList.add('active');
            });

            if (btnPrev) btnPrev.style.display = step > 1 ? 'inline-flex' : 'none';
            if (btnNext) btnNext.style.display = step < totalSteps ? 'inline-flex' : 'none';
            if (btnSubmit) btnSubmit.style.display = step === totalSteps ? 'inline-flex' : 'none';
        }

        function validateStep(step) {
            const panel = wizard.querySelector('.wizard-panel[data-step="' + step + '"]');
            const required = panel?.querySelectorAll('[required]') || [];
            let valid = true;
            required.forEach(function (input) {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            return valid;
        }

        function updateReview() {
            const title = document.getElementById('title');
            const description = document.getElementById('description');
            const priority = document.getElementById('priority');
            if (reviewTitle && title) reviewTitle.textContent = title.value || '—';
            if (reviewDescription && description) reviewDescription.textContent = description.value || '—';
            if (reviewPriority && priority) {
                reviewPriority.textContent = priority.options[priority.selectedIndex]?.text || '—';
            }
        }

        if (btnNext) {
            btnNext.addEventListener('click', function () {
                if (validateStep(currentStep)) {
                    if (currentStep === 3) updateReview();
                    showStep(currentStep + 1);
                }
            });
        }

        if (btnPrev) {
            btnPrev.addEventListener('click', function () {
                showStep(currentStep - 1);
            });
        }

        showStep(1);
    }

    /* ── File Drop Zone ── */
    function initDropZone() {
        const zone = document.getElementById('dropZone');
        const input = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        if (!zone) return;

        zone.addEventListener('click', function () { input?.click(); });

        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('dragover');
        });

        zone.addEventListener('dragleave', function () {
            zone.classList.remove('dragover');
        });

        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('dragover');
            if (input && e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                renderFileList(e.dataTransfer.files, fileList);
            }
        });

        if (input) {
            input.addEventListener('change', function () {
                renderFileList(input.files, fileList);
            });
        }
    }

    function renderFileList(files, container) {
        if (!container) return;
        container.innerHTML = '';
        Array.from(files).forEach(function (file) {
            const item = document.createElement('div');
            item.className = 'small text-muted mt-2';
            item.innerHTML = '<i data-lucide="file" style="width:14px;height:14px"></i> ' + file.name;
            container.appendChild(item);
        });
        initLucide();
    }

    /* ── Cost Calculator ── */
    function initCostCalculator() {
        const daysInput = document.getElementById('estimated_days');
        const costDisplay = document.getElementById('estimated_cost');
        const costDays = document.getElementById('cost_days_display');
        if (!daysInput || !costDisplay) return;

        const dailyRate = parseInt(daysInput.dataset.dailyRate || '12000');

        function updateCost() {
            const days = parseInt(daysInput.value) || 0;
            const cost = days * dailyRate;
            costDisplay.textContent = '₹' + cost.toLocaleString('en-IN', { minimumFractionDigits: 2 });
            if (costDays) costDays.textContent = days + ' day' + (days !== 1 ? 's' : '');
        }

        daysInput.addEventListener('input', updateCost);
        updateCost();
    }

    /* ── Draft Auto-save ── */
    function initDraftAutoSave() {
        const form = document.getElementById('crWizardForm');
        if (!form) return;

        const key = 'crms-draft-' + (form.dataset.draftKey || 'new');
        const fields = form.querySelectorAll('#title, #description, #priority');

        fields.forEach(function (field) {
            const saved = localStorage.getItem(key + '-' + field.id);
            if (saved && !field.value) field.value = saved;

            field.addEventListener('input', function () {
                localStorage.setItem(key + '-' + field.id, field.value);
            });
        });

        form.addEventListener('submit', function () {
            fields.forEach(function (field) {
                localStorage.removeItem(key + '-' + field.id);
            });
        });
    }
})();
