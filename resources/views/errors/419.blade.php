@extends('errors.layout')

@section('title', 'Halaman Kadaluarsa')
@section('code', '419')
@section('message', 'Halaman Kadaluarsa')
@section('description', 'Sesi halaman Anda telah berakhir karena tidak aktif. Silakan muat ulang halaman untuk melanjutkan.')

@section('actions')
    <button onclick="window.location.reload()" class="px-8 py-3 rounded-full border border-[#D4AF37] text-[#D4AF37] font-bold hover:bg-[#D4AF37] hover:text-[#121212] transition flex items-center gap-2">
        <i class="fa-solid fa-rotate-right"></i> Muat Ulang
    </button>
@endsection
