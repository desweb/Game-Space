@extends('admin.layouts.default')

@section('content')
	<div class="pull-right">
		@if ($achievement->isActive())
			<a href="{{ route('admin_achievement_state', array('id' => $achievement->id, 'state' => Achievement::STATE_INACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Désactiver', array('class' => 'btn btn-default', 'style' => 'margin:10px;')) }}
			</a>
		@else
			<a href="{{ route('admin_achievement_state', array('id' => $achievement->id, 'state' => Achievement::STATE_ACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Activer', array('class' => 'btn btn-success', 'style' => 'margin:10px;')) }}
			</a>
		@endif

		<a href="{{ route('admin_achievement_delete', array('id' => $achievement->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-trash"></i> Supprimer', array('class' => 'btn btn-danger delete', 'style' => 'margin:10px;')) }}
		</a>
	</div>

	<div class="inner">
		<div class="row">
			<div class="box col-lg-6">
				<h4>Informations générales</h4>

				@include('admin.achievement.includes.form')
			</div>
			<div class="box col-lg-6">
				<h4>Image</h4>

				@include('admin.achievement.includes.imageForm')
			</div>
		</div>
	</div>
@stop