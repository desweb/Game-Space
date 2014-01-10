@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="row">
			<div class="box col-lg-6">
				<h4>Informations générales</h4>

				@include('admin.profile.includes.form')
			</div>
			<div class="box col-lg-6">
				<h4>Avatar</h4>

				@include('admin.profile.includes.photoForm')
			</div>
		</div>
		<div class="row">
			<div class="box col-lg-6">
				<h4>Mot de passe</h4>

				@include('admin.profile.includes.passwordForm')
			</div>
		</div>
	</div>
@stop