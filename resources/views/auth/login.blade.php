@extends('adminlte::auth.login')

@if (session('message'))
    <div class="alert">{{ session('message') }}</div>
@endif