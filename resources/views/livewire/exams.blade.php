<div class="m-4 p-4" x-init="setInterval(() => { $wire.live_check(); }, 1500);">
  @php
    use Illuminate\Support\Facades\Auth;
  @endphp
  @if ($server_is_live)

    @if ($start)
      <div class="row" style="color: white;" x-data="{
          secondsLeft: {{ $remainingTime }},
          examDuration: {{ $remainingTime }}
      }" x-init="setInterval(() => {
          if (secondsLeft > 1) {
              secondsLeft--;
          } else {
              $wire.submit();
          }
      }, 1000);">
        <div class="col-lg-2">
          <strong>{{ \Illuminate\Support\Str::upper($exam->title) }}</strong>

        </div>
        <div class="col-lg-8">
          <center>{{ Auth::user()->name }}</center>
          <input class="mode" id="theme-mode" type="checkbox" hidden="" />
          <div class="btn_container">
            <div class="wrap">
              @foreach ($subjects as $key => $subject)
                {{-- @dd($subject, $currentSubject, $key, $subjects) --}}
                <input class="rd-{{ $key + 1 }}" id="rd-{{ $key + 1 }}" name="number-selector" type="radio"
                  value="subject{{ $key + 1 }}" {{ $currentSubjectIndex == $key + 1 ? 'checked' : '' }} />
                <label class="label" for="rd-{{ $key + 1 }}" style="--index: {{ $key + 1 - 1 }};"
                  wire:click='change_subject("{{ write($key) }}")'><span>{{ \Illuminate\Support\Str::upper($subject['title']) }}</span></label>
              @endforeach

              <div class="bar"></div>
              <div class="slidebar"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-2">
          <strong class="p-2" :class="{ 'text-danger': secondsLeft / 60 < 3 }">
            <span class="font-bold" x-text="parseInt(secondsLeft / 60)"></span>:
            <span class="font-bold" x-text="parseInt(secondsLeft % 60)"></span>
          </strong>
        </div>
        <div class="row">

          <div class="col-9" style=" height: 80vh; overflow-x: scroll;">
            <div class="mt-4">
              <div>
                <hr>
                <p class="mb-2 text-2xl">
                  <strong>Question {{ $currentQuestionIndex + 1 }} </strong> -
                  {{ $currentQuestion['text'] }}
                </p>
                @if ($currentQuestion['code_snippet'])
                  <hr>
                  <pre class="mb-4 border-2 border-solid p-2">{{ $currentQuestion['code_snippet'] }}</pre>
                @endif
                <hr>
                <div class="row">
                  <div class="col-lg-6">

                    @foreach ($currentQuestion['options'] as $key => $option)
                      <div>
                        <label for="option.{{ $option['id'] }}"
                          @if ($can_review) style="{{ $option['is_correct'] ? 'color: green!important;' : '' }}
                    {{ $selected_option == $option['id'] && !$option['is_correct'] ? 'color: red!important;' : '' }}" @endif
                          wire:click='answer("{{ write($option['id']) }}")'>

                          <strong>
                            @if ($key == 0)
                              A
                            @elseif($key == 1)
                              B
                            @elseif($key == 2)
                              C
                            @elseif($key == 3)
                              D
                            @endif
                          </strong>

                          <input id="option.{{ $option['id'] }}" name="questionsAnswers.{{ $currentQuestionIndex }}"
                            type="radio" value="{{ $option['id'] }}"
                            {{ $selected_option == $option['id'] ? 'checked' : '' }}>
                          {{ $option['option'] }}
                          @if ($can_review)
                            {{ $option['is_correct'] ? 'Correct' : '' }}
                            {{ $selected_option == $option['id'] && !$option['is_correct'] ? 'Wrong' : '' }}
                          @endif
                        </label>

                      </div>
                    @endforeach
                  </div>

                  <div class="col-lg-2">
                    @if ($currentQuestion['image'])
                      <div class="frame">

                        <img src="{{ asset('storage/' . $currentQuestion['image']) }}">

                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-3">

            <div class="col-12 d-flex">
              <style>

              </style>
              <div class="row">
                <div class="col-12">
                  <div class="checkbox-container"
                    style="width: 100%; text-align: left; height: 60vh; overflow-x: scroll; border: 2px solid rgba(0, 0, 255, 0.286); border-radius: 5px;">
                    <table style="width: 95%; border-collapse: collapse;">
                      <tbody>
                        @php
                          $count = 0;
                          $grid = 0;
                        @endphp

                        @foreach ($questions as $key => $question)
                          @if ($grid == 0)
                            <tr> <!-- Start a new row -->
                          @endif
                          {{-- @dd($this, $question) --}}
                          @php
                            // foreach ($attemptedQuestions as $attemptedQuestion) {
                            //     // @dd($attemptedQuestion, $question['id']);
                            //     if ($attemptedQuestion == $question['id']) {
                            //         $isAttempted = true;
                            //         break;
                            //     } else {
                            //         $isAttempted = false;
                            //     }
                            // }
                            $isAttempted = in_array($question['id'], $attemptedQuestions);
                          @endphp

                          <td style="padding: 5px; text-align: center;"
                            wire:click='jump_question("{{ write($key) }}")'>
                            <input class="btn day-btn" id="q{{ ++$count }}" type="checkbox"
                              value="{{ $question['id'] }}" wire:model='attemptedQuestions' readonly disabled
                              {{ $isAttempted ? 'checked' : '' }} />

                            <label
                              class="btn day-label {{ $question['id'] == $currentQuestion['id'] ? 'border-warning' : '' }}"
                              for="q{{ $count }}">{{ $key + 1 }}</label>
                          </td>

                          @php $grid++; @endphp

                          @if ($grid == 5)
                            </tr> <!-- Close the row after 5 columns -->
                            @php $grid = 0; @endphp
                          @endif
                        @endforeach

                        @if ($grid != 0)
                          </tr> <!-- Ensure last row closes properly -->
                        @endif

                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12">
                  <div style="display: flex; justify-content: space-between; margin-top: 10px; margin-bottom: 15px;">
                    <div class="button-ctl_container">
                      <button class="button-3d" wire:click='previous'>
                        <div class="button-top">
                          <span class="material-icons">❮</span>
                        </div>
                        <div class="button-bottom"></div>
                        <div class="button-base"></div>
                      </button>
                      <button class="button-3d"
                        wire:confirm="Are you sure you want to submit this Exam, THIS ACTION CAN NOT BE UNDONE!!!"
                        wire:click='submit'>
                        <div class="button-top">
                          <span class="material-icons">Submit</span>
                        </div>
                        <div class="button-bottom"></div>
                        <div class="button-base"></div>
                      </button>
                      <button class="button-3d" wire:click='next'>
                        <div class="button-top">
                          <span class="material-icons">❯</span>
                        </div>
                        <div class="button-bottom"></div>
                        <div class="button-base"></div>
                      </button>
                    </div>

                    {{-- @if ($can_submit)
                      <button class="ctl-button">
                        Submit
                      </button>
                    @else
                      <button class="ctl-button" wire:click='next'>
                        Next
                      </button>
                    @endif
                    <button class="ctl-button" wire:click='previous'>
                      Previous
                    </button> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <hr>
      </div>
    @elseif ($finished)
      <div>
        <div class="e-card playing">
          <div class="image"></div>
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="infotop" style="z-index: 8000; color: white !important;">
            <h2>{{ Auth::user()->school->name }}</h2>
            <br>
            <img class="image" src="{{ asset('thumb_up.png') }}" width="45" />
            <br>
            {{ Auth::user()->name }}
            <br>
            {{-- <div class="name">{{ Auth::user()->email }}</div> --}}
            @if ($exam->is_mock)
              @if ($school->allow_mock_result)
                Score: {{ $score }}
                <br>
              @endif
            @else
              @if ($school->allow_live_result)
                Score: {{ $score }}
                <br>
              @endif
            @endif
            Attempt: {{ $attempt_count }}
            <br>
            Question: {{ $question_count }}
            <br>
            {{ $exam->title }}
            <br>
            @if ($exam->is_mock && $school->allow_mock_review)
              <button class="btn btn-success" wire:click='reveil'>View Answers!</button>
            @else
              <br>
              <livewire:thanks />
            @endif
          </div>
        </div>
      </div>
    @else
      <div class="card w-full" style="background-color: #ffffff00; border: none;">
        <div class="card-header">
          <div class="card-row">
            <h2 class="card-title h2" style='color: white;'>
              <b>
                <center>My Exams</center>
              </b>
            </h2>
          </div>
        </div>
        <div class="card-body">
          <div class="cards flex flex-wrap pt-3">
            @foreach ($exams as $exam)
              <div class="cardh w-full px-4 py-2 lg:w-6/12 xl:w-3/12">
                <div class="relative mb-6 flex min-w-0 flex-col break-words rounded shadow-lg xl:mb-0"
                  style="background-color: #000000; width: 950px; border: 2px double rgb(255, 255, 255); color: white;">
                  <div class="d-flex-auto p-4">
                    <h3 style="color: #ffffff;"><strong>{{ \Illuminate\Support\Str::upper($exam->title) }}</strong>
                    </h3>
                    <div class="bg-black text-center" style="justify-content: space-between;">

                      <p class="text-sm">Subjects:
                        @foreach ($exam->subjects as $subject)
                          <button
                            class="btn btn-sm btn-light m-2">{{ \Illuminate\Support\Str::upper($subject->title) }}
                            [Q:{{ count($subject->questions) }}]</button>
                        @endforeach
                      </p>
                      <p class="text-sm"><strong>Duration: </strong>
                        {{ floor((\Carbon\Carbon::parse($exam->finish_time)->timestamp - \Carbon\Carbon::parse($exam->start_time)->timestamp) / 60) }}
                        Minutes
                        {{-- {{ (\Carbon\Carbon::parse($exam->finish_time)->timestamp - \Carbon\Carbon::parse($exam->start_time)->timestamp) % 60 }} --}}
                      </p>
                      <p><strong>Intruction: </strong> {{ $exam->description }}</p>
                      <button class="start_x" onclick="enterFullScreen()"
                        wire:click='start_x("{{ write($exam->id) }}")'>
                        S t a r t
                        <div id="clip">
                          <div class="corner" id="leftTop"></div>
                          <div class="corner" id="rightBottom"></div>
                          <div class="corner" id="rightTop"></div>
                          <div class="corner" id="leftBottom"></div>
                        </div>
                        <span class="arrow" id="rightArrow"></span>
                        <span class="arrow" id="leftArrow"></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

      </div>
    @endif
  @else
    <div class="d-flex justify-center" style="justify-content: center;">
      <livewire:Loading.Circle />

    </div>
    <div style="justify-content: center; color: whitesmoke; text-align: center;">
      <p>Welcome {{ Auth::user()->name }}</p>
      <p>Exams on there way</p>
      <h1>Welcome to {{ Auth::user()->school->name }}</h1>
      <p>Pleaser Wait Before the Exams Begins</p>
      <p>Please Avoide Anything that will harm your Exam</p>
    </div>
    <h1 style="text-align: center; font-weight: bold; color: whitesmoke;"></h1>
  @endif

  <script>
    const alert_sound = new Audio("alert.mp3");
    document.addEventListener("keydown", function(event) {
      if (
        event.key === "F11" || // Disable F11 (exit fullscreen)
        event.key === "Escape" || // Disable ESC (exit fullscreen)
        (event.ctrlKey && event.key === "Tab") || // Disable Ctrl+Tab (switch tabs)
        (event.altKey && event.key === "Tab") || // Disable Alt+Tab (switch windows)
        (event.ctrlKey && event.key === "w") || // Disable Ctrl+W (close tab)
        (event.metaKey && event.key === "q") || // Disable Cmd+Q (Mac quit)
        (event.ctrlKey && event.shiftKey && event.key === "I") // Disable Ctrl+Shift+I (Dev Tools)
      ) {
        event.preventDefault();
        alert_sound.currentTime = 0;
        alert_sound.play();
      }
    });

    // document.addEventListener("DOMContentLoaded", function() {
    function enterFullScreen() {
      let elem = document.documentElement;
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) { // Firefox
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) { // Chrome, Safari, Opera
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) { // IE/Edge
        elem.msRequestFullscreen();
      }
    }

    // Trigger full-screen mode


    // Prevent F11 and Escape key from exiting full-screen
    document.addEventListener("keydown", function(event) {
      if (event.key === "F11" || event.key === "Escape") {
        event.preventDefault();
      }
    });

    // Detect if user exits full-screen and force re-entry
    document.addEventListener("fullscreenchange", function() {
      if (!document.fullscreenElement) {
        enterFullScreen();
      }
    });

    document.addEventListener("visibilitychange", function() {
      if (document.hidden) {
        alert_sound.currentTime = 0;
        alert_sound.play();
      }
    });
    // });
  </script>
</div>
