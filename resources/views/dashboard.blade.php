@extends('layouts.app')
@section('content')
  @if (Auth::user())
    @if (Auth::user()->is_staff || Auth::user()->is_set_master || Auth::user()->is_subject_master)
      <livewire:dashboard />
    @else
      <livewire:exams />
    @endif
  @else
    <livewire:auth.login />
  @endif
@endsection
