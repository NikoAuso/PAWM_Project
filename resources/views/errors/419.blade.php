@extends('errors::layout')

@section('title', __('Pagina scaduta'))

@section('code', '419')

@section('message', __($exception->getMessage() ?? 'Pagina scaduta!'))

@section('image', '419.svg')
