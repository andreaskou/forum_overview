<?php

/**
* This file is part of the phpBB Forum extension package
* IUM (Inactive User Manager).
*
* @copyright (c) 2016 by Andreas Kourtidis
* @license   GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the CREDITS.txt file.
*/

namespace andreask\forum_overview\acp;

class forum_overview_module_info {

	public function module()
	{
		return array(
			'filename'	=>	'\andreask\forum_overview\acp\main_fo_page',
			'title'		=>	'ACP_FORUM_OVERVIEW_PAGE',
			// 'version'	=>	'1.0.0',
			'modes'		=>	array(
								'forum_overview_page'	=>	array(
									'title'		=>	'ACP_FORUM_OVERVIEW_TITLE',
									'auth'		=>	'ext_andreask/forum_overview && acl_a_forum',
									'cat'		=>	array('ACP_MANAGE_FORUMS')),
			),
		);
	}
}
