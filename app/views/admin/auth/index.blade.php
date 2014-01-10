@extends('admin.layouts.auth')

@section('tab-content')
	@include('admin.auth.includes.connexionForm', array('is_active' => true))
	@include('admin.auth.includes.lostPasswordForm')
@stop