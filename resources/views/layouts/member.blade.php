@extends('layouts.base')
@section('container-width', 'max-w-7xl')
@section('content')
    @yield('member-content')
@endsection
@push('styles')
    <link href="{{ asset('vendor/polipeople/polipeople.css') }}" rel="stylesheet">
@endpush
