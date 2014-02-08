@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>
							Recherche des utilisateurs :
							<span class="text-{{ $users->count()? 'success': 'danger'}}">
								{{ $users->count()? $users->count() . ' utilisateur' . Tools::plurial($users->count()) . ' trouvé' . Tools::plurial($users->count()): 'Aucun utilisateur trouvé' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#users-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="users-table" class="body collapse">
						@include('admin.user.includes.research')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>
							Recherche des administrateurs :
							<span class="text-{{ $administrators->count()? 'success': 'danger'}}">
								{{ $administrators->count()? $administrators->count() . ' administrateur' . Tools::plurial($administrators->count()) . ' trouvé' . Tools::plurial($administrators->count()): 'Aucun administrateur trouvé' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#administrators-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="administrators-table" class="body collapse">
						@include('admin.administrator.includes.research')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>
							Recherche des cartes :
							<span class="text-{{ $maps->count()? 'success': 'danger'}}">
								{{ $maps->count()? $maps->count() . ' carte' . Tools::plurial($maps->count()) . ' trouvée' . Tools::plurial($maps->count()): 'Aucun carte trouvée' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#maps-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="maps-table" class="body collapse">
						@include('admin.map.includes.research')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>
							Recherche des jeux :
							<span class="text-{{ $games->count()? 'success': 'danger'}}">
								{{ $games->count()? $games->count() . ' jeu' . Tools::plurial($games->count(), true) . ' trouvé' . Tools::plurial($games->count()): 'Aucun jeu trouvé' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#games-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="games-table" class="body collapse">
						@include('admin.game.includes.research')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>Recherche des trophées :
							<span class="text-{{ $achievements->count()? 'success': 'danger'}}">
								{{ $achievements->count()? $achievements->count() . ' trophée' . Tools::plurial($achievements->count()) . ' trouvé' . Tools::plurial($achievements->count()): 'Aucun trophée trouvé' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#achievements-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="achievements-table" class="body collapse">
						@include('admin.achievement.includes.research')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>
							Recherche des témoignages :
							<span class="text-{{ $witnesses->count()? 'success': 'danger'}}">
								{{ $witnesses->count()? $witnesses->count() . ' témoignage' . Tools::plurial($witnesses->count()) . ' trouvé' . Tools::plurial($witnesses->count()): 'Aucun témoignage trouvé' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#witnesses-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="witnesses-table" class="body collapse">
						@include('admin.witness.includes.research')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<header>
						<h5>
							Recherche des messages :
							<span class="text-{{ $contacts->count()? 'success': 'danger'}}">
								{{ $contacts->count()? $contacts->count() . ' message' . Tools::plurial($contacts->count()) . ' trouvé' . Tools::plurial($contacts->count()): 'Aucun message trouvé' }}
							</span>
						</h5>
						<div class="toolbar">
							<div class="btn-group">
								<a href="#contacts-table" data-toggle="collapse" class="btn btn-sm btn-default minimize-box">
									<i class="fa fa-angle-up"></i>
								</a>
								<a class="btn btn-danger btn-sm close-box">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</header>
					<div id="contacts-table" class="body collapse">
						@include('admin.contact.includes.research')
					</div>
				</div>
			</div>
		</div>
	</div>
@stop