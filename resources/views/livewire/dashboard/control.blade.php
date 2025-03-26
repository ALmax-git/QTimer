<div class="container-fluid px-4 pt-4">
  <style>
    .form-control {
      border: 1px solid #ff0000;
    }
  </style>
  <div class="row g-4">
    <div class="col-sm-6 col-xl-3">
      <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
        <i class="fa fa-users fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Total Students</p>
          <h6 class="mb-0">{{ count($school->students) }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
        <i class="fa fa-chalkboard-teacher fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Total Sets</p>
          <h6 class="mb-0">{{ count($school->sets) }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
        <i class="fa fa-file-alt fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Total Exams</p>
          <h6 class="mb-0">{{ count(\App\Models\Exam::get()) }}</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="d-flex align-items-center justify-content-between rounded">
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
    </div>
  </div>
  <div class="row">
    <div class="h-100 bg-secondary mt-3 rounded p-4">
      <div class="h2">
        <h4>Recent Students</h4>
      </div>

      <input class="form-control mb-3" type="text" wire:model.live="search" placeholder="Search students...">

      @if (session()->has('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
      @endif

      <div class="table-responsive">
        <table class="table-striped table">
          <thead>
            <tr>
              <th>Name</th>
              <th>ID Number</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($recent_students as $student)
              <tr>
                <td>{{ $student->name }} {{ $student->last_name }}</td>
                <td>{{ $student->id_number }}</td>
                <td>{{ $student->email }}</td>
                <td>
                  <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewModal"
                    wire:click="viewStudent({{ $student->id }})">
                    <i class="bi bi-eye"></i>
                  </button>
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"
                    wire:click="editStudent({{ $student->id }})">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <button class="btn btn-sm btn-danger" wire:click="deleteStudent({{ $student->id }})">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{ $recent_students->links() }}
      {{-- <div wire:loading>
        <div
          class="position-fixed w-100 h-100 bg-dark d-flex justify-content-center align-items-center start-0 top-0 bg-opacity-50">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div> --}}
      <!-- View Modal -->
      @if ($showViewModal)
        <div class="modal-dialog"
          style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50%;">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
              <h5 class="modal-title">Student Details</h5>
              <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p><strong>Name:</strong> {{ $studentData['name'] ?? '' }} {{ $studentData['last_name'] ?? '' }}</p>
              <p><strong>ID:</strong> {{ $studentData['id_number'] ?? '' }}</p>
              <p><strong>Email:</strong> {{ $studentData['email'] ?? '' }}</p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"
                wire:click='dismiss'>Close</button>
            </div>
          </div>
        </div>
      @endif

      <!-- Edit Modal -->
      @if ($showEditModal)
        <div class="modal-dialog"
          style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50%;">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
              <h5 class="modal-title">Edit Student</h5>
              <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input class="form-control" type="text" wire:model="studentData.name" placeholder="First Name"
                autofocus>
              <input class="form-control mt-2" type="text" wire:model="studentData.id_number"
                placeholder="ID Number">
              <input class="form-control mt-2" type="email" wire:model="studentData.email" placeholder="Email">
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"
                wire:click='dismiss'>Close</button>
              <button class="btn btn-primary" wire:click="updateStudent">Update</button>
            </div>
          </div>
        </div>
      @endif
    </div>

    @push('scripts')
      <script>
        window.addEventListener('show-view-modal', event => {
          var myModal = new bootstrap.Modal(document.getElementById('viewModal'));
          myModal.show();
        });

        window.addEventListener('show-edit-modal', event => {
          var myModal = new bootstrap.Modal(document.getElementById('editModal'));
          myModal.show();
        });

        window.addEventListener('hide-edit-modal', event => {
          var myModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
          myModal.hide();
        });
      </script>
    @endpush

  </div>
  <!-- Flash Messages -->
  @if (session()->has('message'))
    <div class="alert alert-success mt-3">{{ session('message') }}</div>
  @endif
</div>
