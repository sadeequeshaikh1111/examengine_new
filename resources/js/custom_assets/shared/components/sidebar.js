/**
 * Design System - Sidebar
 * Vanilla JS for sidebar toggle and treeview navigation
 */

(function () {
    'use strict';

    /**
     * Toggle sidebar collapsed state
     */
    function initSidebarToggle() {
        const toggler = document.querySelector('[data-sidebar-toggle]');
        if (!toggler) return;

        toggler.addEventListener('click', function (e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-collapsed');
        });
    }

    /**
     * Toggle treeview (nested menu) items
     */
    function initTreeview() {
        const treeviewToggles = document.querySelectorAll('.sidebar-nav .nav-item.has-treeview > .nav-link');

        treeviewToggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = toggle.parentElement;
                parent.classList.toggle('menu-open');
            });
        });
    }

    /**
     * Mobile sidebar overlay
     */
    function initSidebarOverlay() {
        const overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) return;

        overlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-collapsed');
            overlay.classList.remove('show');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSidebarToggle();
        initTreeview();
        initSidebarOverlay();
    });
})();