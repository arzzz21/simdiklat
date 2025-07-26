@extends('layouts.master')
@section('title', 'Edit In House Training')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Edit IHT</h4>
    </div>
    <div class="card-body">
    <form action="{{ route('admin.iht.update', $iht->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.iht._form', ['submit' => 'Perbarui'])
    </form>
    </div>
</div> @endsection
