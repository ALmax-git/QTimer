<div>

  @if ($main_model)
    <div class="d-flex"
      style="justify-content: center;position: absolute !important; color: white !important; height: 99vh; z-index: 100; width: 99%; background-color: #f1000000;">
      <div class="model_card w-75">
        <div class="top-section">
          <div class="model_border"></div>
          <div class="icons">
            <div class="logo d-flex">
              <h3
                style="color: white; border: 1px solid red; border-radius: 15px; margin-right: 5px; background-color: rgb(81, 0, 0); width: 30px; height: 30px; text-align: center;"
                wire:click='close_main_model'>
                <strong>X</strong>
              </h3>
              <h2 style="border-left: 1px solid green; padding-left: 3px; height: 33px;">{{ $model }}</h2>
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
          <div class="h-75 m-3 w-full bg-black p-3"
            style="border-left: 2px solid #02f417; overflow-x: scroll; border-right: 2px solid #02f417;">

            @if ($new_model)
              <style>
                .create_new {
                  overflow: hidden;
                  position: relative;
                  text-align: left;
                  border-radius: 0.5rem;
                  max-width: 96%;
                  border-top: 2px solid #02f417;
                  border-bottom: 2px solid #02f417;
                  border-radius: 10px;
                  box-shadow: 0 10px 5px -5px rgba(9, 255, 0, 0.398), 0 10px 10px -5px rgba(17, 18, 7, 0.735);
                  background-color: #111311;
                }

                .dismiss {
                  position: absolute;
                  right: 10px;
                  top: 10px;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  padding: 0.5rem 1rem;
                  background-color: #fff;
                  color: black;
                  border: 2px solid #D1D5DB;
                  font-size: 1rem;
                  font-weight: 300;
                  width: 30px;
                  height: 30px;
                  border-radius: 7px;
                  transition: .3s ease;
                }

                .dismiss:hover {
                  background-color: #ee0d0d;
                  border: 2px solid #ee0d0d;
                  color: #fff;
                }

                .header {
                  padding: 3.25rem 1rem 1rem 1rem;
                }

                .content {
                  margin-top: 0.75rem;
                  text-align: center;
                }

                .title {
                  color: #00ff55;
                  font-size: 1rem;
                  font-weight: 600;
                  line-height: 1.5rem;
                }

                .actions {
                  margin: 0.75rem 1rem;
                }

                @keyframes animate {
                  from {
                    transform: scale(1);
                  }

                  to {
                    transform: scale(1.09);
                  }
                }
              </style>
              <div class="create_new" style="margin: auto">
                <h4 style="margin-left: 10px;">{{ $model }}</h4>
                <button class="dismiss" type="button" wire:click='dismiss_new'>×</button>
                <div class="header">

                  <div class="content">
                    @switch($model)
                      @case('Staff')
                        <div class="input-group input-group-lg mb-3">
                          <div class="input-group-text"
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="new_staff_name">Staff Name</label>
                          </div>
                          <input class="form-control" type="text" value=""
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
                            wire:model.live='new_staff_name' placeholder="Write Staff Name" autofocus autocomplete="name">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                          <div class="input-group-text"
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="new_staff_email">Staff Email</label>
                          </div>
                          <input class="form-control" type="email" value=""
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
                            wire:model.live='new_staff_email' placeholder="Write Staff Email" autocomplete="email">
                        </div>

                        <div class="input-group input-group-lg mb-3">
                          <div class="input-group-text"
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="new_staff_subject">Staff Subject</label>
                          </div>
                          <select class="form-control" type="email" value=""
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="new_staff_subject">Staff Subject</label>
                          </div>
                          <select class="form-control"
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="new_exam_subject">Exam Subject</label>
                          </div>
                          <select class="form-control"
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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

                      @case('Subjets')
                        <div class="input-group input-group-lg mb-3">
                          <div class="input-group-text"
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="school_name">Subject Name</label>
                          </div>
                          <input class="form-control" type="text" value=""
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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
                                  style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                                  <label for="new_exam_title">Exam Title</label>
                                </div>
                                <input class="form-control" type="text" value=""
                                  style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
                                  wire:model.live='new_exam_title'
                                  placeholder="Write Exam Title e.g (End of Frist Term Examination)" autofocus
                                  autocomplete="title">
                              </div>
                            </div>
                            <div class="col-12">

                              <div class="input-group input-group-lg mb-3">
                                <div class="input-group-text"
                                  style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                                  <label for="new_exam_description">Exam Description</label>
                                </div>
                                <textarea class="form-control" type="text" value=""
                                  style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
                                  wire:model.live='new_exam_description' placeholder="Write Exam Description in full" autocomplete="description"></textarea>
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
                                  style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                                  <label for="new_exam_start_time">Start Time</label>
                                </div>
                                <input class="form-control" type="time" value="{{ now() }}"
                                  style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
                                  wire:input='calculateDuration' wire:model.live='new_exam_start_time'>
                              </div>
                            </div>
                            <div class="col-12">

                              <div class="input-group input-group-lg mb-3">
                                <div class="input-group-text"
                                  style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                                  <label for="new_exam_end_time">End Time</label>
                                </div>
                                <input class="form-control" type="time" value=""
                                  style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
                                  wire:input='calculateDuration' wire:model.live='new_exam_end_time'>
                              </div>
                            </div>
                            <div class="col-12">

                              <div class="input-group input-group-lg mb-3">
                                <div class="input-group-text"
                                  style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                                  <label for="new_exam_set">Exam Set</label>
                                </div>
                                <select class="form-control"
                                  style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="new_set_name">Set Name</label>
                          </div>
                          <input class="form-control" type="text" value=""
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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
                            style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
                            <label for="result_exam_id">Select Exam</label>
                          </div>
                          <select class="form-control" type="email" value=""
                            style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
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
                                <div class="col-5">{{ $user->id_number }} </div>

                              </div>
                            </div>
                          </div>
                        @endforeach
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
                <div class="cards flex flex-wrap">

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
                            style="justify-content: space-between;padding: 5px !important; width: 200px; height: 40px; border-right: 1px solid #00ff55; border-left: 1px solid #00ff55; border-radius: 10px; overflow-y: scroll; overflow: scroll;">
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
                <div class="cards flex flex-wrap" style="justify-content: center !important;">

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
                  @foreach ($subjects as $subject)
                    <div class="cardh">
                      <div class="cardi">
                        <div class="d-flex p-1" style="justify-content: space-between;">
                          <div class="d-flex" style="justify-content: space-between; width: 70%;">
                            <div class="text-left">
                              <h3>{{ $subject->title }}</h3>
                            </div>
                            <div class="text-center">Questions: {{ count($subject->questions) }}</div>
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
                            <button class="btn btn-sm btn-outline-danger ms-2"
                              wire:click='delete_subject("{{ $subject->id }}")'>Trash</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @elseif ($sets)
                <div class="cards flex flex-wrap" style="justify-content: center !important;">

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
                              <h3>{{ $set->name }}</h3>
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
                <div class="cards flex flex-wrap">

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
                        <div class="row" style="padding: 5px !important;">
                          <div class="col-3">{{ $exam->title }} </div>
                          <div class="col-2">{{ $exam->start_time }} To {{ $exam->finish_time }}</div>
                          <div class="d-flex col-3 scrollable"
                            style="justify-content: space-between;padding: 5px !important; width: 200px; height: 40px; border-right: 1px solid #00ff55; border-left: 1px solid #00ff55; border-radius: 10px; overflow-y: scroll; overflow: scroll;">
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
                          <div class="col-4" style="display: flex; justify-content: space-between;">
                            <div></div>
                            <div>
                              <button class="btn btn-sm btn-outline-success"
                                wire:click='add_subject("{{ $exam->id }}")'>Add Subject</button>
                              <button class="btn btn-sm btn-outline-primary"
                                wire:click='add_five_minute("{{ $exam->id }}")'> +5
                                Min</button>
                              <button class="btn btn-sm btn-{{ $exam->is_visible ? 'success' : 'secondary' }}"
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
                  @endforeach

                </div>
              @endif
            @endif
          </div>
        </div>
        <div class="bottom-section">
          {{-- <span class="title">UNIVERSE OF UI</span> --}}
          <div class="row">
            <div class="item">
              {{-- <span class="big-text">2626</span>
              <span class="regular-text">UI elements</span> --}}
            </div>
            <div class="item">
              <span class="big-text">{{ Auth::user()->school->name }}</span>
              <span class="regular-text">{{ Auth::user()->school->type }}</span>
            </div>
            <div class="item">
              {{-- <span class="big-text">38,631</span>
              <span class="regular-text">Contributers</span> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="card"
    style="background-color: rgba(0, 0, 0, 0) !important; color: #ffffff; border-top: 2px solid green;">
    <div class="card-header d-flex" style="justify-content: space-between ;">
      @if ($server_is_up)
        <h3
          style="color:rgb(216, 213, 251); border-bottom: 2px solid rgba(55, 205, 1, 0.89); padding: 5px; border-radius: 5px;">
          <i>Sever is
            running: <a href="#">{{ url('/') }}</a></i>
        </h3>
      @endif
      <div class="empty"></div>
      <div class="live_container" wire:click='toggle_server()'>
        <input id="checkbox" type="checkbox" wire:model.live='server_is_up' {{ $server_is_up ? 'checked' : '' }}>
        <label class="button" for="checkbox">
          <span class="icon">
            <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <path
                  d="M17.35 12.7901C17.1686 12.7907 16.9935 12.7229 16.86 12.6001C15.5322 11.411 13.8124 10.7534 12.03 10.7534C10.2476 10.7534 8.52779 11.411 7.19999 12.6001C7.12649 12.6658 7.04075 12.7164 6.94767 12.749C6.85459 12.7816 6.756 12.7955 6.65755 12.7899C6.55909 12.7843 6.4627 12.7594 6.37389 12.7165C6.28508 12.6736 6.2056 12.6137 6.13999 12.5401C6.0109 12.3892 5.94595 12.1939 5.95904 11.9958C5.97212 11.7977 6.06219 11.6126 6.20999 11.4801C7.80752 10.0423 9.88072 9.2467 12.03 9.2467C14.1793 9.2467 16.2525 10.0423 17.85 11.4801C17.9978 11.6126 18.0879 11.7977 18.1009 11.9958C18.114 12.1939 18.0491 12.3892 17.92 12.5401C17.8469 12.6181 17.7586 12.6806 17.6606 12.7236C17.5627 12.7665 17.457 12.7892 17.35 12.7901Z"
                  fill=""></path>
                <path
                  d="M20 10C19.811 9.99907 19.6292 9.92777 19.49 9.80002C17.4685 7.87306 14.7828 6.79812 11.99 6.79812C9.19719 6.79812 6.51153 7.87306 4.48999 9.80002C4.42116 9.88186 4.33563 9.94804 4.23912 9.99411C4.14262 10.0402 4.03738 10.0651 3.93046 10.0672C3.82354 10.0692 3.71742 10.0484 3.61921 10.0061C3.521 9.96375 3.43298 9.90092 3.36105 9.82179C3.28911 9.74267 3.23493 9.64907 3.20214 9.54729C3.16934 9.4455 3.15869 9.33788 3.17091 9.23164C3.18312 9.1254 3.21791 9.023 3.27294 8.93131C3.32798 8.83962 3.40198 8.76076 3.48999 8.70002C5.78577 6.52533 8.82774 5.31329 11.99 5.31329C15.1522 5.31329 18.1942 6.52533 20.49 8.70002C20.5994 8.80134 20.6761 8.93298 20.7103 9.07811C20.7446 9.22324 20.7348 9.37527 20.6822 9.5148C20.6296 9.65433 20.5366 9.77502 20.4151 9.86145C20.2936 9.94787 20.1491 9.99612 20 10Z"
                  fill=""></path>
                <path
                  d="M9.38 15.64C9.26356 15.64 9.14873 15.6129 9.04459 15.5608C8.94044 15.5088 8.84986 15.4332 8.78 15.34C8.7196 15.2617 8.67551 15.1721 8.65032 15.0765C8.62513 14.9809 8.61936 14.8812 8.63334 14.7834C8.64732 14.6855 8.68078 14.5914 8.73173 14.5067C8.78268 14.4219 8.8501 14.3483 8.93 14.29C9.81277 13.6145 10.8934 13.2485 12.005 13.2485C13.1166 13.2485 14.1972 13.6145 15.08 14.29C15.1588 14.3491 15.2252 14.4232 15.2754 14.5079C15.3255 14.5926 15.3585 14.6865 15.3725 14.784C15.3864 14.8815 15.381 14.9807 15.3565 15.0762C15.3321 15.1716 15.2891 15.2612 15.23 15.34C15.1091 15.497 14.9316 15.6005 14.7355 15.6285C14.5394 15.6565 14.34 15.6068 14.18 15.49C13.5548 15.014 12.7908 14.7561 12.005 14.7561C11.2192 14.7561 10.4551 15.014 9.83 15.49C9.69921 15.5855 9.54193 15.6379 9.38 15.64Z"
                  fill=""></path>
                <path
                  d="M12 18.75C11.8011 18.75 11.6103 18.671 11.4697 18.5303C11.329 18.3897 11.25 18.1989 11.25 18C11.25 17.8011 11.329 17.6103 11.4697 17.4697C11.6103 17.329 11.8011 17.25 12 17.25C12.1989 17.25 12.3897 17.329 12.5303 17.4697C12.671 17.6103 12.75 17.8011 12.75 18C12.75 18.1989 12.671 18.3897 12.5303 18.5303C12.3897 18.671 12.1989 18.75 12 18.75Z"
                  fill=""></path>
              </g>
            </svg>
          </span>
        </label>
      </div>
    </div>
    <div class="card-body">
      <div class="input-group input-group-lg mb-3">
        <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
          <label for="school_name">School Name:</label>
        </div>
        <input class="form-control" type="text" value="{{ Auth::user()->school->name }}"
          style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(0, 0, 0);">
      </div>
      <div class="input-group input-group-lg mb-3">
        <div class="input-group-text" style="background-color: rgba(0, 0, 0, 0); color: #24da00df !important; ">
          <label for="school_name">School Email:</label>
        </div>
        <input class="form-control" type="text" value="{{ Auth::user()->school->email }}"
          style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(0, 0, 0);">
      </div>
      <div class="d-flex" style="justify-content: space-between;">
        <div class="d-flex w-25"
          style="bckgraound-color: rgba(0, 0, 0, 0); color: #f7f7f7 !important; justify-content: space-between; border-bottom: 1px solid rgb(0, 0, 0);"
          wire:click='toggle_mock()'>
          <div class="h2">
            Mock Exams
          </div>
          <label class="switch" for="mock">
            <input id="mock" name="mock" type="checkbox"
              {{ Auth::user()->school->allow_mock ? '' : 'checked' }}>
            <span class="slider" wire:click='toggle_mock()'></span>
          </label>
        </div>
        <div class="d-flex w-25"
          style="bckgraound-color: rgba(0, 0, 0, 0); color: #f7f7f7 !important; justify-content: space-between; border-bottom: 1px solid rgb(0, 0, 0);">
          <div class="h2">
            Status: Active
          </div>
          <button class="btn btn-sm btn-outline-success m-2">Check License</button>
        </div>
      </div>
      <div class="d-flex" style="justify-content: center;">
        <div class="main_center">
          <div class="up">
            <button class="card1" style="color: #ffffff !important;" wire:click='open_main_model("Staffs")'>
              Staffs
            </button>
            <button class="card2" style="color: #ffffff !important;" wire:click='open_main_model("Subjets")'>
              Subjets
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
