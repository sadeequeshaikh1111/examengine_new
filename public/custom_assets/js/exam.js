/**
 * ExamEngine - Candidate Exam Platform
 * Vanilla JS module. Relies on window.ExamConfig set inline in the Blade view.
 * Reuses existing backend routes/controllers - no backend changes required.
 */

(function () {
    'use strict';

    const cfg = window.ExamConfig || {};
    let currentQn = null;
    let timeRemaining = 0;
    let deadtime = 0;
    let timerIntervalId = null;

    /* ---------------- HTTP helpers ---------------- */

    function postJSON(url, data) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': cfg.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json().catch(function () { return null; });
        });
    }

    function getJSON(url) {
        return fetch(url, { headers: { 'Accept': 'application/json' } })
            .then(function (res) { return res.json(); });
    }

    /* ---------------- Timer ---------------- */

    function formatTime(totalSeconds) {
        const s = Math.max(totalSeconds, 0);
        const hr = Math.floor(s / 3600);
        const min = Math.floor((s % 3600) / 60);
        const sec = s % 60;
        const pad = function (n) { return String(n).padStart(2, '0'); };
        return pad(hr) + ':' + pad(min) + ':' + pad(sec);
    }

    function renderTimer() {
        const el = document.getElementById('timer');
        if (!el) return;
        el.textContent = formatTime(timeRemaining);
        el.classList.toggle('exam-timer--warning', timeRemaining < 900);
    }

    function updateTimeOnServer() {
        postJSON(cfg.routes.updateTime, { reg_no: cfg.regNo, time: timeRemaining, Dead: '0' })
            .catch(function () {
                alert('Connection lost. Please contact your Invigilator.');
                clearInterval(timerIntervalId);
            });
    }

    function timerTick() {
        if (timeRemaining % 10 === 0) updateTimeOnServer();
        timeRemaining--;
        renderTimer();
        if (timeRemaining <= 0) {
            clearInterval(timerIntervalId);
            submitExam();
        }
    }

    function startTimer() {
        getJSON('get_time/' + cfg.regNo).then(function (data) {
            timeRemaining = parseInt(data.time, 10) || 0;
            deadtime = parseInt(data.dead, 10) || 0;
            renderTimer();
            timerIntervalId = setInterval(timerTick, 1000);
        });
    }

    function refreshDeadtime() {
        getJSON('get_time/' + cfg.regNo).then(function (data) {
            deadtime = parseInt(data.dead, 10) || 0;
        });
    }

    /* ---------------- Palette ---------------- */

    const STATE_CLASSES = [
        'palette-btn--notvisited',
        'palette-btn--visited',
        'palette-btn--answered',
        'palette-btn--marked'
    ];

    function statusToClass(status) {
        switch (status) {
            case 'saved': return 'palette-btn--answered';
            case 'marked': return 'palette-btn--marked';
            case 'unanswered': return 'palette-btn--visited';
            case 'untouched':
            default: return 'palette-btn--notvisited';
        }
    }

    function setPaletteStatus(qn, status) {
        const btn = document.getElementById(String(qn));
        if (!btn) return;
        STATE_CLASSES.forEach(function (c) { btn.classList.remove(c); });
        btn.classList.add(statusToClass(status));
        btn.dataset.status = status;
    }

    function setPaletteCurrent(qn) {
        document.querySelectorAll('.palette-btn--current').forEach(function (b) {
            b.classList.remove('palette-btn--current');
        });
        const btn = document.getElementById(String(qn));
        if (btn) btn.classList.add('palette-btn--current');
    }

    function loadInitialPaletteState() {
        getJSON('get_qn_status/' + cfg.regNo).then(function (logs) {
            (logs || []).forEach(function (log) {
                const qn = log.sqn || log.question_number;
                if (qn !== undefined) setPaletteStatus(qn, log.status || 'untouched');
            });
        }).catch(function () { /* non-fatal */ });
    }

    /* ---------------- Subject navigation ---------------- */

    function showSubject(subjectId) {
        const target = 'div_' + String(subjectId).split(' ')[0];
        document.querySelectorAll('#main > div').forEach(function (div) {
            div.style.display = (div.id === target) ? '' : 'none';
        });
        document.querySelectorAll('.subject-tab').forEach(function (btn) {
            btn.classList.toggle('active', btn.id === subjectId);
        });
    }

    /* ---------------- Options rendering ---------------- */

    function clearSelections() {
        document.querySelectorAll('#options_panel input[type="radio"], #options_panel input[type="checkbox"]')
            .forEach(function (input) { input.checked = false; });
    }

    function collectSelection() {
        const opt1 = document.getElementById('option1');
        if (!opt1) return { selected: '0', isCheckbox: false };

        if (opt1.type === 'radio') {
            const checked = document.querySelector('input[name="options"]:checked');
            return { selected: checked ? checked.value : '0', isCheckbox: false };
        }

        const vals = ['option1', 'option2', 'option3', 'option4'].map(function (id) {
            const el = document.getElementById(id);
            return (el && el.checked) ? el.value : '0';
        });
        return { selected: vals.join(''), isCheckbox: true };
    }

    function buildDriveImageUrl(data, qn) {
        return cfg.driveAssetBase + '/' + cfg.examId + '/images/' + qn + (data.lang || '') + '.png';
    }

    function renderQuestion(data, qn) {
        const container = document.getElementById('Question_container');
        const qnLbl = document.getElementById('qn_lbl');
        if (qnLbl) qnLbl.textContent = data.sqn;

        // clear_option_divs / generate_options / generate_checkboxes /
        // Generate_TrueFalse_options come from create_options.js (existing shared script).
        if (typeof clear_option_divs === 'function') clear_option_divs();

        const qtype = String(data.qtype);
        if (qtype === '1') {
            container.innerHTML = data.question;
            if (typeof generate_options === 'function') {
                generate_options(data.option1, data.option2, data.option3, data.option4);
            }
        } else if (qtype === '2') {
            container.innerHTML = data.question;
            if (typeof Generate_TrueFalse_options === 'function') {
                Generate_TrueFalse_options(data.option1, data.option2);
            }
        } else if (qtype === '3' || qtype === '4' || qtype === '6') {
            container.innerHTML = '';
            const img = document.createElement('img');
            img.src = buildDriveImageUrl(data, qn);
            container.appendChild(img);
            if (qtype === '3' && typeof generate_options === 'function') {
                generate_options(data.option1, data.option2, data.option3, data.option4);
            } else if (qtype === '4' && typeof Generate_TrueFalse_options === 'function') {
                Generate_TrueFalse_options(data.option1, data.option2);
            } else if (qtype === '6' && typeof generate_checkboxes === 'function') {
                generate_checkboxes(data.option1, data.option2, data.option3, data.option4);
            }
        } else if (qtype === '5') {
            container.innerHTML = data.question;
            if (typeof generate_checkboxes === 'function') {
                generate_checkboxes(data.option1, data.option2, data.option3, data.option4);
            }
        }
    }

    function loadSavedAnswer(qn) {
        getJSON('get_qn_ans/' + cfg.regNo + '/' + qn).then(function (data) {
            if (!data) return;
            const ans = String(data.selected_ans || '0');
            const opt1 = document.getElementById('option1');
            if (opt1 && opt1.type === 'radio') {
                const radio = document.querySelector('input[name="options"][value="' + ans + '"]');
                if (radio) radio.checked = true;
            } else if (opt1 && ans.length === 4) {
                ['option1', 'option2', 'option3', 'option4'].forEach(function (id, i) {
                    const el = document.getElementById(id);
                    if (el) el.checked = ans[i] !== '0';
                });
            }
        }).catch(function () { /* no saved answer yet */ });
    }

    function GetQuestion(str) {
        
        const langEl = document.getElementById('LANG');
        const lang = langEl ? langEl.value : '';
        currentQn = str;

        getJSON('getQuestionbs/' + str + '/' + lang + '/' + cfg.regNo).then(function (data) {
            renderQuestion(data, str);
            setPaletteCurrent(str);
            if (data.sub) showSubject(data.sub);
            loadSavedAnswer(str);
            postCurrentStatus(str);
        });
    }

    function postCurrentStatus(qn) {
        postJSON(cfg.routes.saveCurrent, { reg_no: cfg.regNo, current_qn: qn }).catch(function () {});
    }

    function saveAnswerToServer(selectedAns, status) {
        return postJSON(cfg.routes.saveAnswer, {
            reg_no: cfg.regNo,
            selected_ans: selectedAns,
            Sqn: currentQn,
            status: status
        });
    }

    function nextQuestion() {
        GetQuestion(String(parseInt(currentQn, 10) + 1));
    }

    function saveAndNext() {
        if (!currentQn) return;
        const sel = collectSelection();
        const isBlank = sel.isCheckbox ? sel.selected === '0000' : sel.selected === '0';
        const status = isBlank ? 'unanswered' : 'saved';

        saveAnswerToServer(isBlank ? '0' : sel.selected, status).then(function () {
            setPaletteStatus(currentQn, status);
            nextQuestion();
        }).catch(function (err) {
            alert('Error saving answer: ' + err.message);
        });
    }

    function markForReviewAndNext() {
        if (!currentQn) return;
        const sel = collectSelection();
        const isBlank = sel.isCheckbox ? sel.selected === '0000' : sel.selected === '0';

        saveAnswerToServer(isBlank ? '0' : sel.selected, 'marked').then(function () {
            setPaletteStatus(currentQn, 'marked');
            nextQuestion();
        }).catch(function (err) {
            alert('Error saving answer: ' + err.message);
        });
    }

    function clearResponse() {
        if (!currentQn) return;
        clearSelections();
        saveAnswerToServer('0', 'unanswered').then(function () {
            setPaletteStatus(currentQn, 'unanswered');
        }).catch(function (err) {
            alert('Error clearing response: ' + err.message);
        });
    }

    /* ---------------- Language switch ---------------- */

    function langSelect() {
        if (currentQn) GetQuestion(currentQn);
    }

    /* ---------------- Submit exam ---------------- */

    function submitExam() {
        postJSON(cfg.routes.endExam, { reg_no: cfg.regNo }).then(function (data) {
            if (data) alert(typeof data === 'string' ? data : JSON.stringify(data));
            const form = document.getElementById('end_test_form');
            if (form) form.submit();
        }).catch(function (err) {
            alert('Error submitting exam: ' + err.message);
        });
    }

    function getConfirmation() {
        if (window.confirm('Do you want to Submit?')) submitExam();
    }

    /* ---------------- Wiring ---------------- */

    function init() {
        if (!cfg.regNo) return;

        document.querySelectorAll('.palette-btn').forEach(function (btn) {
            btn.addEventListener('click', function () { GetQuestion(btn.id); });
        });

        document.querySelectorAll('.subject-tab').forEach(function (btn) {
            btn.addEventListener('click', function () { showSubject(btn.id); });
        });

        const langEl = document.getElementById('LANG');
        if (langEl) langEl.addEventListener('change', langSelect);

        const saveBtn = document.getElementById('save_next_btn');
        if (saveBtn) saveBtn.addEventListener('click', saveAndNext);

        const clearBtn = document.getElementById('clear_btn');
        if (clearBtn) clearBtn.addEventListener('click', clearResponse);

        const markBtn = document.getElementById('mark_review_btn');
        if (markBtn) markBtn.addEventListener('click', markForReviewAndNext);

        const endBtn = document.getElementById('end_exam_btn');
        if (endBtn) endBtn.addEventListener('click', getConfirmation);

        loadInitialPaletteState();
        startTimer();
        setInterval(refreshDeadtime, 30000);

        // Show the first subject by default and load its first question.
        const firstSubjectTab = document.querySelector('.subject-tab');
        if (firstSubjectTab) {
            showSubject(firstSubjectTab.id);
            const firstQnBtn = document.querySelector('#main > div:not([style*="display: none"]) .palette-btn');
            if (firstQnBtn) GetQuestion(firstQnBtn.id);
        }
    }

    document.addEventListener('DOMContentLoaded', init);

    // Exposed for inline onclick fallback / debugging.
    window.ExamPlatform = {
        GetQuestion: GetQuestion,
        showSubject: showSubject,
        saveAndNext: saveAndNext,
        markForReviewAndNext: markForReviewAndNext,
        clearResponse: clearResponse,
        getConfirmation: getConfirmation
    };
})();