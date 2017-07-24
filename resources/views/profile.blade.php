@extends('layouts.main')
@if(Auth::user()->role_id == 1)
    @include('partials.admin-profile')
@endif