function Console()
{
	this.log = function(message)
	{
		console.log(message);
	};

	this.info = function(message)
	{
		console.log('INFO : ' + message);
	};

	this.debug = function(message)
	{
		console.log('DEBUG : ' + message);
	};

	this.trace = function(class_str, function_str, message)
	{
		console.log('[' + class_str + ':' + function_str + ']' + (message? ' ' + message: ''));
	};
}

var Console = new Console;