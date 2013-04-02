<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

// TODO: use model
//use Model\Anime;
//use Model\Sampletable;

/**
 * The Top Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Top extends Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
    // TODO: use model
    //$query=DB::select()->from(‘animes’)->execute();
    //$res = Model_Sampletable::find_all();
    $rows = DB::query('SELECT * FROM animes ORDER BY id')->execute()->as_array();
    //_var_dump($res);
    $view = ViewModel::forge('top/index');
    $view->set('list', $rows);
		return Response::forge($view);
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a ViewModel to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(ViewModel::forge('top/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(ViewModel::forge('top/404'), 404);
	}
}
