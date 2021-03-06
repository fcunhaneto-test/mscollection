@extends('layouts.app')

@section('title', $subtitle)

@section('navbar')
    @component('components.navbar', ['media' => $media ?? ''])@endcomponent
@endsection

@section('content')
    <index :header="'{{ $subtitle }}'" :table="'{{ $table }}'"></index>
@endsection
