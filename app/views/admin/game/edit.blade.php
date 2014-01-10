@extends('admin.layouts.default')

@section('content')
	<div class="pull-right">
		@if ($game->isActive())
			<a href="{{ route('admin_game_state', array('id' => $game->id, 'state' => Game::STATE_INACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Désactiver', array('class' => 'btn btn-default', 'style' => 'margin:10px;')) }}
			</a>
		@else
			<a href="{{ route('admin_game_state', array('id' => $game->id, 'state' => Game::STATE_ACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Activer', array('class' => 'btn btn-success', 'style' => 'margin:10px;')) }}
			</a>
		@endif

		<a href="{{ route('admin_game_delete', array('id' => $game->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-trash"></i> Supprimer', array('class' => 'btn btn-danger delete', 'style' => 'margin:10px;')) }}
		</a>
	</div>

	<div class="inner">
		<div class="row">
			<div class="box col-lg-6">
				<h4>Informations générales</h4>

				@include('admin.game.includes.form')
			</div>
			<div class="box col-lg-6">
				<h4>Image</h4>

				@include('admin.game.includes.imageForm')
			</div>
		</div>
	</div>
@stop