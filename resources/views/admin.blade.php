@extends('layouts.app')

@section('title', 'Admin')

@section('content')
    <admin :name="'{{ auth()->user()->name }}'" :role="'{{ auth()->user()->role_id }}'"></admin>
@endsection
