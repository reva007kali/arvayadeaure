@extends('errors.layout')

@section('title', 'Kesalahan Server')
@section('code', '500')
@section('message', 'Terjadi Kesalahan Server')
@section('description', 'Maaf, kami sedang mengalami gangguan teknis. Tim kami sedang bekerja untuk memperbaikinya.')

@section('actions')
    <button onclick="window.location.reload()" class="px-8 py-3 rounded-full border border-[#D4AF37] text-[#D4AF37] font-bold hover:bg-[#D4AF37] hover:text-[#121212] transition flex items-center gap-2">
        <i class="fa-solid fa-rotate-right"></i> Muat Ulang
    </button>
@endsection
