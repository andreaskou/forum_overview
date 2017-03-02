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
	private 	$db;
	protected 	$template;
	private 	$auth;
	private 	$request;
	private 	$helper;
	private 	$symfony;
	private 	$forum_id;
	private 	$container;
	protected	$phpbb_root_path;
	protected	$phpEx;
	protected	$forum_data;

	function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\auth\auth $auth, \phpbb\request\request $request,\phpbb\controller\helper $helper, ContainerInterface $container, $phpbb_root_path, $phpEx)
	{
		$this->db				=	$db;
		$this->template			=	$template;
		$this->auth				=	$auth;
		$this->request			=	$request;
		$this->helper			=	$helper;
		$this->phpbb_root_path	=	$phpbb_root_path;
		$this->container		=	$container;
		$this->phpEx			=	$phpEx;
		$this->helper			=	$helper;
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

		if ($this->forum_data)
		{

			$rule_text		= $this->forum_data['rules']['forum_rules'];
			$rule_uid		= $this->forum_data['rules']['forum_rules_uid'];
			$rule_bitfield	= $this->forum_data['rules']['forum_rules_bitfield'];
			$rule_options	= $this->forum_data['rules']['forum_rules_options'];

			$this->text_for_display($rule_text, $rule_uid, $rule_bitfield, $rule_options);

			return new JsonResponse($this->forum_data);
		}
	}

	private function forum_info()
	{
		// $sql = 'SELECT * FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $this->forum_id;
		//
 		// 	$result = $this->db->sql_query($sql);
		// $this->forum_data = $this->db->sql_fetchrow($result);

		// while ($row = $this->db->sql_fetchrow($result))
		// {
		// 	if($row[0]['forum_rules'] != null)
		// 	{
		// 		$row[0]['forum_rules'] = $this->text_for_display($row[0]['forum_rules']);
		// 	}
		// 	$this->forum_data[] = $row;
		// }
		// $this->db->sql_freeresult($result);

		$get_info = $this->container->get('andreas.forum_overview.classes.get_info');
		array_push($this->forum_data, $get_info->get_rules($this->forum_id));

	}

	public function text_for_display($text)
	{

		include_once($thi->phpbb_root_path . 'includes/functions_posting.' . $thos->phpEx);

		$text = generate_text_for_display($text,'','','');

		return $text;
	}
}
