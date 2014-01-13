@extends('admin.layouts.default')

@section('content')
	<div class="inner">
		<div class="text-center">
			<a class="quick-btn" href="{{ Config::get('url_analytics') }}" target="_blank">
				<i class="fa fa-dashboard fa-2x"></i>
				<span>U. Analitycs</span>
			</a>
			<a class="quick-btn" href="{{ route('admin_witness') }}">
				<i class="fa fa-envelope fa-2x"></i>
				<span>Témoignages</span>

				@if ($total_witnesses_waiting)
					<span class="label label-success">{{ $total_witnesses_waiting }}</span>
				@endif
			</a>
			<a class="quick-btn" href="{{ route('admin_contact') }}">
				<i class="fa fa-envelope fa-2x"></i>
				<span>Messages</span>

				@if ($total_contact_waiting)
					<span class="label label-success">{{ $total_contact_waiting }}</span>
				@endif
			</a>
		</div>
		<hr/>
		<div class="text-center">
			<a href="{{ Config::get('url_sensiolab_project') }}" target="_blank">
				{{ HTML::image(Config::get('url_sensiolab_insight_medal'), 'Médaille Sensiolab Insight') }}
			</a>
		</div>
		<hr/>
	</div>
@stop