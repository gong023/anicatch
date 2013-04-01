<?php

namespace Fuel\Migrations;

class Create_animes
{
	public function up()
	{
		\DBUtil::create_table('animes', array(
			'id' => array('type' => 'bigint'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'url' => array('type' => 'text'),
			'likes' => array('type' => 'bigint'),
			'unlikes' => array('type' => 'bigint'),
			'info' => array('type' => 'binary'),
			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'datetime'),
			'deleted' => array('type' => 'bool'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('animes');
	}
}