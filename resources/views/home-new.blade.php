@extends('layouts.app')

@section('title', 'Beranda - Peminjaman Alat TI')

@section('content')
@auth
    @if(auth()->user()->role === 'wali_kelas')
        @include('wali_kelas.dashboard-section')
    @else
        @include('landing')
    @endif
@else
    @include('landing')
@endauth
@endsection
