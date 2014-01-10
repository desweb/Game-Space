@extends('admin.layouts.auth')

@section('tab-content')
	@include('admin.auth.includes.recoverPasswordForm', array('is_active' => true))
@stop