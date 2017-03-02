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
	private $forum_id;
	public $forum_data;

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
		if(!$this->request->is_ajax())
		{
			return false;
		}

		if(!$this->request->is_set('forum_id'))
		{
			return false;
		}

		$this->forum_id = $this->request->variable('forum_id', 'empty forum_id');

		$this->forum_info();

		return new JsonResponse($this->forum_data);
	}

	private function forum_info()
	{
		$sql = 'SELECT * FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $this->forum_id;

 		$result = $this->db->sql_query($sql);
		$this->forum_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
	}
}
