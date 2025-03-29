<div class="container-fluid px-4 pt-4">
  <div class="row">
    <div class="h-100 bg-secondary mt-3 rounded p-4">
      <div class="h2">
        <h4>School Settings</h4>
      </div>
      <label for="school_name">School Name</label>
      <input class="form-control mb-3" type="text" wire:model.live="school_name" autofocus>

      <label for="school_email">School Email</label>
      <input class="form-control mb-3" type="text" wire:model.live="school_email">

      <button class="btn btn-sm btn-primary" wire:loading.attr='disabled' wire:click='update_school_name_and_email'>Save
        <i class="bi bi-gear bi-spin" wire:loading wire:target='update_school_name_and_email'></i>
      </button>
    </div>
  </div>
  <div class="row">
    <div class="h-100 bg-secondary mt-3 rounded p-4">
      <div class="h2">
        <h4>Exams Settings</h4>
        <hr>
        <div class="d-flex"
          style="bckgraound-color: rgba(0, 0, 0, 0); color: #f7f7f7 !important; justify-content: space-between; "
          wire:click='toggle_mock()'>
          <div class="h4">
            Allow Student to write Mock Exams
          </div>
          <label class="switch" for="mock">
            <input id="mock" name="mock" type="checkbox"
              {{ Auth::user()->school->allow_mock ? '' : 'checked' }}>
            <span class="slider" wire:click='toggle_mock()'></span>
          </label>
        </div>
        <hr>
        <div class="d-flex"
          style="bckgraound-color: rgba(0, 0, 0, 0); color: #f7f7f7 !important; justify-content: space-between; "
          wire:click='toggle_mock_result()'>
          <div class="h4">
            Allow Student to view Mock Exams Results
          </div>
          <label class="switch" for="allow_mock_result">
            <input id="allow_mock_result" name="allow_mock_result" type="checkbox"
              {{ Auth::user()->school->allow_mock_result ? 'checked' : '' }}>
            <span class="slider" wire:click='toggle_mock_result()'></span>
          </label>
        </div>
        <hr>
        <div class="d-flex"
          style="bckgraound-color: rgba(0, 0, 0, 0); color: #f7f7f7 !important; justify-content: space-between; "
          wire:click='toggle_live_result()'>
          <div class="h4">
            Allow Student to view Live Exams Results after Submitting
          </div>
          <label class="switch" for="allow_live_result">
            <input id="allow_live_result" name="allow_live_result" type="checkbox"
              {{ Auth::user()->school->allow_live_result ? 'checked' : '' }}>
            <span class="slider" wire:click='toggle_live_result()'></span>
          </label>
        </div>
        <hr>
        <div class="d-flex"
          style="bckgraound-color: rgba(0, 0, 0, 0); color: #f7f7f7 !important; justify-content: space-between; "
          wire:click='toggle_mock_review()'>
          <div class="h4">
            Allow Student to review Mock Exams Question after submiting
          </div>
          <label class="switch" for="allow_mock_review">
            <input id="allow_mock_review" name="allow_mock_review" type="checkbox"
              {{ Auth::user()->school->allow_mock_review ? 'checked' : '' }}>
            <span class="slider" wire:click='toggle_mock_review()'></span>
          </label>
        </div>
        <hr>
      </div>
    </div>
  </div>

</div>
