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

namespace andreask\forum_overview\migrations;

use phpbb\db\migration\migration;

class add_module extends migration
{

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v316');
	}

	// public function effectively_installed()
	// {
	// 	return phpbb_version_compare($this->config['andreask_ium_version'], '0.9.1', '>=');
	// }

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_MANAGE_FORUMS',
				// 'ACP_FORUM_OVERVIEW_PAGE',
				array(
					'module_basename' => '\andreask\forum_overview\acp\forum_overview_module',
					'modes' => array('forum_overview_page'),
				),
			)),
		);
	}
}
