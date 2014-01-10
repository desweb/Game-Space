@extends('admin.layouts.default')

@section('content')
	<div class="pull-right">
		@if ($witness->isWaiting())
			<a href="{{ route('admin_witness_state', array('id' => $witness->id, 'state' => GameWitness::STATE_VALIDATED)) }}">
				{{ Form::button('<i class="glyphicon glyphicon-ok"></i> Valider', array('class' => 'btn btn-success', 'style' => 'margin:10px;')) }}
			</a>
		@endif

		<a href="{{ route('admin_witness_delete', array('id' => $witness->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-trash"></i> Supprimer', array('class' => 'btn btn-danger delete', 'style' => 'margin:10px;')) }}
		</a>
	</div>

	<div class="inner">
		<div class="row">
			<div class="box col-lg-12">
				@include('admin.witness.includes.form')
			</div>
		</div>
	</div>
@stop