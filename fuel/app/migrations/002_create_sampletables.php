<?php

namespace Fuel\Migrations;

class Create_sampletables
{
	public function up()
	{
		\DBUtil::create_table('sampletables', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('type' => 'text'),
			'pass' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sampletables');
	}
}