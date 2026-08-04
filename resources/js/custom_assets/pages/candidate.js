/**
 * Design System - Candidate Pages
 * Vanilla JS for candidate dashboard functionality
 */

(function () {
    'use strict';

    /**
     * Filter exam list by status
     * Usage: <select data-exam-filter>...</select> <div data-exam-list>...</div>
     * Exam items: <div class="exam-list-item" data-exam-status="active">...</div>
     */
    function initExamFilter() {
        const filterSelect = document.querySelector('[data-exam-filter]');
        if (!filterSelect) return;

        filterSelect.addEventListener('change', function () {
            const filterValue = filterSelect.value;
            const examItems = document.querySelectorAll('[data-exam-status]');

            examItems.forEach(function (item) {
                if (filterValue === 'all' || item.getAttribute('data-exam-status') === filterValue) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    /**
     * Countdown to exam start
     * Usage: <span data-exam-countdown="2025-01-01T10:00:00">...</span>
     */
    function initExamCountdown() {
        const countdownEls = document.querySelectorAll('[data-exam-countdown]');

        countdownEls.forEach(function (el) {
            const targetTime = new Date(el.getAttribute('data-exam-countdown')).getTime();
            if (isNaN(targetTime)) return;

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetTime - now;

                if (distance <= 0) {
                    el.textContent = 'Started';
                    clearInterval(interval);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let text = '';
                if (days > 0) text += days + 'd ';
                text += hours + 'h ' + minutes + 'm ' + seconds + 's';
                el.textContent = text;
            }

            updateCountdown();
            const interval = setInterval(updateCountdown, 1000);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initExamFilter();
        initExamCountdown();
    });
})();