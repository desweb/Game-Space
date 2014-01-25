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

	<div class="inner">
		<div class="row">
			<div class="col-lg-6" style="position:relative;">
				<div class="box">
					<header>
						<h5>Liste des jeux</h5>
					</header>
					<div id="stripedTable" class="body collapse in">
						@include('admin.user.includes.games')
					</div>
				</div>
			</div>
			<div class="col-lg-6" style="position:relative;">
				<div class="box">
					<header>
						<h5>Liste des trophées</h5>
					</header>
					<div id="stripedTable" class="body collapse in">
						@include('admin.user.includes.achievements')
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12" style="position:relative;">
				<div class="box">
					<header>
						<h5>Liste des témoignages</h5>
					</header>
					<div id="stripedTable" class="body collapse in">
						@include('admin.user.includes.witnesses')
					</div>
				</div>
			</div>
		</div>
	</div>
@stop