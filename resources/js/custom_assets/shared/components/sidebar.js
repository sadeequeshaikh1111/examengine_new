/**
 * Design System - Sidebar
 * Vanilla JS for collapsible sidebar with accordion submenus
 * - Toggle sidebar collapse (desktop)
 * - Mobile sidebar open/close with overlay
 * - Accordion submenu behavior (only one section open at a time)
 * - Auto-expand section containing active page
 * - Highlight active menu item
 * - Persist state in localStorage
 */

(function () {
    'use strict';

    var STORAGE_KEY = 'ee_sidebar_state';
    var STORAGE_SECTION_KEY = 'ee_sidebar_section';

    /**
     * Get the current page identifier from the URL path
     */
    function getCurrentPage() {
        var path = window.location.pathname;
        var segments = path.split('/').filter(Boolean);
        return segments.length > 0 ? segments[segments.length - 1] : 'dashboard';
    }

    /**
     * Toggle sidebar collapsed state (desktop)
     */
    function initSidebarToggle() {
        var toggler = document.getElementById('sidebarToggle');
        if (!toggler) return;

        toggler.addEventListener('click', function (e) {
            e.preventDefault();
            var isMobile = window.innerWidth <= 991.98;

            if (isMobile) {
                // Mobile: toggle sidebar open/close
                document.body.classList.toggle('sidebar-mobile-open');
                var overlay = document.getElementById('sidebarOverlay');
                if (overlay) overlay.classList.toggle('show');
            } else {
                // Desktop: toggle collapsed state
                document.body.classList.toggle('sidebar-collapsed');
                var collapsed = document.body.classList.contains('sidebar-collapsed');
                try {
                    localStorage.setItem(STORAGE_KEY, collapsed ? 'collapsed' : 'expanded');
                } catch (err) {
                    // localStorage unavailable
                }
            }
        });
    }

    /**
     * Accordion submenu behavior
     * Only one top-level section remains expanded at a time
     */
    function initSubmenuAccordion() {
        var parents = document.querySelectorAll('.sidebar-menu .nav-parent');

        parents.forEach(function (parent) {
            parent.addEventListener('click', function (e) {
                e.preventDefault();

                var navItem = parent.closest('.nav-item');
                if (!navItem) return;

                var isOpen = navItem.classList.contains('submenu-open');

                // Close all other open submenus (accordion behavior)
                var allOpenItems = document.querySelectorAll('.sidebar-menu .nav-item.submenu-open');
                allOpenItems.forEach(function (item) {
                    if (item !== navItem) {
                        item.classList.remove('submenu-open');
                    }
                });

                // Toggle current
                if (isOpen) {
                    navItem.classList.remove('submenu-open');
                } else {
                    navItem.classList.add('submenu-open');
                }

                // Persist open section
                var section = parent.getAttribute('data-section');
                try {
                    if (section) {
                        localStorage.setItem(STORAGE_SECTION_KEY, section);
                    }
                } catch (err) {
                    // localStorage unavailable
                }
            });
        });
    }

    /**
     * Auto-expand the section containing the active page
     * and highlight the active menu item
     */
    function initActivePage() {
        var currentPage = getCurrentPage();
        var activeLink = null;

        // Find the nav link matching the current page
        var links = document.querySelectorAll('.sidebar-menu .nav-link[data-page]');
        links.forEach(function (link) {
            var page = link.getAttribute('data-page');
            if (page === currentPage) {
                activeLink = link;
            }
        });

        if (!activeLink) return;

        // Highlight active link
        activeLink.classList.add('active');

        // Auto-expand parent section
        var parentItem = activeLink.closest('.nav-item.has-submenu');
        if (parentItem) {
            parentItem.classList.add('submenu-open');
        }
    }

    /**
     * Restore persisted sidebar state
     */
    function restoreSidebarState() {
        // Restore collapsed/expanded state
        try {
            var state = localStorage.getItem(STORAGE_KEY);
            if (state === 'collapsed' && window.innerWidth > 991.98) {
                document.body.classList.add('sidebar-collapsed');
            }
        } catch (err) {
            // localStorage unavailable
        }

        // Restore open section (only if no active page section was auto-opened)
        var hasActiveSection = document.querySelector('.sidebar-menu .nav-item.submenu-open');
        if (hasActiveSection) return;

        try {
            var section = localStorage.getItem(STORAGE_SECTION_KEY);
            if (section) {
                var parent = document.querySelector('.sidebar-menu .nav-parent[data-section="' + section + '"]');
                if (parent) {
                    parent.closest('.nav-item').classList.add('submenu-open');
                }
            }
        } catch (err) {
            // localStorage unavailable
        }
    }

    /**
     * Mobile sidebar overlay
     */
    function initSidebarOverlay() {
        var overlay = document.getElementById('sidebarOverlay');
        if (!overlay) return;

        overlay.addEventListener('click', function () {
            document.body.classList.remove('sidebar-mobile-open');
            overlay.classList.remove('show');
        });
    }

    /**
     * Close mobile sidebar on resize to desktop
     */
    function initResizeHandler() {
        window.addEventListener('resize', function () {
            if (window.innerWidth > 991.98) {
                document.body.classList.remove('sidebar-mobile-open');
                var overlay = document.getElementById('sidebarOverlay');
                if (overlay) overlay.classList.remove('show');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSidebarToggle();
        initSubmenuAccordion();
        initActivePage();
        restoreSidebarState();
        initSidebarOverlay();
        initResizeHandler();
    });
})();