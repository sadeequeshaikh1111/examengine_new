<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>ExamEngine - Exam Platform</title>

<!-- Bootstrap 5 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">

<!-- Custom design system + exam-specific styles -->
<link rel="stylesheet" href="{{ asset('custom_assets/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/exam.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/cards.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/timer.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/palette.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/buttons.css') }}">
<link rel="stylesheet" href="{{ asset('custom_assets/css/forms.css') }}">

<!-- Existing shared helper scripts (option generation, kept for compatibility) -->
<script src="{{ asset('assets\js\jquery-3.5.1.slim.min.js')}}"></script>
<script src="{{ asset('assets\js\create_options.js')}}"></script>
<script src="{{ asset('assets\js\Set_platform.js')}}"></script>
<script src="{{ asset('assets\js\endexam.js')}}"></script>
</head>
<body id="body">

<div class="exam-shell">
  <div class="row g-3">

    <!-- LEFT PANEL -->
    <div class="col-lg-4 col-xl-3">
      <div class="exam-left-panel">

        <div class="candidate-card mb-3">
          <img
            src="{{ asset('drive/'.$drive['exam_id'].'/candidate_photo/'.$data['reg_no'].'.png') }}"
            id="img" class="candidate-photo" alt="Candidate Photo">
          <div class="candidate-name">{{ $data['name'] }}</div>
          <div class="candidate-meta">Reg. No: <span id="reg_no">{{ $data['reg_no'] }}</span></div>
          <div class="candidate-meta">System No: <span>{{ $data['node'] }}</span></div>
        </div>

        <div id="timer" class="exam-timer">00:00:00</div>

        <h6 class="mt-3 mb-2">Subjects</h6>
        <div class="subject-tabs">
          @foreach($subs as $sub)
            <button type="button" id="{{ $sub['subject_name'] }}" class="subject-tab">
              {{ $sub['subject_name'] }}
            </button>
          @endforeach
        </div>

        <div class="palette-legend">
          <span><span class="legend-swatch legend-swatch--notvisited"></span>Not Visited</span>
          <span><span class="legend-swatch legend-swatch--visited"></span>Visited</span>
          <span><span class="legend-swatch legend-swatch--answered"></span>Answered</span>
          <span><span class="legend-swatch legend-swatch--marked"></span>For Review</span>
          <span><span class="legend-swatch legend-swatch--current"></span>Current</span>
        </div>

        <div id="main">
          @foreach($subs as $sub)
            <div id="div_{{ $sub['subject_name'] }}">
              <div class="palette-grid">
                @for($i = $sub['qn_range_start']; $i < $sub['questions'] + $sub['qn_range_start']; $i++)
                  <button type="button" id="{{ $i }}" class="palette-btn palette-btn--notvisited">{{ $i }}</button>
                @endfor
              </div>
            </div>
          @endforeach
        </div>

      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="col-lg-8 col-xl-9">
      <div class="exam-right-panel">

        <div class="exam-toolbar">
          <span class="qn-label">Question Number: <label id="qn_lbl" for="Qn"></label></span>
          <select name="lang" id="LANG" class="form-select form-select-sm lang-select">
            @foreach($languages as $lang)
              <option value="{{ $lang['language_script'] }}">{{ $lang['language_script'] }}</option>
            @endforeach
          </select>
        </div>

        <div id="Question_container" class="question-container">
          <div id="qtools"></div>
          Loading question…
        </div>

        <div id="options_panel">
          <ul class="option-choice-list">
            <li class="option-choice" id="optiondiv_1">
              <input type="radio" id="option1" name="options" value="1">
              <label for="option1">Option 1</label>
            </li>
            <li class="option-choice" id="optiondiv_2">
              <input type="radio" id="option2" name="options" value="2">
              <label for="option2">Option 2</label>
            </li>
            <li class="option-choice" id="optiondiv_3">
              <input type="radio" id="option3" name="options" value="3">
              <label for="option3">Option 3</label>
            </li>
            <li class="option-choice" id="optiondiv_4">
              <input type="radio" id="option4" name="options" value="4">
              <label for="option4">Option 4</label>
            </li>
          </ul>
        </div>

        <div id="response" class="exam-action-bar">
          <button id="save_next_btn" type="button" class="btn btn-primary">Save &amp; Next</button>
          <button id="clear_btn" type="button" class="btn btn-outline-secondary">Clear Response</button>
          <button id="mark_review_btn" type="button" class="btn btn-outline-primary">Mark For Review &amp; Next</button>
        </div>

        <div class="exam-end-bar">
          <button id="end_exam_btn" type="button" class="btn btn-danger">End Exam</button>
        </div>

        <form name="end_test_form" id="end_test_form" action="end_test" method="post" class="d-none">
          @csrf
          <input type="hidden" name="reg_no" id="end_test_reg_no" value="{{ $data['reg_no'] }}">
          <button id="start_exam_btn" type="submit" class="btn btn-primary btn-block">Submit exam</button>
        </form>

      </div>
    </div>

  </div>
</div>

<!-- Exam configuration passed from Blade to vanilla JS -->
<script>
  window.ExamConfig = {
    regNo: @json($data['reg_no']),
    examId: @json($drive['exam_id']),
    csrfToken: @json(csrf_token()),
    driveAssetBase: @json(URL::asset('drive')),
    routes: {
      updateTime: @json(route('update_time.update')),
      saveAnswer: @json(route('Log_answer.save')),
      saveCurrent: @json(route('Log_current_qn.save')),
      endExam: @json(route('end_exam.save'))
    }
  };
</script>

<script src="{{ asset('custom_assets/js/app.js') }}"></script>
<script src="{{ asset('custom_assets/js/exam.js') }}"></script>
</body>
</html>