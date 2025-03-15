@extends('layouts.app')
@section('content')
  @if (Auth::user())
    @if (Auth::user()->is_staff || Auth::user()->is_set_master || Auth::user()->is_subject_master)
      <livewire:app />
    @else
      <livewire:exams />
    @endif
    {{-- @script --}}
    <script>
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
          alert("Action blocked! You cannot use shortcuts during the test.");
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
      enterFullScreen();

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
          alert("You are not allowed to leave the exam window!");
          location.reload(); // Reload to enforce focus
        }
      });
      // });
    </script>
    {{-- @endscript --}}
  @else
    <livewire:auth.login />
  @endif
@endsection
