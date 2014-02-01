function Security()
{
	// http://www.jquery4u.com/syntax/jquery-basic-regex-selector-examples/

	var _integer_regex	= /^[0-9]+$/;
	var _email_regex	= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

	this.empty = function(val)
	{
		return val.length == 0;
	};

	this.integer = function(integer)
	{
		return _integer_regex.test(integer);
	};

	this.email = function(email)
	{
		return _email_regex.test(email);
	};
}

var Security = new Security;