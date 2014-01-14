<?php

class Image extends Eloquent
{
	const TYPE_PROFILE		= 1;
	const TYPE_GAME			= 2;
	const TYPE_ACHIEVEMENT	= 3;

	private static $server_paths = array(
		self::TYPE_PROFILE		=> '/homez.488/deswebcr/www/_game/game-space/public/uploads/profile/',
		self::TYPE_GAME			=> '/homez.488/deswebcr/www/_game/game-space/public/uploads/game/',
		self::TYPE_ACHIEVEMENT	=> '/homez.488/deswebcr/www/_game/game-space/public/uploads/achievement/');

	private static $url_paths = array(
		self::TYPE_PROFILE		=> 'http://game-space.desweb-creation.fr/uploads/profile/',
		self::TYPE_GAME			=> 'http://game-space.desweb-creation.fr/uploads/game/',
		self::TYPE_ACHIEVEMENT	=> 'http://game-space.desweb-creation.fr/uploads/achievement/');

	private static $sizes = array(
		self::TYPE_PROFILE		=> array('width' => 150, 'height' => 150),
		self::TYPE_GAME			=> array('width' => 250, 'height' => 250),
		self::TYPE_ACHIEVEMENT	=> array('width' => 250, 'height' => 250));

	protected $table = 'image';

	public $file;
	public $file_name;
	public $owner;

	private $file_width;
	private $file_height;

	private $is_owner_save = true;

	public function upload($input_name, $is_owner_save = true)
	{
		if (!Input::hasFile($input_name)) return;

		$this->file = Input::file($input_name);

		if ($this->server_path) File::delete($this->server_path);

		$this->setFileName();
		$this->setServerPathFile();
		$this->setUrlFile();

		list($this->file_width, $this->file_height) = getimagesize(Input::file($input_name));

		$this->file->move($this->getServerPath(), $this->file_name);

		$this->resize();
		$this->save();

		$this->is_owner_save = $is_owner_save;
		$this->ownerSave();
	}

	public function tmp()
	{
		$this->server_path	= '';
		$this->url			= '';
		$this->save();

		$this->is_owner_save = false;
		$this->ownerSave();
	}

	public function rename()
	{
		if (!$this->server_path || substr($this->url, 0, 27) == 'https://graph.facebook.com/') return;

		$this->setFileName();

		exec('/usr/bin/convert ephemeral:' . $this->server_path . ' ' . $this->getServerPath() . $this->file_name);

		$this->setServerPathFile();
		$this->setUrlFile();

		$this->save();
	}

	private function getServerPath()
	{
		return self::$server_paths[$this->type];
	}

	private function ownerSave()
	{
		switch($this->type)
		{
			case self::TYPE_PROFILE		: $this->owner->photo_id = $this->id; break;
			case self::TYPE_GAME		: $this->owner->image_id = $this->id; break;
			case self::TYPE_ACHIEVEMENT	: $this->owner->image_id = $this->id; break;
		}

		if ($this->is_owner_save) $this->owner->save();
	}

	private function resize()
	{
		$width	= $this->file_width;
		$height	= $this->file_height;

		$size = self::$sizes[$this->type];

		if ($width > $height)
		{
			$height	= $height / ($width / $size['width']);
			$width	= $size['width'];
		}
		else
		{
			$width	= $width / ($height / $size['height']);
			$height	= $size['height'];
		}

		exec('/usr/bin/convert ' . $this->getServerPath() . $this->file_name . ' -quality 72 -resize ' . $width . 'x' . $height . ' ' . $this->getServerPath() . $this->file_name);
		exec('/usr/bin/convert ' . $this->getServerPath() . $this->file_name . ' -crop ' . $size['width'] . 'x' . $size['height'] . '+0+0 ' . $this->getServerPath() . $this->file_name);
	}

	/**
	 * Overrides
	 */

	public function delete()
	{
		if ($this->server_path) File::delete($this->server_path);

		parent::delete();
	}

	/**
	 * Setters
	 */

	private function setFileName()
	{
		if ($this->file) $ext = $this->file->getClientOriginalExtension();
		else
		{
			$explode= explode('.', $this->server_path);
			$ext	= end($explode);
		}

		$this->file_name = $this->owner->reference . '.' . $ext;
	}

	private function setServerPathFile()
	{
		$this->server_path = $this->getServerPath() . $this->file_name;
	}

	private function setUrlFile()
	{
		$url_file = self::$url_paths[$this->type];

		$this->url = $url_file . $this->file_name;
	}

	public function setOwner($owner) { $this->owner = $owner; }

	public function setFacebookOwner($owner)
	{
		$this->owner= $owner;
		$this->url	= 'https://graph.facebook.com/' . $this->owner->facebook_id . '/picture';

		$this->save();
		$this->ownerSave();
	}

	public function setTypeProfile		() { $this->type = self::TYPE_PROFILE; }
	public function setTypeGame			() { $this->type = self::TYPE_GAME; }
	public function setTypeAchievement	() { $this->type = self::TYPE_ACHIEVEMENT; }
}