@extends('admin.layouts.default')

@section('content')
	<div class="pull-right">
		@if ($administrator->isActive())
			<a href="{{ route('admin_administrator_state', array('id' => $administrator->id, 'state' => User::STATE_INACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Désactiver', array('class' => 'btn btn-default', 'style' => 'margin:10px;')) }}
			</a>
		@else
			<a href="{{ route('admin_administrator_state', array('id' => $administrator->id, 'state' => User::STATE_ACTIVE)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Activer', array('class' => 'btn btn-success', 'style' => 'margin:10px;')) }}
			</a>
		@endif

		<a href="{{ route('admin_administrator_delete', array('id' => $administrator->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-trash"></i> Supprimer', array('class' => 'btn btn-danger delete', 'style' => 'margin:10px;')) }}
		</a>
	</div>

	<div class="inner">
		<div class="row">
			<div class="box col-lg-12">
				<h4>Informations générales</h4>

				@include('admin.administrator.includes.form')
			</div>
		</div>
	</div>
@stop