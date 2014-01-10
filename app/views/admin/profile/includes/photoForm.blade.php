<form method="post" action="{{ route('admin_profile_edit_photo_validation') }}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">

	<div class="form-group">
		{{ HTML::image(Auth::user()->photo->url, Auth::user()->username, array('width' => '100px', 'class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::file('photo', array('class' => 'form-control', 'accept' => 'image/png,image/jpg', 'size' => 1048576, 'required' => true)) }}
			<br/>
			{{ Form::button('Modifier mon avatar', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}