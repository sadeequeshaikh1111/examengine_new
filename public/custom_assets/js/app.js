/**
 * Design System - Compiled App JS
 * Lightweight replacement for AdminLTE
 * Vanilla JS only
 */

(function () {
    'use strict';

    /* ============================================
       Sidebar
       ============================================ */

    function initSidebarToggle() {
        // Custom data-sidebar-toggle
        var togglers = document.querySelectorAll('[data-sidebar-toggle]');
        togglers.forEach(function (toggler) {
            toggler.addEventListener('click', function (e) {
                e.preventDefault();
                document.body.classList.toggle('sidebar-collapsed');
            });
        });

        // AdminLTE compatibility: data-widget="pushmenu"
        var pushmenus = document.querySelectorAll('[data-widget="pushmenu"]');
        pushmenus.forEach(function (toggler) {
            toggler.addEventListener('click', function (e) {
                e.preventDefault();
                document.body.classList.toggle('sidebar-collapsed');
            });
        });
    }

    function initTreeview() {
        // Custom .sidebar-nav
        var treeviewToggles = document.querySelectorAll('.sidebar-nav .nav-item.has-treeview > .nav-link');
        treeviewToggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                var parent = toggle.parentElement;
                parent.classList.toggle('menu-open');
            });
        });

        // AdminLTE compatibility: data-widget="treeview"
        var adminTreeviews = document.querySelectorAll('[data-widget="treeview"] .nav-item.has-treeview > .nav-link');
        adminTreeviews.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                var parent = toggle.parentElement;
                parent.classList.toggle('menu-open');
            });
        });
    }

    function initSidebarOverlay() {
        var overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) return;
        overlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-collapsed');
            overlay.classList.remove('show');
        });
    }

    /* ============================================
       Alerts
       ============================================ */

    function initDismissibleAlerts() {
        var closeButtons = document.querySelectorAll('[data-dismiss="alert"]');
        closeButtons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                var alert = button.closest('.alert');
                if (alert) alert.remove();
            });
        });
    }

    function initAutoDismiss() {
        var autoDismissAlerts = document.querySelectorAll('[data-auto-dismiss]');
        autoDismissAlerts.forEach(function (alert) {
            var delay = parseInt(alert.getAttribute('data-auto-dismiss'), 10) || 5000;
            setTimeout(function () {
                alert.remove();
            }, delay);
        });
    }

    /* ============================================
       Dropdowns
       ============================================ */

    function closeAllDropdowns() {
        var openMenus = document.querySelectorAll('.dropdown-menu.show');
        openMenus.forEach(function (menu) {
            menu.classList.remove('show');
            var dropdown = menu.closest('.dropdown');
            if (dropdown) dropdown.classList.remove('show');
        });
    }

    function initDropdowns() {
        // Custom data-dropdown-toggle
        var toggles = document.querySelectorAll('[data-dropdown-toggle]');
        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var dropdown = toggle.closest('.dropdown');
                if (!dropdown) return;
                var menu = dropdown.querySelector('.dropdown-menu');
                if (!menu) return;
                var isOpen = menu.classList.contains('show');
                closeAllDropdowns();
                if (!isOpen) {
                    menu.classList.add('show');
                    dropdown.classList.add('show');
                }
            });
        });

        // AdminLTE compatibility: data-toggle="dropdown"
        var adminToggles = document.querySelectorAll('[data-toggle="dropdown"]');
        adminToggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var dropdown = toggle.closest('.dropdown');
                if (!dropdown) return;
                var menu = dropdown.querySelector('.dropdown-menu');
                if (!menu) return;
                var isOpen = menu.classList.contains('show');
                closeAllDropdowns();
                if (!isOpen) {
                    menu.classList.add('show');
                    dropdown.classList.add('show');
                }
            });
        });

        document.addEventListener('click', function () {
            closeAllDropdowns();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeAllDropdowns();
        });
    }

    /* ============================================
       Forms
       ============================================ */

    function initFormValidation() {
        var forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                var requiredFields = form.querySelectorAll('[required]');
                var isValid = true;
                requiredFields.forEach(function (field) {
                    if (!field.value || field.value.trim() === '') {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                if (!isValid) {
                    e.preventDefault();
                    var firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) firstInvalid.focus();
                }
            });
            form.querySelectorAll('.is-invalid').forEach(function (field) {
                field.addEventListener('input', function () {
                    field.classList.remove('is-invalid');
                });
            });
        });
    }

    function initConfirmForms() {
        var forms = document.querySelectorAll('form[data-confirm]');
        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                var message = form.getAttribute('data-confirm') || 'Are you sure?';
                if (!window.confirm(message)) e.preventDefault();
            });
        });
    }

    function initConfirmLinks() {
        var links = document.querySelectorAll('[data-confirm]');
        links.forEach(function (link) {
            if (link.tagName === 'FORM') return;
            link.addEventListener('click', function (e) {
                var message = link.getAttribute('data-confirm') || 'Are you sure?';
                if (!window.confirm(message)) e.preventDefault();
            });
        });
    }

    function initAutoSubmit() {
        var selects = document.querySelectorAll('[data-auto-submit]');
        selects.forEach(function (select) {
            select.addEventListener('change', function () {
                var form = select.closest('form');
                if (form) form.submit();
            });
        });
    }

    /* ============================================
       Admin Pages
       ============================================ */

    function initTableSearch() {
        var searchInputs = document.querySelectorAll('[data-table-search]');
        searchInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                var tableId = input.getAttribute('data-table-search');
                var table = document.getElementById(tableId);
                if (!table) return;
                var searchTerm = input.value.toLowerCase().trim();
                var rows = table.querySelectorAll('tbody tr');
                rows.forEach(function (row) {
                    var text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    }

    function initSelectAll() {
        var selectAllCheckboxes = document.querySelectorAll('[data-select-all]');
        selectAllCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var tableId = checkbox.getAttribute('data-select-all');
                var table = document.getElementById(tableId);
                if (!table) return;
                var rowCheckboxes = table.querySelectorAll('tbody input[type="checkbox"]');
                rowCheckboxes.forEach(function (rowCheckbox) {
                    rowCheckbox.checked = checkbox.checked;
                });
            });
        });
    }

    function initBulkActions() {
        var bulkButtons = document.querySelectorAll('[data-bulk-action]');
        bulkButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var formId = button.getAttribute('data-bulk-action');
                var form = document.getElementById(formId);
                if (form) form.submit();
            });
        });
    }

    /* ============================================
       AdminLTE Compatibility - Card widgets
       ============================================ */

    function initCardWidgets() {
        // Collapse card: data-card-widget="collapse"
        var collapseButtons = document.querySelectorAll('[data-card-widget="collapse"]');
        collapseButtons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                var card = button.closest('.card');
                if (!card) return;
                card.classList.toggle('collapsed-card');
                var body = card.querySelector('.card-body');
                if (body) body.style.display = body.style.display === 'none' ? '' : 'none';
            });
        });

        // Remove card: data-card-widget="remove"
        var removeButtons = document.querySelectorAll('[data-card-widget="remove"]');
        removeButtons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                var card = button.closest('.card');
                if (card) card.remove();
            });
        });

        // Chat pane toggle: data-widget="chat-pane-toggle"
        var chatToggles = document.querySelectorAll('[data-widget="chat-pane-toggle"]');
        chatToggles.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                var card = button.closest('.card');
                if (!card) return;
                card.classList.toggle('direct-chat-contacts-open');
                var contacts = card.querySelector('.direct-chat-contacts');
                if (contacts) contacts.style.display = contacts.style.display === 'none' ? '' : 'none';
            });
        });
    }

    /* ============================================
       AdminLTE Compatibility - Tooltips
       ============================================ */

    function initTooltips() {
        var tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
        tooltips.forEach(function (el) {
            el.setAttribute('title', el.getAttribute('title') || el.getAttribute('data-original-title') || '');
        });
    }

    /* ============================================
       AdminLTE Compatibility - Tabs
       ============================================ */

    function initTabs() {
        var tabLinks = document.querySelectorAll('[data-toggle="tab"]');
        tabLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                var target = document.querySelector(link.getAttribute('href'));
                if (!target) return;

                // Deactivate siblings
                var tabPane = link.closest('.tab-content') || link.closest('.card');
                if (tabPane) {
                    var allPanes = tabPane.querySelectorAll('.tab-pane');
                    allPanes.forEach(function (pane) {
                        pane.classList.remove('active');
                    });
                }

                // Deactivate all nav links in the same nav
                var nav = link.closest('.nav');
                if (nav) {
                    var allLinks = nav.querySelectorAll('.nav-link');
                    allLinks.forEach(function (l) {
                        l.classList.remove('active');
                    });
                }

                target.classList.add('active');
                link.classList.add('active');
            });
        });
    }

    /* ============================================
       Init on DOM ready
       ============================================ */

    document.addEventListener('DOMContentLoaded', function () {
        initSidebarToggle();
        initTreeview();
        initSidebarOverlay();
        initDismissibleAlerts();
        initAutoDismiss();
        initDropdowns();
        initFormValidation();
        initConfirmForms();
        initConfirmLinks();
        initAutoSubmit();
        initTableSearch();
        initSelectAll();
        initBulkActions();
        initCardWidgets();
        initTooltips();
        initTabs();
    });
})();