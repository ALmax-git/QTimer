<div class="h-75 m-3 w-full bg-black"
  style="border-left: 2px solid #f40202; overflow-x: scroll; height: 65vh !important; border-right: 2px solid #f40202;">
  <div class="cards bg-black">
    <div class="bg-black">
      <div class="bg-black">
        <h1 style="width: fit-content; border-bottom: 1px solid #f40202;">My Staff and Students</h1>
      </div>
      <div class="bg-black">

        @if ($cormfirm_delete)
          <div class="d-flex h-full w-full" style="background-color: #000000a1; z-index: 1000;  justify-content: center;">
            <div class="warning_card">
              <span>Are you Sure you want to All Session of
                <br>
                <strong>{{ $session->first()->user->name }}</strong>
              </span>
              <div class="d-flex justify-content-between">
                <button class="btn btn-warning warning" wire:click='cancel_delete'>Cancel</button>
                <button class="btn btn-success delete"
                  wire:click='delete_cormfirmed("{{ $session->first()->user->id }}")'>Delete</button>
              </div>
            </div>
          </div>
        @endif
        <div class="cardh">
          <div class="cardi">
            <div class="row" style="padding: 5px !important; text-align: left;">
              <div class="col-4">Name</div>
              <div class="col-3">Email</div>
              <div class="col-1">Device</div>
              <div class="col-1">Last Seen</div>
              <div class="col-1">Role</div>
              <div class="col-1">Action</div>
            </div>
          </div>
        </div>
        @php
          $count = 0;
        @endphp
        @foreach ($sessions as $session)
          @if ($session->user)
            <div class="cardh">
              <div class="cardi">
                <div class="row" style="padding: 5px !important; text-align: left;">
                  <div class="col-1">{{ ++$count }}</div>
                  <div class="col-3">{{ $session->user->name }}</div>
                  <div class="col-3">{{ $session->user->email }}</div>
                  <div class="col-1">{{ $session->ip_address }}</div>
                  <div class="col-1">{{ \Carbon\Carbon::parse($session->last_activity)->format('H:i') }}</div>
                  <div class="col-1">
                    {{ $session->user->is_set_master || $session->user->is_staff || $session->user->is_subject_master ? ($session->user->is_staff ? 'Admin' : 'Staff') : 'Student' }}
                  </div>
                  <div class="col-2">

                    <button class="btn btn-danger" wire:click='delete_session("{{ $session->user->id }}")'>
                      Terminate
                    </button>

                  </div>
                </div>
              </div>
            </div>
          @else
            <div class="cardh">
              <div class="cardi">
                <div class="row" style="padding: 5px !important; text-align: left;">
                  <div class="col-1">{{ ++$count }}</div>
                  <div class="col-3">{{ '' }}</div>
                  <div class="col-3">{{ '' }}</div>
                  <div class="col-1">{{ $session->ip_address }}</div>
                  <div class="col-1">{{ \Carbon\Carbon::parse($session->last_activity)->format('H:i') }}</div>
                  <div class="col-1">

                  </div>
                  <div class="col-2">

                    <button class="btn btn-danger">
                      Terminate
                    </button>

                  </div>
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
