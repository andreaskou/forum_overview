<?php

/**
* This file is part of the phpBB Forum extension package
* Forum Overview.
*
* @copyright (c) 2017 by Andreas Kourtidis
* @license   GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the CREDITS.txt file.
*/


/**
 *
 */

class get_info
{

	private $db, $user, $container;
	protected $log, $forum_data;

	function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user,\phpbb\log\log $log, ContainerInterface $container)
	{
		$this->db			=	$db;
		$this->user			=	$user;
		$this->log 			=	$log;
		$this->container	=	$container;
	}

	public function get_rules($forum_id)
	{

		$rules = ['rules'];
		$sql = 'Select forum_rules, forum_rules_bitfield, forum_rules_options, forum_rules_uid, forum_rules_link
				FROM ' . FORUMS_TABLE . '
		 		WHERE forum_id = '. $forum_id .' order by forum_id, left_id, right_id, parent_id';

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$rules['rules'] = $row;
		};
		$db->sql_freeresult($result);

		return $this;
	}

	public function get_description($forum_id)
	{
		$rules = ['description'];
		$sql = 'Select forum_desc, forum_desc_bitfield, forum_desc_options, forum_desc_uid 
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id = '. $forum_id .' order by forum_id, left_id, right_id, parent_id';

		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$rules['rules'] = $row;
		};
		$db->sql_freeresult($result);

		return $this;
	}
}
