function Contact()
{
	var _is_loading = false;

	var _form_id;

	var _username_element;
	var _email_element;
	var _object_element;
	var _message_element;

	var _button_element;

	/**
	 * Setters
	 */

	this.setFormId = function(form_id)
	{
		_form_id = form_id;
	};

	/**
	 * Checks
	 */

	this.checkFields = function()
	{
		_username_element	= $('#' + _form_id + ' input[name=username]');
		_email_element		= $('#' + _form_id + ' input[name=email]');
		_object_element		= $('#' + _form_id + ' select[name=object] option:selected');
		_message_element	= $('#' + _form_id + ' textarea[name=message]');

		// Empty
		if (Security.empty(_username_element.val()))
		{
			Message.error('Prénom Nom obligatoire.');
			return false;
		}

		if (Security.empty(_email_element.val()))
		{
			Message.error('Email obligatoire.');
			return false;
		}

		if (Security.empty(_message_element.val()))
		{
			Message.error('Message obligatoire.');
			return false;
		}

		// Email
		if (!Security.email(_email_element.val()))
		{
			Message.error('Email invalide.');
			return false;
		}

		return true;
	};

	/**
	 * Functionnalities
	 */

	this.send = function()
	{
		if (_is_loading) return;

		_is_loading = true;

		_button_element	= $('#' + _form_id + ' button');

		_button_element.html(Interface.getLoaderMini());

		API.post_contact(_form_id,
		{
			success : function(response)
			{
				if (response.error) return;

				Message.success('Message envoyé.');
				Interface.hidePopup();

				_username_element	.val('');
				_email_element		.val('');
				_message_element	.val('');

				$('#' + _form_id + ' select[name=object] option')		.prop('selected', false);
				$('#' + _form_id + ' select[name=object] option:first')	.prop('selected', true);
			},
			always : function()
			{
				_is_loading = false;

				_button_element.html('Envoyer');
			}
		});
	};
}

var Contact = new Contact;