@extends('layouts.master')
@section('title', 'Tambah In House Training')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Tambah IHT</h4>
    </div>
    <div class="card-body">
    <form action="{{ route('admin.iht.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.iht._form', ['submit' => 'Simpan'])
    </form>
    </div>
</div> @endsection
