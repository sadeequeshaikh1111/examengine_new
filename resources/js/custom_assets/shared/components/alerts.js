/**
 * Design System - Alerts
 * Vanilla JS for dismissible alerts
 */

(function () {
    'use strict';

    /**
     * Initialize dismissible alerts
     * Usage: <div class="alert alert-dismissible">...<button class="close" data-dismiss="alert">&times;</button></div>
     */
    function initDismissibleAlerts() {
        const closeButtons = document.querySelectorAll('[data-dismiss="alert"]');

        closeButtons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const alert = button.closest('.alert');
                if (alert) {
                    alert.remove();
                }
            });
        });
    }

    /**
     * Auto-dismiss alerts after a delay
     * Usage: <div class="alert" data-auto-dismiss="5000">...</div>
     */
    function initAutoDismiss() {
        const autoDismissAlerts = document.querySelectorAll('[data-auto-dismiss]');

        autoDismissAlerts.forEach(function (alert) {
            const delay = parseInt(alert.getAttribute('data-auto-dismiss'), 10) || 5000;
            setTimeout(function () {
                alert.remove();
            }, delay);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initDismissibleAlerts();
        initAutoDismiss();
    });
})();