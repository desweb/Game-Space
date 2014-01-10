@extends('admin.layouts.default')

@section('content')
	<div class="pull-right">
		<a href="{{ route('admin_contact_delete', array('id' => $contact->id)) }}">
			{{ Form::button('<i class="glyphicon glyphicon-trash"></i> Supprimer', array('class' => 'btn btn-danger delete', 'style' => 'margin:10px;')) }}
		</a>
	</div>

	<div class="inner">
		<div class="row">
			<div class="box col-lg-12">
				@include('admin.contact.includes.form')
			</div>
		</div>
	</div>
@stop