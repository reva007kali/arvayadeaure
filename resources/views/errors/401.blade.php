@extends('errors.layout')

@section('title', 'Tidak Terautorisasi')
@section('code', '401')
@section('message', 'Autentikasi Diperlukan')
@section('description', 'Sesi Anda telah berakhir atau Anda belum login. Silakan login kembali untuk melanjutkan.')

@section('actions')
    <a href="{{ route('login') }}" class="px-8 py-3 rounded-full border border-[#D4AF37] text-[#D4AF37] font-bold hover:bg-[#D4AF37] hover:text-[#121212] transition flex items-center gap-2">
        <i class="fa-solid fa-right-to-bracket"></i> Login
    </a>
@endsection
