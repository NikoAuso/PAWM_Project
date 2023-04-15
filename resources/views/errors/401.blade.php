@extends('errors::layout')

@section('title', __('Non autorizzato'))

@section('code', '401')

@section('message', __($exception->getMessage() ?? 'Non sei autorizzato!'))

@section('image', '401.svg')
