<?php

class Model_Anime extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'url',
		'likes',
		'unlikes',
		'info',
		'updated_at',
		'created_at',
		'deleted'
		//'created_at',
		//'updated_at',
	);

  protected static $_table_name = 'animes';

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
}
