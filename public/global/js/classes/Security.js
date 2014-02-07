function Security()
{
	// http://www.jquery4u.com/syntax/jquery-basic-regex-selector-examples/

	var _integer_regex	= /^[0-9]+$/;
	var _email_regex	= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	var _date_regex		= /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;

	this.empty = function(value)
	{
		return value.length == 0;
	};

	this.size = function(string, min, max)
	{
		return string.length >= min && string.length <= max;
	};

	this.integer = function(integer)
	{
		return _integer_regex.test(integer);
	};

	this.integerInterval = function(integer, min, max)
	{
		return integer >= min && integer <= max;
	};

	this.email = function(email)
	{
		return _email_regex.test(email);
	};

	this.date = function(date_str)
	{
		var date_array = date_str.match(_date_regex);

		if (!date_array) return false;

		d = parseInt(date_array[1]);
		m = parseInt(date_array[3]);
		y = parseInt(date_array[5]);

		if ((m < 1 || m > 12) || 
			(d < 1 || d > 31) || 
			((m == 4 || m == 6 || m == 9 || m == 11) && d == 31) || 
			(m == 2 && (d > 29 || (d ==29 && !(y % 4 == 0 && (y % 100 != 0 || y % 400 == 0))))))
			return false;

		return true;
	};
}

var Security = new Security;