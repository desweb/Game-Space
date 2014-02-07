API.BASE_URL = 'http://admin.game-space.desweb-creation.fr/api/';

API.post_mapMain = function(element_id)
{
	if (GameState.game().isSave()) return;

	GameState.game().setIsSave(true);

	$(element_id).html(Interface.getLoaderMini());

	// Init
	var game_ids_param	= new Array;
	var games_param		= new Array;
	var game_main_json	= new Array;

	// Main game
	for (var i in GameState.game().getLevels())
		game_main_json[i] = { pos : { x : parseInt(GameState.game().getLevel(i).getSprite().x), y : parseInt(GameState.game().getLevel(i).getSprite().y) }};

	games_param[GameState.game().getId()] = JSON.stringify(game_main_json);

	// Minis games
	for (var i in GameState.game().getMiniGames())
		games_param[Common.game.mini_games[i].id] = JSON.stringify({ pos : { x : parseInt(GameState.game().getMiniGame(i).getSprite().x), y : parseInt(GameState.game().getMiniGame(i).getSprite().y) }});

	// Request
	this.postRequest({
		url		: 'map/main',
		datas	: { 'games[]' : games_param }
	},
	{
		success : function(response)
		{
			if (response.error) return;

			Message.success('Carte sauvegardée');
		},
		always : function()
		{
			GameState.game().setIsSave(false);

			$('#save-button').html('Sauvegarder');
		}
	});
};