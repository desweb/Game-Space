@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="row">
			<div class="box col-lg-12">
				<h4>Informations générales</h4>

				@include('admin.achievement.includes.form')
			</div>
		</div>
	</div>
@stop