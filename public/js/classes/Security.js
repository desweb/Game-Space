function Security()
{
	// http://www.jquery4u.com/syntax/jquery-basic-regex-selector-examples/

	var _integer_regex = /^[0-9]+$/

	this.integer = function(integer)
	{
		return _integer_regex.test(integer);
	};
}

var Security = new Security;