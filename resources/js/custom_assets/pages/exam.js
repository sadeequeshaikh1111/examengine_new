/**
 * Design System - Exam Pages
 * Vanilla JS for exam platform functionality
 */

(function () {
    'use strict';

    /**
     * Exam countdown timer
     * Usage: <div data-exam-timer="3600">01:00:00</div>
     * The value is the duration in seconds
     */
    function initExamTimer() {
        const timerEl = document.querySelector('[data-exam-timer]');
        if (!timerEl) return;

        let remaining = parseInt(timerEl.getAttribute('data-exam-timer'), 10) || 0;

        function formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            const pad = function (num) {
                return String(num).padStart(2, '0');
            };

            return pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
        }

        function updateTimer() {
            timerEl.textContent = formatTime(remaining);

            if (remaining <= 0) {
                clearInterval(timerInterval);
                // Auto-submit the exam form if present
                const form = document.querySelector('form[data-exam-form]');
                if (form) {
                    form.submit();
                }
                return;
            }

            remaining--;
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    }

    /**
     * Question navigation (prev/next)
     * Usage: <button data-question-prev>Prev</button> <button data-question-next>Next</button>
     * Questions: <div class="question" data-question="1">...</div>
     */
    function initQuestionNavigation() {
        const prevBtn = document.querySelector('[data-question-prev]');
        const nextBtn = document.querySelector('[data-question-next]');
        const questions = document.querySelectorAll('[data-question]');

        if (questions.length === 0) return;

        let currentIndex = 0;

        function showQuestion(index) {
            if (index < 0 || index >= questions.length) return;

            questions.forEach(function (q, i) {
                q.style.display = i === index ? '' : 'none';
            });

            currentIndex = index;

            if (prevBtn) {
                prevBtn.disabled = currentIndex === 0;
            }
            if (nextBtn) {
                nextBtn.disabled = currentIndex === questions.length - 1;
            }

            // Update palette current state
            const paletteItems = document.querySelectorAll('[data-palette-item]');
            paletteItems.forEach(function (item, i) {
                item.classList.toggle('current', i === currentIndex);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                showQuestion(currentIndex - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                showQuestion(currentIndex + 1);
            });
        }

        showQuestion(0);
    }

    /**
     * Question palette navigation
     * Usage: <div data-palette-item="1">1</div>
     */
    function initPaletteNavigation() {
        const paletteItems = document.querySelectorAll('[data-palette-item]');

        paletteItems.forEach(function (item) {
            item.addEventListener('click', function () {
                const index = parseInt(item.getAttribute('data-palette-item'), 10) - 1;
                const questions = document.querySelectorAll('[data-question]');

                if (index >= 0 && index < questions.length) {
                    questions.forEach(function (q, i) {
                        q.style.display = i === index ? '' : 'none';
                    });

                    // Update current state
                    paletteItems.forEach(function (pi) {
                        pi.classList.remove('current');
                    });
                    item.classList.add('current');

                    // Update prev/next buttons
                    const prevBtn = document.querySelector('[data-question-prev]');
                    const nextBtn = document.querySelector('[data-question-next]');
                    if (prevBtn) prevBtn.disabled = index === 0;
                    if (nextBtn) nextBtn.disabled = index === questions.length - 1;
                }
            });
        });
    }

    /**
     * Option selection
     * Usage: <div class="option-item" data-option>...</div>
     * Marks the option as selected and updates the palette
     */
    function initOptionSelection() {
        const optionItems = document.querySelectorAll('.option-list .option-item');

        optionItems.forEach(function (item) {
            item.addEventListener('click', function () {
                const question = item.closest('[data-question]');
                if (!question) return;

                // Clear other selections in this question
                question.querySelectorAll('.option-item').forEach(function (opt) {
                    opt.classList.remove('selected');
                });

                // Select this option
                item.classList.add('selected');

                // Update palette item as answered
                const questionIndex = question.getAttribute('data-question');
                const paletteItem = document.querySelector('[data-palette-item="' + questionIndex + '"]');
                if (paletteItem) {
                    paletteItem.classList.add('answered');
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initExamTimer();
        initQuestionNavigation();
        initPaletteNavigation();
        initOptionSelection();
    });
})();