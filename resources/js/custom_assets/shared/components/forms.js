/**
 * Design System - Forms
 * Vanilla JS for form validation and behaviors
 */

(function () {
    'use strict';

    /**
     * Initialize form validation
     * Usage: <form data-validate>...</form>
     * Fields with `required` attribute are validated on submit
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');

        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

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
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                }
            });

            // Clear validation state on input
            form.querySelectorAll('.is-invalid').forEach(function (field) {
                field.addEventListener('input', function () {
                    field.classList.remove('is-invalid');
                });
            });
        });
    }

    /**
     * Initialize confirm dialogs on forms
     * Usage: <form data-confirm="Are you sure?">...</form>
     */
    function initConfirmForms() {
        const forms = document.querySelectorAll('form[data-confirm]');

        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                const message = form.getAttribute('data-confirm') || 'Are you sure?';
                if (!window.confirm(message)) {
                    e.preventDefault();
                }
            });
        });
    }

    /**
     * Initialize confirm dialogs on buttons/links
     * Usage: <a href="..." data-confirm="Are you sure?">Delete</a>
     */
    function initConfirmLinks() {
        const links = document.querySelectorAll('[data-confirm]');

        links.forEach(function (link) {
            if (link.tagName === 'FORM') return;

            link.addEventListener('click', function (e) {
                const message = link.getAttribute('data-confirm') || 'Are you sure?';
                if (!window.confirm(message)) {
                    e.preventDefault();
                }
            });
        });
    }

    /**
     * Initialize auto-submit on select change
     * Usage: <select data-auto-submit>...</select>
     */
    function initAutoSubmit() {
        const selects = document.querySelectorAll('[data-auto-submit]');

        selects.forEach(function (select) {
            select.addEventListener('change', function () {
                const form = select.closest('form');
                if (form) {
                    form.submit();
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initFormValidation();
        initConfirmForms();
        initConfirmLinks();
        initAutoSubmit();
    });
})();