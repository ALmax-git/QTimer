<div class="container-fluid pt-4" style="min-height: 80vh;">
  <div class="h-100 bg-secondary rounded p-4">
    <h2 class="mb-4 text-xl font-bold">Students Transcript</h2>
    <!-- Modal -->
    @if ($student)
      <div class="modal-dialog modal-xl modal-dialog-scrollable" id="transcriptModal" tabindex="-1"
        style="position: absolute; background-color: #d1d5db00 !important;">
        <div class="modal-content bg-dark text-white" style="border: 2px solid #f40202;">
          <div class="modal-header">
            <h2 class="mb-4 text-center text-xl font-bold">Student Transcript</h2>
            <button class="btn btn-circle btn-sm btn-outline-danger" data-bs-dismiss="modal" type="button"
              aria-label="Close" wire:click="dismiss">X</button>
          </div>
          <div class="modal-body">

            <!-- Student Details -->
            <p><strong>School:</strong> {{ $school_name }}</p>
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>ID:</strong> {{ $student->id_number }}</p>
            <p><strong>Total Exams Taken:</strong> {{ $examCount }}</p>
            <p><strong>Total Subjects Covered:</strong> {{ $subjectCount }}</p>

            <!-- Exam Breakdown -->
            <table class="table-striped table-hover table-sm table">
              <thead>
                <tr class="bg-gray-200">
                  <th class="border p-2">Exam</th>
                  <th class="border p-2">Total Questions</th>
                  <th class="border p-2">Total Score</th>
                  <th class="border p-2">Average (%)</th>
                  <th class="border p-2">Grade</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($examDetails as $exam)
                  <tr>
                    <td class="border p-2">{{ $exam['title'] }}</td>
                    <td class="border p-2">{{ $exam['total_questions'] }}</td>
                    <td class="border p-2">{{ $exam['total_score'] }}</td>
                    <td class="border p-2">{{ $exam['average_score'] }}</td>
                    <td class="border p-2">{{ $exam['remark'] }}</td>
                  </tr>
                  <!-- Subject Breakdown -->
                  <tr>
                    <td colspan="5">
                      <table class="table-striped table-hover table-sm table">
                        <thead>
                          <tr class="bg-gray-100">
                            <th class="border p-2">Subject</th>
                            <th class="border p-2">Total Questions</th>
                            <th class="border p-2">Total Attempts</th>
                            <th class="border p-2">Total Score</th>
                            <th class="border p-2">Average (%)</th>
                            <th class="border p-2">Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($exam['subjects'] as $subject)
                            <tr>
                              <td class="border p-2">{{ $subject['title'] }}</td>
                              <td class="border p-2">{{ $subject['total_questions'] }}</td>
                              <td class="border p-2">{{ $subject['total_attempts'] }}</td>
                              <td class="border p-2">{{ $subject['total_score'] }}</td>
                              <td class="border p-2">{{ $subject['average_score'] }}</td>
                              <td class="border p-2">{{ $subject['remark'] }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button" wire:click='dismiss'>Close</button>
          </div>
        </div>
      </div>
      {{-- @else --}}
    @endif
    {{-- All Student Table with the View LoadTranscript Button --}}
    <div class="overflow-x-auto">

      <input class="form-control mb-3" type="text" wire:model.live="search"
        placeholder="Search students... eg. Basma">
      <table class="table-striped table-hover table-sm table">
        <thead>
          <tr class="bg-gray-100">
            <th class="border p-2">Name</th>
            <th class="border p-2">ID Number</th>
            <th class="border p-2">View Transcript</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($students as $student)
            <tr>
              <td class="border p-2">{{ $student->name }}</td>
              <td class="border p-2">{{ $student->id_number }}</td>
              <td class="border p-2">
                <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                  data-bs-target="#transcriptModal" href="#" {{ $student_id ? 'disabled' : '' }}
                  wire:click="loadTranscript({{ $student->id }})">View Transcript</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $students->links() }}
  </div>

  <script>
    function printTranscript() {
      window.print();
    }
  </script>

</div>
