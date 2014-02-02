<div id="password-reinit-popup" class="popup-mini popup">
	<div class="close link"></div>
	<h2>Mot de passe réinitialisé</h2>

	<div class="popup-content">
		@if (Session::has('password_reinit_error'))
			<p class="error">{{ Session::get('password_reinit_error') }}</p>
		@endif

		@if (Session::has('password_reinit_success'))
			<p class="success">{{ Session::get('password_reinit_success') }}</p>
		@endif
	</div>
</div>

<script type="text/javascript">
$(function()
{
	setTimeout(function()
	{
		Interface.showPopup('password-reinit-popup');
	}, 5000);
});
</script>