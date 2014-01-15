@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<h4>Jeu principal</h4>

					<div class="text-center">
						{{ HTML::image($game_main->image->url, $game_main->title, array('width' => '100px')) }}
						<h3>{{ $game_main->displayTitle() }}</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<div class="icons">
							<i class="fa fa-table"></i>
						</div>
						<h5>Tous les jeux</h5>
					</header>

					<div class="body">
						@include('admin.game.includes.list')
					</div>
				</div>
			</div>
		</div>
	</div>
@stop