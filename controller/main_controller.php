<?php

/**
* This file is part of the phpBB Forum extension package
* Forum overview.
*
* @copyright (c) 2017 by Andreas Kourtidis
* @license   GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the CREDITS.txt file.
*/

namespace andreask\forum_overview\controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
class main_controller
{
	private $db;
	protected $template;
	private $auth;
	private $request;
	private $helper;
	private $symfony;

	function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template,\phpbb\auth\auth $auth,\phpbb\request\request $request,\phpbb\controller\helper  $helper)
	{
		$this->db		=	$db;
		$this->template	=	$template;
		$this->auth		=	$auth;
		$this->request	=	$request;
		$this->helper	=	$helper;
	}

	public function get_info()
	{
		$forum_id = $this->request->variable('forum_id', 'empty forum_id');

		if($this->request->is_ajax())
		{
			return new JsonResponse($forum_id);
		}

		echo $forum_id;
		return new JsonResponse('Test!!!!!!!!!!!!');
	}

}
