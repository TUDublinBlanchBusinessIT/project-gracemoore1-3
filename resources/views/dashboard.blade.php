@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-6 text-center">Dashboard</h1>

  <div class="flex justify-center">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <x-button>
        {{ __('Log out') }}
      </x-button>
    </form>
  </div>
@endsection






