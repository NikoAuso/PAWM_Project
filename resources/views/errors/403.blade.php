@extends('errors::layout')

@section('title', __('Proibito'))

@section('code', '403')

@section('message', __($exception->getMessage() ?: 'Proibito'))

@section('image', '403.svg')

