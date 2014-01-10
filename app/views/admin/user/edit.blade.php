@extends('admin.layouts.default')

@section('content')
	<div class="pull-right">
		@if ($user->isActive())
			<a href="{{ route('admin_user_state', array('id' => $user->id, 'state' => User::STATE_INACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Désactiver', array('class' => 'btn btn-default', 'style' => 'margin:10px;')) }}
			</a>
		@else
			<a href="{{ route('admin_user_state', array('id' => $user->id, 'state' => User::STATE_ACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Activer', array('class' => 'btn btn-success', 'style' => 'margin:10px;')) }}
			</a>
		@endif

		<a href="{{ route('admin_user_password', array('id' => $user->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Réinitialiser le mot de passe', array('class' => 'btn btn-success', 'style' => 'margin:10px;')) }}
		</a>

		@if (!$user->isBan())
			<a href="{{ route('admin_user_ban', array('id' => $user->id)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-warning-sign"></i> Bannir', array('class' => 'btn btn-danger', 'style' => 'margin:10px;')) }}
			</a>
		@endif

		<a href="{{ route('admin_user_delete', array('id' => $user->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-trash"></i> Supprimer', array('class' => 'btn btn-danger delete', 'style' => 'margin:10px;')) }}
		</a>
	</div>

	<div class="inner">
		<div class="row">
			<div class="box col-lg-12">
				<h4>Informations générales</h4>

				@include('admin.user.includes.form')
			</div>
		</div>
	</div>
@stop