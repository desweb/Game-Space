@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<div class="icons">
							<i class="fa fa-table"></i>
						</div>
						<h5>Toutes les cartes</h5>
					</header>

					<div class="body">
						@include('admin.map.includes.list')
					</div>
				</div>
			</div>
		</div>
	</div>
@stop