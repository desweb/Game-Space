<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">

		<title>Administration</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="msapplication-TileColor" content="#5bc0de">
		<meta name="msapplication-TileImage" content="admin/assets/img/metis-tile.png">

		{{ HTML::style('admin/assets/lib/bootstrap/css/bootstrap.min.css') }}
		{{ HTML::style('admin/assets/lib/Font-Awesome/css/font-awesome.min.css') }}
		{{ HTML::style('admin/assets/lib/datatables/css/DT_bootstrap.css') }}
		{{ HTML::style('admin/assets/lib/datatables/css/demo_page.css') }}
		{{ HTML::style('admin/assets/css/main.css') }}
		{{ HTML::style('admin/assets/css/theme.css') }}
		{{ HTML::style('admin/css/main.css') }}

		<!--[if lt IE 9]>
			{{ HTML::script('admin/assets/lib/html5shiv/html5shiv.js') }}
			{{ HTML::script('admin/assets/lib/respond/respond.min.js') }}
		<![endif]-->

		{{ HTML::script('admin/assets/lib/jquery.min.js') }}
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js') }}
		{{ HTML::script('admin/assets/lib/modernizr-build.min.js') }}
		{{ HTML::script('admin/assets/lib/bootstrap/js/bootstrap.min.js') }}
		{{ HTML::script('admin/assets/lib/jasny/js/jasny-bootstrap.min.js') }}
		{{ HTML::script('admin/assets/lib/datatables/jquery.dataTables.js') }}
		{{ HTML::script('admin/assets/lib/datatables/DT_bootstrap.js') }}
		{{ HTML::script('admin/assets/lib/tablesorter/js/jquery.tablesorter.min.js') }}
		{{ HTML::script('admin/assets/js/main.js') }}
		{{ HTML::script('admin/js/main.js') }}

		<script type="text/javascript">
		$(function()
		{
			metisTable();
		});
		</script>
	</head>
	<body>
		<div id="wrap">
			@include('admin.partials.header')
			@include('admin.partials.sidebar')

			<div id="content">
				<div class="outer">
					@include('admin.partials.message')

					@yield('content')
				</div>
			</div>
		</div>

		@include('admin.partials.footer')
	</body>
</html>