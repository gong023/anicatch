<?php
return array(
	'_root_'  => 'top/index',  // The default route
	'_404_'   => 'top/404',    // The main 404 route
	
	'stream(/:page)?' => 'stream/index',
	'hello(/:name)?' => array('top/hello', 'name' => 'hello'),
);
