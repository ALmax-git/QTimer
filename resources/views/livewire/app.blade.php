<div>

  <div class="app-container noselect">
    <div class="canvass">
      <div class="tracker tr-1"></div>
      <div class="tracker tr-2"></div>
      <div class="tracker tr-3"></div>
      <div class="tracker tr-4"></div>
      <div class="tracker tr-5"></div>
      <div class="tracker tr-6"></div>
      <div class="tracker tr-7"></div>
      <div class="tracker tr-8"></div>
      <div class="tracker tr-9"></div>
      <div id="card">
        <div class="card-content">
          <div class="card-glare"></div>
          <div class="cyber-lines">
            <span></span><span></span><span></span><span></span>
          </div>
          <div class="card h-100 w-full" style="background-color: rgba(0, 0, 0, 0) !important;">
            <div class="card-header">
              <div class="row"
                style="text-align: center; color: rgb(216, 213, 251) !important; text-decoration:double;">
                <div class="col-4">
                  <h2>QTimer</h2>
                </div>
                <div class="col-4">
                  @if (Auth::user()->school)
                    <h4>{{ Auth::user()->school->name }}</h4>
                  @else
                    <h4>Setup</h4>
                  @endif
                </div>
                <div class="col-4 h4"><span style="color: rgb(0, 255, 0) !important;">[</span><span
                    style="color: rgb(4, 113, 255) !important;">{{ Auth::user()->name }}</span><span
                    style="color: rgb(0, 255, 0) !important">]{{ '@' . Auth::user()->id_number }}</span></div>
              </div>
            </div>
            <div class="card-body" style="height: 90%; overflow-x: scroll;">
              @if (Auth::user()->school)
                @if (Auth::user()->school->has_license())
                  @switch($tab)
                    @case('profile')
                      <livewire:tab.profile />
                    @break

                    @case('school')
                      <livewire:tab.school />
                    @break

                    @case('exam')
                      <livewire:tab.exams />
                    @break

                    @case('student')
                      <livewire:tab.student />
                    @break

                    @case('subject')
                      <livewire:tab.subject />
                    @break

                    @default
                      <livewire:tab.school />
                  @endswitch
                @else
                  <livewire:setup />
                @endif
              @else
                <livewire:setup />
              @endif
            </div>
            <div class="card-footer">
              @if (Auth::user()->school)
                @if (Auth::user()->school->has_license())
                  <div class="radio-input"
                    style="background-color: rgba(0, 0, 0, 0) !important; border-top: 2px solid green;">
                    @if (Auth::user()->is_staff)
                      <label class="menu-lebel" for="school" wire:click='change_tab("{{ write('school') }}")'>
                        <input id="school" name="menu" type="radio" value="school"
                          {{ $tab == 'school' ? 'checked' : '' }} />
                        <span class="menu-text"><i class="bi bi-house fw-bold"></i> Dashboard</span>
                      </label>
                      <label class="menu-lebel" for="Students" wire:click='change_tab("{{ write('student') }}")'>
                        <input id="Students" name="menu" type="radio" value="Students"
                          {{ $tab == 'student' ? 'checked' : '' }} />
                        <span class="menu-text"><i class="bi bi-people"> </i>Candidates</span>
                      </label>
                    @endif

                    {{-- <label class="menu-lebel" for="Students" wire:click='change_tab("{{ write('student') }}")'>
                      <input id="Students" name="menu" type="radio" value="Students"
                        {{ $tab == 'student' ? 'checked' : '' }} />
                      <span class="menu-text">Question Bank</span>
                    </label> --}}
                    <label class="menu-lebel" for="subject" wire:click='change_tab("{{ write('subject') }}")'>
                      <input id="subject" name="menu" type="radio" value="subject"
                        {{ $tab == 'student' ? 'checked' : '' }} />
                      <span class="menu-text"><strong>?</strong> Questions</span>
                      {{-- <i class="bi bi-question-mark"> --}}
                    </label>
                    <label class="menu-lebel" for="Exams" wire:click='change_tab("{{ write('exam') }}")'>
                      <input id="Exams" name="menu" type="radio" value="value-1"
                        {{ $tab == 'exam' ? 'checked' : '' }} />
                      <span class="menu-text"><i class="bi bi-file-fill"></i>Exams</span>
                    </label>
                    <label class="menu-lebel" for="Profile" wire:click='change_tab("{{ write('profile') }}")'>
                      <input id="Profile" name="menu" type="radio" value="value-1"
                        {{ $tab == 'profile' ? 'checked' : '' }} />
                      <span class="menu-text"><i class="bi bi-person"></i>Profile</span>
                    </label>
                    <label class="menu-lebel" for="Exit" wire:click='closeApp'>
                      <input id="Exit" name="menu" type="radio" value="value-1" wire:click='logout' />
                      <span class="menu-text" style="color: red !important;">Exit</span>
                    </label>
                  </div>
                @endif
              @endif
            </div>
          </div>
          <div class="glowing-elements">
            <div class="glow-1"></div>
            <div class="glow-2"></div>
            <div class="glow-3"></div>
          </div>
          <div class="card-particles">
            <span></span><span></span><span></span> <span></span><span></span><span></span>
          </div>
          <div class="corner-elements">
            <span></span><span></span><span></span><span></span>
          </div>
          {{-- <div class="scan-line"></div> --}}
        </div>
      </div>
    </div>
  </div>

</div>
