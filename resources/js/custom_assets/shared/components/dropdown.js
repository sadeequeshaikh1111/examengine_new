/**
 * Design System - Dropdown
 * Vanilla JS for dropdown menus
 */

(function () {
    'use strict';

    /**
     * Initialize dropdown toggles
     * Usage: <div class="dropdown"><button data-dropdown-toggle>...</button><div class="dropdown-menu">...</div></div>
     */
    function initDropdowns() {
        const toggles = document.querySelectorAll('[data-dropdown-toggle]');

        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const dropdown = toggle.closest('.dropdown');
                if (!dropdown) return;

                const menu = dropdown.querySelector('.dropdown-menu');
                if (!menu) return;

                const isOpen = menu.classList.contains('show');
                closeAllDropdowns();
                if (!isOpen) {
                    menu.classList.add('show');
                    dropdown.classList.add('show');
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function () {
            closeAllDropdowns();
        });

        // Close dropdowns on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeAllDropdowns();
            }
        });
    }

    /**
     * Close all open dropdowns
     */
    function closeAllDropdowns() {
        const openMenus = document.querySelectorAll('.dropdown-menu.show');
        openMenus.forEach(function (menu) {
            menu.classList.remove('show');
            const dropdown = menu.closest('.dropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initDropdowns();
    });
})();