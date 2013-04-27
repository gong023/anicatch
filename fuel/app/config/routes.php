<?php
return array(
	'_root_'  => 'top/index',  // The default route
	'_404_'   => 'top/404',    // The main 404 route
	
	'stream(/:page)?'  => 'stream/index',
  'anime/:id/stream' => 'stream/anime',
  'anime/:id/like'   => 'api/anime/like',
  'anime/:id/unlike' => 'api/anime/unlike',
  'anime/:id/reject/:vhash/src/:src' => 'api/anime/reject',

  'login' => 'login/index',
	//'hello(/:name)?'   => array('top/hello', 'name' => 'hello'),
);
