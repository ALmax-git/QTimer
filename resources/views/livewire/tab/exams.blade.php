<div class="h-75 m-3 w-full bg-black p-3"
  style="border-left: 2px solid #02f417; overflow-x: scroll; border-right: 2px solid #02f417;">
  <div class="cards flex flex-wrap">

    @if ($cormfirm_delete)
      <div class="d-flex h-full w-full" style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
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
            <div class="col-4">{{ $exam->title }}</div>
            <div class="col-3">{{ $exam->title }}</div>
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
            <div class="col-2">

              <button class="btn btn-danger" wire:click='delete_exam("{{ $exam->id }}")'>
                <i class="bi bi-trash"></i>
              </button>

            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
