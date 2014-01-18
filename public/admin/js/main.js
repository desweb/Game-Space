$(function()
{
	/**
	 * Global
	 */

	$('.delete').click(function(e)
	{
		if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) return false;
	});
});