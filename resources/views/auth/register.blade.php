@extends('adminlte::auth.register')


@if (session('message'))
    <div class="alert">{{ session('message') }}</div>
@endif