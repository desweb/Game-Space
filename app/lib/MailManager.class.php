<?php

class MailManager
{
	/**
	 * Administration
	 */

	public static function adminAdd($administrator, $password)
	{
		Mail::send('admin.emails.administrator.add',
			array(
				'administrator'	=> $administrator,
				'password'		=> $password),
			function($message) use ($administrator)
		{
			$message->to($administrator->email, $administrator->username)->subject('Création de votre compte administrateur');
		});
	}

	public static function adminLostPassword($user_token)
	{
		Mail::send('admin.emails.auth.lostPassword',
			array('user_token'=> $user_token),
			function($message) use ($user_token)
		{
			$message->to($user_token->user->email, $user_token->user->username)->subject('Réinitialiser mon mot de passe');
		});
	}

	public static function userPasswordReinit($user, $password)
	{
		Mail::send('admin.emails.user.password',
			array(
				'user'		=> $user,
				'password'	=> $password),
			function($message) use ($user)
		{
			$message->to($user->email, $user->username)->subject('Réinitilisation de votre mot de passe');
		});
	}

	public static function userBan($user)
	{
		Mail::send('admin.emails.user.ban',
			array('user' => $user),
			function($message) use ($user)
		{
			$message->to($user->email, $user->username)->subject('Bannissement de votre compte');
		});
	}

	public static function witnessDelete($witness)
	{
		Mail::send('admin.emails.witness.delete',
			array('witness' => $witness),
			function($message) use ($witness)
		{
			$message->to($witness->user->email, $witness->user->username)->subject('Suppression de votre témoignage');
		});
	}

	public static function contactAnswer($contact, $answer)
	{
		Mail::send('admin.emails.contact.answer',
			array(
				'contact'	=> $contact,
				'answer'	=> $answer),
			function($message) use ($contact)
		{
			$message->to($contact->email, $contact->username)->subject('Réponse à votre message');
		});
	}

	/**
	 * Front
	 */

}