<div>

  @if (!$main_model)
    <div class="h-75 m-3 w-full bg-black" style="border-left: 2px solid #f40202; border-right: 2px solid #ff0000;">
      <div class="cards bg-black">
        <div class="row" style="justify-content: space-between;">
          <div class="col-3">
            <h5 style="width: fit-content; border-bottom: 1px solid #f40202; color: whitesmoke ;">
              {{ \Illuminate\Support\Str::upper($currentSubject->title ?? 'No Subject asign') }}</h5>
          </div>
          <div class="col-9 text-right" style="justify-content: right;">
            <input class="mode" id="theme-mode" type="checkbox" hidden="" />
            <div class="btn_container"
              style="justify-content: end !important; color: #fff !important; align-items: flex-end">
              <div class="d-flex float-right bg-black text-white" style="color: #fff !important;">
                @foreach ($staff->subjects as $key => $subject)
                  <button
                    class="btn btn-sm btn-{{ $currentSubject->id == $subject->id ? 'primary' : 'outline-primary' }} m-1"
                    wire:click='change_subject("{{ write($subject->id) }}")'>{{ \Illuminate\Support\Str::upper($subject->title) }}</button>
                @endforeach
                <button class="btn btn-sm float-center container-btn-file me-4 ms-2"
                  style="height: 40px; margin: auto; text-align: center;"
                  wire:click='upload_questions("{{ $currentSubject->id }}")'>
                  <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 50 50">
                    <path d="M28.8125 .03125L.8125 5.34375C.339844
                                5.433594 0 5.863281 0 6.34375L0 43.65625C0
                                44.136719 .339844 44.566406 .8125 44.65625L28.8125
                                49.96875C28.875 49.980469 28.9375 50 29 50C29.230469
                                50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844
                                30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625
                                .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32
                                6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34
                                29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49
                                43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44
                                13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938
                                21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219
                                22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375
                                15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125
                                28.28125C15.160156 28.054688 15.035156 27.636719 14.90625
                                27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719
                                14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36
                                20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z">
                    </path>
                  </svg>
                  Upload Questions
                </button>
                {{-- <button class="c-button float-center" type="button" style="margin: auto; text-align: center;"
                    wire:click='create_question'>
                    <span class="c-main">
                      <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                      Create
                    </span>
                  </button> --}}

                <div class="bar"></div>
                <div class="slidebar"></div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="mt-2 bg-black pt-2" style=" overflow-x: scroll; height: 65vh !important;">

          @if ($cormfirm_delete)
            <div class="d-flex h-full w-full"
              style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
              <div class="warning_card">
                <span>Are you Sure you want to Delete
                  <br>
                  <strong>{{ $question->text }}</strong>
                </span>
                <div class="d-flex justify-content-between">
                  <button class="btn btn-warning warning" wire:click='cancel_delete'>Cancel</button>
                  <button class="btn btn-success delete" wire:click='cormfirm_delete_question'>Delete</button>
                </div>
              </div>
            </div>
          @endif

          @if ($new_question)
            <div class="d-flex h-full w-full"
              style="background-color: #000000; z-index: 1000;  justify-content: center;">
              <div class="warning_card" style="color: #f7f7f7 !important; border: 2px solid #ff2600 !important;">
                <div class="button-ctl_container">
                  <button class="button-3d" wire:click='new_objective'>
                    <div class="button-top">
                      <span class="material-icons" style="color: #f7f7f7 !important; ">Objective</span>
                    </div>
                    <div class="button-bottom"></div>
                    <div class="button-base"></div>
                  </button>
                  <button class="button-3d" wire:click='new_easay'>
                    <div class="button-top">
                      <span class="material-icons" style="color: #f7f7f7 !important; ">Easay</span>
                    </div>
                    <div class="button-bottom"></div>
                    <div class="button-base"></div>
                  </button>
                </div>
              </div>
            </div>
          @endif

          <div class="cardh">
            <div class="cardi">
              <strong>
                <div class="row h5" style="padding: 5px !important; text-align: left;">
                  <div class="col-5"># Question [{{ count($currentSubject->questions) }}]</div>
                  <div class="col-2"></div>
                  <div class="col-1">Option A</div>
                  <div class="col-1">Option B</div>
                  <div class="col-1">Option C</div>
                  <div class="col-1">Option D</div>
                  <div class="col-1">Action</div>
                </div>
              </strong>
            </div>
          </div>
          @php
            $count = 0;
          @endphp
          @foreach ($currentSubject->questions as $question)
            <div class="cardh">
              <div class="cardi">
                <div class="row" style="padding: 5px !important; text-align: left;">
                  <div class="col-5"><strong>{{ ++$count }} - </strong>{{ $question->text }}</div>
                  <div class="col-2"></div>
                  @foreach ($question->options as $option)
                    <div class="col-1">{{ $option->option }}</div>
                  @endforeach
                  <div class="col-1">

                    <button class="btn btn-sm btn-outline-danger ms-2"
                      wire:click='delete_question("{{ $question->id }}")'><i class="bi bi-trash"></i></button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          <hr>
          <br>
        </div>
      </div>
    </div>
  @else
    <div class="m-3 bg-black"
      style="border-left: 2px solid #f40202; overflow-x: scroll; height: 65vh !important; border-right: 2px solid #f40202;">
      <div class="cards flex flex-wrap">
        <div class="bg-black">
          @if ($questions_upload)
            <hr>
            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
              x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
              x-on:livewire-upload-error="uploading = false"
              x-on:livewire-upload-progress="progress = $event.detail.progress">
              <div x-show="uploading">
                <div class="d-flex" style="justify-content: center;">
                  @livewire('loading.radar')
                </div>
              </div>
              <form class="upload_questions" style="margin: auto" x-show="!uploading" {{-- action="{{ route('question.upload') }}" --}}
                method="post" enctype="multipart/form-data">
                @csrf
                <h4 style="margin: auto; text-align: center; color: #fff !important;">{{ $currentSubject->title }}
                  Questions</h4>
                <button class="dismiss" type="button" wire:click='cancel_upload'><strong>X</strong></button>
                <p><br></p>

                <label class="input-div" for="questions_file"
                  style="margin: auto; text-align: center  color: #fff !important;">
                  <input class="excell_input" id="questions_file" name="questions_file" type="file"
                    wire:model.live='questions_file' {{ $questions_file ? 'hidden' : '' }} />
                  <input name="subject_id" type="text" wire:model.live='subject_id' hidden>

                  @if (!$questions_file)
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                      stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2"
                      fill="none" stroke="currentColor">
                      <polyline points="16 16 12 12 8 16"></polyline>
                      <line y2="21" x2="12" y1="12" x1="12"></line>
                      <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                      <polyline points="16 16 12 12 8 16"></polyline>
                    </svg>
                  @endif
                </label>
                @if ($questions_file)
                  <br>
                  @error('questions_file')
                    <h3 style="color: red; text-align: center;">
                      {{ $questions_file->getClientOriginalName() }}
                      <br>
                      {{ $message }}
                    </h3>
                  @else
                    <h4 class="text-center" style=" color: #fff !important;">
                      {{ $questions_file->getClientOriginalName() }}</h4>
                  @enderror
                  <div class="d-flex" style="justify-content: center;">
                    <button class="c-button float-center" type="button" style="margin: auto; text-align: center"
                      wire:click='confirm_upload'>
                      <span class="c-main">
                        <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                        Submit File
                      </span>
                    </button>
                  </div>
                @endif
                <br>
                <br>
                <br>
              </form>
            </div>
          @elseif ($new_question_model)
            <div class="m-4 p-4">
              <h1 class="text-center text-white">{{ $subject->title }}</h1>
              <style>
                .input-group-text {
                  border: 1px solid #ff0000;
                }
              </style>
              <div class="input-group input-group-lg mb-3">
                <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                  <label for="new_question_text">Question text</label>
                </div>
                <input class="form-control" type="text" value=""
                  style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                  wire:model.live='new_question_text' placeholder="Write Question test" autofocus
                  autocomplete="question">
              </div>
              <div class="form-group {{ $errors->has('questionOptions.*') ? 'invalid' : '' }}">
                <p class="required text-left" style="text-align: left !important; color: #f40202;">
                  <strong>Question Options</strong>
                </p>
                @foreach ($questionOptions as $index => $questionOption)
                  <div class="input-group input-group-lg mb-3">
                    <input class="form-control" id="questions_options_{{ $index }}"
                      name="questions_options_{{ $index }}" type="text"
                      style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                      placeholder="Write Option" wire:model.live="questionOptions.{{ $index }}.option"
                      autocomplete="off">
                    <div
                      class="flex items-center"style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);">
                      <input class="ml-4 mr-1" id="questionOptions.{{ $index }}.correct"
                        name="questionOptions.{{ $index }}.is_correct" type="checkbox"
                        wire:model.live="questionOptions.{{ $index }}.is_correct">
                      <label for="questionOptions.{{ $index }}.is_correct">Correct</label>
                      <button class="btn btn-danger ml-4" type="button"
                        wire:click="removeQuestionsOption({{ $index }})">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </div>
                  @error('questionOptions.*')
                    <div class="validation-message mt-2 text-sm">
                      {{ $errors->first('questionOptions.*') }}
                    </div>
                  @enderror
                @endforeach
                @error('questionOptions')
                  <div class="validation-message">
                    {{ $errors->first('questionOptions') }}
                  </div>
                @enderror
                <div class="align-left text-left">
                  <button class="btn btn-success mb-2 mt-2" type="button" style="text-align: left !important;"
                    wire:click="addQuestionsOption">
                    Add Option
                  </button>
                </div>
              </div>

              <div class="input-group input-group-lg mb-3">
                <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                  <label for="image">Question Image</label>
                </div>
                <input class="form-control" type="file"
                  style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                  wire:model.live='image' placeholder="Select Question Image" autocomplete="question">
              </div>

              <div class="input-group input-group-lg mb-3">
                <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                  <label for="new_question_code_snippet">Code Snippet</label>
                </div>
                <input class="form-control" type="text" value=""
                  style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                  wire:model.live='new_question_code_snippet' placeholder="Write Code snippet if any"
                  autocomplete="question">
              </div>

              <div class="input-group input-group-lg mb-3">
                <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                  <label for="new_question_answer_explanation">Answer Explanation</label>
                </div>
                <input class="form-control" type="text" value=""
                  style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                  wire:model.live='new_question_answer_explanation' placeholder="Write Answer Explanation if any"
                  autocomplete="question">
              </div>

              <div class="input-group input-group-lg mb-3">
                <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                  <label for="new_question_more_info_link">Usefull Link</label>
                </div>
                <input class="form-control" type="text" value=""
                  style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                  wire:model.live='new_question_more_info_link' placeholder="Write more info link if any"
                  autocomplete="question">
              </div>

              <br>

              <button class="c-button" style="margin: auto;" wire:click='create_new_obj_question'>
                <span class="c-main">
                  <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                  Create Question
                </span>
              </button>
            </div>
          @endif
        </div>
      </div>
    </div>
  @endif
</div>
