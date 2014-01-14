<form method="post" action="{{ route('admin_achievement_edit_image_validation', array('id' => $achievement->id)) }}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">

	<div class="form-group">
		{{ HTML::image($achievement->image->url, $achievement->title, array('width' => '100px', 'class' => 'control-label col-lg-4')) }}
		<div class="col-lg-8">
			{{ Form::file('image', array('class' => 'form-control', 'accept' => 'image/png,image/jpg', 'size' => 1048576, 'required' => true)) }}
			<br/>
			{{ Form::button('Modifier l\'image', array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		</div>
	</div>

{{ Form::close() }}