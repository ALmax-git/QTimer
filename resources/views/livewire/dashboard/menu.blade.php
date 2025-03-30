<div>

  @if ($main_model)
    <div class="modal-dialog modal-xl modal-dialog-scrollable"
      style="position: fixed; top: 10%; background-color: #d1d5db00 !important;">
      <div class="modal-content bg-dark text-white" style="width: 80vw; margin: auto; border: 2px solid #f40202;">
        <div class="modal-header d-flex justify-content-between">
          <div class="logo d-flex">
            <h3
              style="color: white; border: 1px solid red; border-radius: 15px; margin-right: 5px; background-color: rgb(81, 0, 0); width: 30px; height: 30px; text-align: center;"
              wire:click='close_main_model'>
              <strong>X</strong>
            </h3>
            <h2 style="border-left: 1px solid rgb(128, 0, 0); padding-left: 3px; height: 33px;">{{ $model }}</h2>
          </div>
          <div class="social-media">

            @if (!$new_model)
              <button class="c-button" wire:click='create_new("{{ $model }}")'>
                <span class="c-main">
                  <span class="c-ico">
                    <span class="c-blur"></span>
                    <strong class="ico-text">+</strong>
                  </span>
                  Create New {{ $model }}
                </span>
              </button>
            @endif
          </div>
        </div>
        <div class="modal-body w-full bg-black p-3"
          style="border-left: 2px solid #f40202; overflow-x: scroll; border-right: 2px solid #f40202; border-bottom: 4px solid  #f40202; height: 65vh; padding-bottom: 10px;">

          @if ($new_model)

            <div class="create_new" style="margin: auto">
              <h4 style="margin-left: 10px;">{{ $model }}</h4>
              <button class="dismiss" type="button" wire:click='dismiss_new'>×</button>
              <div class="header">

                <div class="row">
                  @switch($model)
                    @case('Staff')
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_staff_name">Staff Name</label>
                        </div>
                        <input class="form-control" type="text" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_staff_name' placeholder="Write Staff Name" autofocus autocomplete="name">
                      </div>
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_staff_email">Staff Email</label>
                        </div>
                        <input class="form-control" type="email" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_staff_email' placeholder="Write Staff Email" autocomplete="email">
                      </div>

                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_staff_subject">Staff Subject</label>
                        </div>
                        <select class="form-control" type="email" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_staff_subject' placeholder="Write Staff Subject">
                          <option value="">Select Subject</option>
                          @foreach (Auth::user()->school->subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                          @endforeach
                        </select>
                      </div>

                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='create_new_staff'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          Create New {{ $model }}
                        </span>
                      </button>
                    @break

                    @case('Asign Subject')
                      <h2>{{ $staff->name }}</h2>
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_staff_subject">Staff Subject</label>
                        </div>
                        <select class="form-control"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_staff_subject' placeholder="Write Staff Subject">
                          <option value="">Select Subject</option>
                          @foreach (Auth::user()->school->subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                          @endforeach
                        </select>
                      </div>

                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='asign_subject_to_staff'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          {{ $model }}
                        </span>
                      </button>
                    @break

                    @case('Add Subject')
                      <h2>{{ $exam->title }}</h2>
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_exam_subject">Exam Subject</label>
                        </div>
                        <select class="form-control"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_exam_subject'>
                          <option value="">Select Subject</option>
                          @foreach (Auth::user()->school->subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                          @endforeach
                        </select>
                      </div>

                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='add_subject_to_exam'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          {{ $model }}
                        </span>
                      </button>
                    @break

                    @case('Subjects')
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_subject_name">Subject Name</label>
                        </div>
                        <input class="form-control" type="text" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_subject_name' placeholder="Write Subject Name" autofocus
                          autocomplete="subject">
                      </div>
                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='create_new_subject'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          Create New {{ $model }}
                        </span>
                      </button>
                    @break

                    @case('Exams')
                      @if (count(Auth::user()->school->sets) < 1)
                        <h1 style="color: red;">Ops! you need to create at least one set</h1>
                      @else
                        <div class="container" style="width: 90%; margin: auto; margin-block: 10px;">
                          <div class="col-12">

                            <div class="input-group input-group-lg mb-3">
                              <div class="input-group-text"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                                <label for="new_exam_title">Exam Title</label>
                              </div>
                              <input class="form-control" type="text" value=""
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                                wire:model.live='new_exam_title'
                                placeholder="Write Exam Title e.g (End of Frist Term Examination)" autofocus
                                autocomplete="title">
                            </div>
                          </div>
                          <div class="col-12">

                            <div class="input-group input-group-lg mb-3">
                              <div class="input-group-text"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                                <label for="new_exam_description">Exam Intruction</label>
                              </div>
                              <textarea class="form-control" type="text" value=""
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                                wire:model.live='new_exam_description' placeholder="Write Exam Intruction in full" autocomplete="Intruction"></textarea>
                            </div>
                          </div>
                          <div class="col-12">
                            <label class="neon-checkbox-wrapper">
                              <input type="checkbox" wire:model.live='new_exam_is_mock' />
                              <div class="checkmark">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                  <path d="M20 6L9 17L4 12" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                </svg>
                              </div>
                              <span class="label">Mock Exam</span>
                            </label>

                          </div>
                          <div class="col-12">
                            <label class="neon-checkbox-wrapper">
                              <span class="label">Exam Duration:
                                {!! $duration ? $duration : '<span style="color: red !important;"> Invalide Time</span>' !!}</span>
                            </label>
                          </div>
                          <div class="col-12">

                            <div class="input-group input-group-lg mb-3">
                              <div class="input-group-text"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                                <label for="new_exam_start_time">Start Time</label>
                              </div>
                              <input class="form-control" type="time" value="{{ now() }}"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                                wire:input='calculateDuration' wire:model.live='new_exam_start_time'>
                            </div>
                          </div>
                          <div class="col-12">

                            <div class="input-group input-group-lg mb-3">
                              <div class="input-group-text"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                                <label for="new_exam_end_time">End Time</label>
                              </div>
                              <input class="form-control" type="time" value=""
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                                wire:input='calculateDuration' wire:model.live='new_exam_end_time'>
                            </div>
                          </div>
                          <div class="col-12">

                            <div class="input-group input-group-lg mb-3">
                              <div class="input-group-text"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                                <label for="new_exam_set">Exam Set</label>
                              </div>
                              <select class="form-control"
                                style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                                wire:model.live='new_exam_set'>
                                <option>Select Set</option>
                                @foreach (Auth::user()->school->sets as $set)
                                  <option value="{{ $set->id }}">{{ $set->name }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                        </div>

                        <button class="c-button" style="margin: auto;" wire:click='create_new_exam'>
                          <span class="c-main">
                            <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                            Create New {{ $model }}
                          </span>
                        </button>
                      @endif
                    @break

                    @case('Set')
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_set_name">Set Name</label>
                        </div>
                        <input class="form-control" type="text" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_set_name' placeholder="Write Set Name" autofocus autocomplete="subject">
                      </div>
                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='create_new_set'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          Create New {{ $model }}
                        </span>
                      </button>
                    @break

                    @case('Result')
                      <h1 class="text-center text-white">{{ $set->name }}</h1>
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="result_exam_id">Select Exam</label>
                        </div>
                        <select class="form-control" type="email" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='result_exam_id'>
                          <option value="">Select Exam</option>
                          @foreach ($set->exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                          @endforeach
                        </select>
                      </div>

                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='download_result'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          Download Result
                        </span>
                      </button>
                    @break

                    @case('View Set')
                      @foreach ($set->users as $user)
                        <div class="cardh">
                          <div class="cardi">

                            <div class="row" style="padding: 5px !important; text-align: left !important;">
                              <div class="col-1">{{ $user->id }}</div>
                              <div class="col-6">{{ $user->name }} </div>
                              <div class="col-5 d-flex" style="justify-content: space-between;">
                                <div>{{ $user->id_number }}</div>
                                <div>
                                  <button class="btn btn-sm btn-outline-danger"
                                    wire:click='remove_from_set("{{ $user->id }}")'><i
                                      class="bi bi-trash"></i></button>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      @endforeach
                    @break

                    @case('Add Students')
                      <h1 class="text-center text-white">{{ $set->name }}</h1>
                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="student_id">Students</label>
                        </div>
                        <select class="form-control" type="email" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='student_id'>
                          <option value="">Select Student</option>
                          @foreach (Auth::user()->school->students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                          @endforeach
                        </select>
                      </div>

                      <br>

                      <button class="c-button" style="margin: auto;" wire:click='add_student'>
                        <span class="c-main">
                          <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                          Add Student
                        </span>
                      </button>
                    @break

                    @case('View Questions')
                      <div class="card-body">

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
                                <button class="btn btn-success delete"
                                  wire:click='cormfirm_delete_question'>Delete</button>
                              </div>
                            </div>
                          </div>
                        @endif
                        <div class="cardh">
                          <div class="cardi">
                            <strong>
                              <div class="row h5" style="padding: 5px !important; text-align: left;">
                                <div class="col-5"># Question [{{ count($subject->questions_all) }}]
                                  &nbsp;&nbsp;|&nbsp;&nbsp; Active Questions [{{ count($subject->questions_all_active) }}]
                                </div>
                                <div class="col-1">Type</div>
                                <div class="col-1">Response</div>
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
                        @foreach ($subject->questions_all as $question)
                          <div class="cardh">
                            <div class="cardi">
                              <div class="row" style="padding: 5px !important; text-align: left;">
                                <div class="col-5">
                                  @if ($question->status == 'in-active')
                                    <strong>{{ ++$count }} - </strong><strike><i>{{ $question->text }}</i></strike>
                                  @else
                                    <strong>{{ ++$count }} - </strong>{{ $question->text }}
                                  @endif
                                </div>
                                <div class="col-1">{{ $question->type }}</div>
                                <div class="col-1">{{ $question->max_response }}</div>
                                <div class="col-4">
                                  <div class="row">
                                    @foreach ($question->options as $option)
                                      <div class="col-3 {{ $option->is_correct == 1 ? 'text-primary fw-bolder' : '' }}">

                                        {{ $option->option }}</div>
                                    @endforeach
                                  </div>
                                </div>
                                <div class="col-1">

                                  <button
                                    class="btn btn-sm btn-{{ $question->status == 'active' ? 'success' : 'primary' }} ms-1"
                                    wire:click='toggle_question_status("{{ $question->id }}")'><i
                                      class="bi bi-eye"></i></button>
                                  <button class="btn btn-sm btn-outline-danger"
                                    wire:click='delete_question("{{ $question->id }}")'><i
                                      class="bi bi-trash"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @break

                    @case('New Objective Question' || 'New Essay Question')
                      <h1 class="text-center text-white">{{ $subject->title }}</h1>

                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_question_text">Question text</label>
                        </div>
                        <input class="form-control" type="text" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_question_text' placeholder="Write Question test" autofocus
                          autocomplete="question">
                      </div>

                      @if ($model == 'New Essay Question')
                        <div class="input-group input-group-lg mb-3">
                          <div class="input-group-text"
                            style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                            <label for="max_response">Response Size in Characters</label>
                          </div>
                          <input class="form-control" type="number"
                            style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                            wire:model.live='max_response' placeholder="Write Response Size in Characters eg 80">
                        </div>
                      @endif

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
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="image">Question Image</label>
                        </div>
                        <input class="form-control" type="file"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='image' placeholder="Select Question Image" autocomplete="question">
                      </div>

                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_question_code_snippet">Code Snippet</label>
                        </div>
                        <textarea class="form-control"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_question_code_snippet' placeholder="Write Code snippet if any" autocomplete="question"></textarea>
                      </div>

                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_question_answer_explanation">Answer Explanation</label>
                        </div>
                        <input class="form-control" type="text" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_question_answer_explanation' placeholder="Write Answer Explanation if any"
                          autocomplete="question">
                      </div>

                      <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text"
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; ">
                          <label for="new_question_more_info_link">Usefull Link</label>
                        </div>
                        <input class="form-control" type="text" value=""
                          style="background-color: rgba(0, 0, 0, 0); color: #f40202 !important; border: 2px solid rgb(255, 0, 0);"
                          wire:model.live='new_question_more_info_link' placeholder="Write more info link if any"
                          autocomplete="question">
                      </div>

                      <br>

                      @if ($model == 'New Essay Question')
                        <button class="c-button" style="margin: auto;" wire:click='create_new_question'>
                          <span class="c-main">
                            <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                            Create {{ $model }}
                          </span>
                        </button>
                      @else
                        <button class="c-button" style="margin: auto;" wire:click='create_new_question'>
                          <span class="c-main">
                            <span class="c-ico"><span class="c-blur"></span> <span class="ico-text">+</span></span>
                            Create {{ $model }}
                          </span>
                        </button>
                      @endif
                    @break

                    @default
                  @endswitch
                </div>
              </div>
            </div>
          @elseif ($questions_upload)
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
                <h4 style="margin: auto; text-align: center;">{{ $subject->title }} Questions</h4>
                <button class="dismiss" type="button" wire:click='cancel_upload'><strong>X</strong></button>
                <p><br></p>

                <label class="input-div" for="questions_file" style="margin: auto; text-align: center">
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
                    <h4 class="text-center">
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
          @elseif ($students_upload)
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
                <h4 style="margin: auto; text-align: center;">{{ $set->name }} Students</h4>
                <button class="dismiss" type="button" wire:click='cancel_upload'><strong>X</strong></button>
                <p><br></p>

                <label class="input-div" for="students_file" style="margin: auto; text-align: center">
                  <input class="excell_input" id="students_file" name="students_file" type="file"
                    wire:model.live='students_file' {{ $students_file ? 'hidden' : '' }} />
                  <input name="set_id" type="text" wire:model.live='set_id' hidden>

                  @if (!$students_file)
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
                @if ($students_file)
                  <br>
                  @error('questions_file')
                    <h3 style="color: red; text-align: center;">
                      {{ $students_file->getClientOriginalName() }}
                      <br>
                      {{ $message }}
                    </h3>
                  @else
                    <h4 class="text-center">
                      {{ $students_file->getClientOriginalName() }}</h4>
                  @enderror
                  <div class="d-flex" style="justify-content: center;">
                    <button class="c-button float-center" type="button" style="margin: auto; text-align: center"
                      wire:click='confirm_student_upload'>
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
          @else
            @if ($staffs)
              <div class="cards">

                @if ($cormfirm_delete)
                  <div class="d-flex h-full w-full"
                    style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
                    <div class="warning_card">
                      <span>Are you Sure you want to Delete
                        <br>
                        <strong>{{ $staff->name }}</strong>
                      </span>
                      <div class="d-flex justify-content-between">
                        <button class="btn btn-warning warning" wire:click='cancel_delete'>Cancel</button>
                        <button class="btn btn-success delete" wire:click='cormfirm_delete_staff'>Delete</button>
                      </div>
                    </div>
                  </div>
                @endif
                @foreach ($staffs as $staff)
                  <div class="cardh" style="height: 45px; margin: 5px; ">
                    <div class="cardi">
                      <div class="row" style="padding: 5px !important;">
                        <div class="col-4">{{ $staff->name }}</div>
                        <div class="col-3">{{ $staff->email }}</div>
                        <div class="d-flex col-3 scrollable"
                          style="justify-content: space-between;padding: 5px !important; width: 200px; height: 40px; border-right: 1px solid #ff2600; border-left: 1px solid #ff2600; border-radius: 10px; overflow-y: scroll; overflow: scroll;">
                          <div class="d-flex">
                            @foreach ($staff->subjects as $subject)
                              <button class="sm_span_btn ms-3" style="">
                                <span class="sm_span_text">{{ $subject->title }}</span>
                                <span class="trash"
                                  wire:click='remove_subject("{{ $staff->id }}", "{{ $subject->id }}")'>
                                  <i class="bi bi-trash"></i>
                                </span>
                              </button>
                            @endforeach
                          </div>
                        </div>
                        <div class="col-2">
                          <button class="btn btn-sm btn-outline-success"
                            wire:click='assign_subject("{{ $staff->id }}")'>Asign Subject</button>
                          @if ($staff->id > 1)
                            <button class="btn btn-danger" wire:click='delete_staff("{{ $staff->id }}")'>
                              <i class="bi bi-trash"></i>
                            </button>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @elseif ($subjects)
              <div class="cards" style="justify-content: center !important;">

                @if ($cormfirm_delete)
                  <div class="d-flex h-full w-full"
                    style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
                    <div class="warning_card">
                      <span>Are you Sure you want to Delete
                        <br>
                        <strong>{{ $subject->title }}</strong>
                      </span>
                      <div class="d-flex justify-content-between">
                        <button class="btn btn-warning warning" wire:click='cancel_delete'>Cancel</button>
                        <button class="btn btn-success delete" wire:click='delete'>Delete</button>
                      </div>
                    </div>
                  </div>
                @endif
                @if ($new_question)
                  <div class="d-flex h-full w-full"
                    style="background-color: #000000; z-index: 1000;  justify-content: center;">
                    <div class="warning_card"
                      style="color: #f7f7f7 !important; border: 2px solid #ff2600 !important;">
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
                @foreach ($subjects as $subject)
                  <div class="cardh">
                    <div class="cardi">
                      <div class="d-flex p-1" style="justify-content: space-between;">
                        <div class="d-flex row"
                          style="justify-content: space-between; width: 66%; text-align: left !important;">
                          <div class="col-7">
                            <b>{{ $subject->title }}</b>
                          </div>
                          <div class="col-5">
                            <div class="row">
                              <div class="col-6">Questions: {{ count($subject->questions_all) }}</div>
                              <div class="col-6">Active: {{ count($subject->questions_all_active) }}</div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                          <button class="btn btn-sm container-btn-file"
                            wire:click='upload_questions("{{ $subject->id }}")'>
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
                            {{-- <input class="" name="text" type="file" /> --}}
                          </button>
                          <button class="btn btn-sm btn-outline-info ms-2"
                            wire:click='create_question("{{ $subject->id }}")'><i class="bi bi-plus"></i></button>
                          <button class="btn btn-sm btn-outline-primary ms-2"
                            wire:click='view_questions("{{ $subject->id }}")'><i class="bi bi-eye"></i></button>
                          <button class="btn btn-sm btn-outline-danger ms-2"
                            wire:click='delete_subject("{{ $subject->id }}")'><i class="bi bi-trash"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @elseif ($sets)
              <div class="cards" style="justify-content: center !important;">

                @if ($cormfirm_delete)
                  <div class="d-flex h-full w-full"
                    style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
                    <div class="warning_card">
                      <span>Are you Sure you want to Delete
                        <br>
                        <strong>{{ $set->name }}</strong>
                      </span>
                      <div class="d-flex justify-content-between">
                        <button class="btn btn-warning warning" wire:click='cancel_delete'>Cancel</button>
                        <button class="btn btn-success delete" wire:click='cormfirm_delete_set'>Delete</button>
                      </div>
                    </div>
                  </div>
                @endif
                @foreach ($sets as $set)
                  <div class="cardh">
                    <div class="cardi">
                      <div class="d-flex p-1" style="justify-content: space-between;">
                        <div class="d-flex" style="justify-content: space-between; width: 60%;">
                          <div class="text-left">
                            <b>{{ $set->name }}</b>
                          </div>
                          <div class="text-center">Users: {{ count($set->users) }}</div>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;">
                          <button class="container-btn-file" style="height: 40px; margin: auto; text-align: center;"
                            wire:click='upload_students("{{ $set->id }}")'>
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
                            Upload Students
                          </button>
                          <button class="btn btn-sm btn-outline-info ms-1"
                            wire:click='add_students("{{ $set->id }}")'><strong><i
                                class="bi bi-plus"></i></strong></button>
                          <button class="btn btn-sm btn-outline-primary ms-1"
                            wire:click='view_students("{{ $set->id }}")'>View</button>
                          <button class="btn btn-sm btn-outline-success ms-1"
                            wire:click='init_download_result("{{ $set->id }}")'>Result</button>
                          <button class="btn btn-sm btn-outline-danger ms-2"
                            wire:click='delete_set("{{ $set->id }}")'>Trash</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @elseif ($exams)
              <div class="cards">

                @if ($cormfirm_delete)
                  <div class="d-flex h-full w-full"
                    style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
                    <div class="warning_card">
                      <span>Are you Sure you want to Delete
                        <br>
                        <strong>{{ $exam->title }}</strong>
                      </span>
                      <div class="d-flex justify-content-between">
                        <button class="btn btn-warning warning" wire:click='cancel_delete'>Cancel</button>
                        <button class="btn btn-success delete" wire:click='cormfirm_delete_exam'>Delete</button>
                      </div>
                    </div>
                  </div>
                @endif

                @foreach ($exams as $exam)
                  {{-- working here --}}
                  <div class="cardh">
                    <div class="cardi">
                      <div class="row" style="padding: 5px !important; text-align: left !important;">
                        <div class="col-3">{{ $exam->title }} </div>
                        <div class="col-1">{{ $exam->start_time }} To {{ $exam->finish_time }}</div>
                        <div class="d-flex col-3 scrollable"
                          style="justify-content: space-between;padding: 5px !important; width: 200px; height: 40px; border-right: 1px solid #ff2600; border-left: 1px solid #ff2600; border-radius: 10px; overflow-y: scroll; overflow: scroll;">
                          <div class="d-flex">
                            @foreach ($exam->subjects as $subject)
                              <button class="sm_span_btn ms-3" style="">
                                <span class="sm_span_text">{{ $subject->title }}</span>
                                <span class="trash"
                                  wire:click='remove_subject_from_exam("{{ $exam->id }}", "{{ $subject->id }}")'>
                                  <i class="bi bi-trash"></i>
                                </span>
                              </button>
                            @endforeach
                          </div>
                        </div>
                        <div class="col-5">
                          <div class="row">
                            <div class="col-5">
                              @foreach ($exam->sets as $set)
                                <small>{{ $set->name }}</small>
                              @endforeach
                               
                            </div>
                            <div class="col-7 align-end float-end">
                              <button class="btn btn-sm btn-outline-primary"
                                wire:click='add_subject("{{ $exam->id }}")'>Add Subject</button>
                              <button class="btn btn-sm btn-outline-primary"
                                wire:click='add_five_minute("{{ $exam->id }}")'> +5
                                Min</button>
                              <button class="btn btn-sm btn-{{ $exam->is_visible ? 'info' : 'secondary' }}"
                                wire:click='toggle_exam_visibility("{{ $exam->id }}")'>
                                <i class="bi bi-eye"></i>
                              </button>
                              <button class="btn btn-sm btn-danger" wire:click='delete_exam("{{ $exam->id }}")'>
                                <i class="bi bi-trash"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach

              </div>
            @endif
          @endif
        </div>
      </div>
    </div>
  @endif

  <div class="row mt-4">

    <div class="col-12 bg-secondary p-2">

      <div class="d-flex" style="justify-content: center;">
        <div class="main_center" style="border: 1px solid #ee0d0d;">
          <div class="up">
            <button class="card1" style="color: #ffffff !important;" wire:click='open_main_model("Staffs")'>
              Staffs
            </button>
            <button class="card2" style="color: #ffffff !important;" wire:click='open_main_model("Subjects")'>
              Subjects
            </button>
          </div>
          <div class="down">
            <button class="card3" style="color: #ffffff !important;" wire:click='open_main_model("Exams")'>
              Exams
            </button>
            <button class="card4" style="color: #ffffff !important;" wire:click='open_main_model("Set")'>
              Set
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
