@extends('layouts.app')

@section('title', 'Employee Dashboard')

@section('content')
    @auth('employee')
        <div class="container">
            <h1>Welcome, {{ auth('employee')->user()->name }}</h1>
        </div>
    @else
        {{-- Agar employee login nahi hai to redirect ya kuch aur dikha do --}}
        <script>window.location.href = "{{ route('login') }}";</script>
    @endauth
@endsection
