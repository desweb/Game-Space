@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="row">
			<div class="box col-lg-6">
				<h4>Informations générales</h4>

				@include('admin.administrator.includes.form')
			</div>
		</div>
	</div>
@stop