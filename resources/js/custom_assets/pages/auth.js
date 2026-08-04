/**
 * Design System - Auth Pages
 * Vanilla JS for login/authentication pages
 */

(function () {
    'use strict';

    /**
     * Toggle password visibility
     * Usage: <input type="password" data-password-toggle> <button data-toggle-password>Show</button>
     */
    function initPasswordToggle() {
        const toggleButtons = document.querySelectorAll('[data-toggle-password]');

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const targetSelector = button.getAttribute('data-toggle-password');
                const input = document.querySelector(targetSelector);
                if (!input) return;

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.textContent = isPassword ? 'Hide' : 'Show';
            });
        });
    }

    /**
     * Show/hide password strength indicator
     * Usage: <input type="password" data-password-strength> <div data-strength-meter>...</div>
     */
    function initPasswordStrength() {
        const passwordInputs = document.querySelectorAll('[data-password-strength]');

        passwordInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                const meter = document.querySelector('[data-strength-meter]');
                if (!meter) return;

                const value = input.value;
                let strength = 0;

                if (value.length >= 8) strength++;
                if (/[A-Z]/.test(value)) strength++;
                if (/[0-9]/.test(value)) strength++;
                if (/[^A-Za-z0-9]/.test(value)) strength++;

                meter.textContent = ['', 'Weak', 'Fair', 'Good', 'Strong'][strength] || '';
                meter.className = 'text-' + (strength <= 1 ? 'danger' : strength === 2 ? 'warning' : 'success');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initPasswordToggle();
        initPasswordStrength();
    });
})();