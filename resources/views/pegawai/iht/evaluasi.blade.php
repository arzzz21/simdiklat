@extends('layouts.master')
@section('title', 'Evaluasi In House Training')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Evaluasi IHT {{ $participant->iht->judul }}</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('pegawai.iht.evaluasi.submit', $participant->id) }}"> @csrf 
            <div class="form-group"> 
                <label for="evaluasi">Evaluasi In House Training:</label>
                <textarea name="evaluasi" id="evaluasi" rows="6" class="form-control">{{ old('evaluasi', $participant->evaluasi) }}</textarea>
            </div> 
            <button type="submit" class="btn btn-success mt-2">Kirim Evaluasi</button>
        </form>
    </div>
</div>
@endsection
