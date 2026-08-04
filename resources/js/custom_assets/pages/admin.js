/**
 * Design System - Admin Pages
 * Vanilla JS for admin panel functionality
 */

(function () {
    'use strict';

    /**
     * Table search/filter
     * Usage: <input data-table-search="tableId"> <table id="tableId">...</table>
     * Filters rows based on text content
     */
    function initTableSearch() {
        const searchInputs = document.querySelectorAll('[data-table-search]');

        searchInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                const tableId = input.getAttribute('data-table-search');
                const table = document.getElementById(tableId);
                if (!table) return;

                const searchTerm = input.value.toLowerCase().trim();
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(function (row) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        });
    }

    /**
     * Select all checkbox in tables
     * Usage: <input type="checkbox" data-select-all="tableId"> <table id="tableId">...</table>
     */
    function initSelectAll() {
        const selectAllCheckboxes = document.querySelectorAll('[data-select-all]');

        selectAllCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const tableId = checkbox.getAttribute('data-select-all');
                const table = document.getElementById(tableId);
                if (!table) return;

                const rowCheckboxes = table.querySelectorAll('tbody input[type="checkbox"]');
                rowCheckboxes.forEach(function (rowCheckbox) {
                    rowCheckbox.checked = checkbox.checked;
                });
            });
        });
    }

    /**
     * Bulk action submit
     * Usage: <button data-bulk-action="formId">Apply</button> <form id="formId">...</form>
     */
    function initBulkActions() {
        const bulkButtons = document.querySelectorAll('[data-bulk-action]');

        bulkButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const formId = button.getAttribute('data-bulk-action');
                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initTableSearch();
        initSelectAll();
        initBulkActions();
    });
})();