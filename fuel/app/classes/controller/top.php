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

/** TODO: use model
use Model\Anime;
use Model\Sampletable;
**/

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
    // TODO: use model : $query=DB::select()->from(‘animes’)->execute();
    $limit = 20;
    $query0 = 'SELECT * FROM animes ORDER BY unlikes, created_at DESC, likes DESC LIMIT 0, '.$limit;
    $query1 = 'SELECT * FROM animes ORDER BY unlikes, created_at DESC, likes DESC LIMIT ' . ($limit*1) . ',' . $limit;
    $query2 = 'SELECT * FROM animes ORDER BY unlikes, created_at DESC, likes DESC LIMIT ' . ($limit*2) . ',' . $limit;
    $list0 = DB::query($query0)->execute()->as_array();
    $list1 = DB::query($query1)->execute()->as_array();
    $list2 = DB::query($query2)->execute()->as_array();

    $view = ViewModel::forge('top/index');
    $view->set('list0', $this->_checkNew($list0));
    $view->set('list1', $list1);
    $view->set('list2', $list2);
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
