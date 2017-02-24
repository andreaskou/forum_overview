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

// use phpbb\log\null;

//use Symfony\Component\DependencyInjection\ContainerInterface;

class forum_overview_module
{
	public function main($id, $mode)
	{
		global $user, $language, $template, $request, $db, $config, $phpbb_container, $phpbb_root_path, $phpEx;
		$config_text = $phpbb_container->get('config_text');
		$this->tpl_name = 'acp_forum_overview';
		$this->page_title = $user->lang('ACP_FO_PAGE');


		if ($mode == 'forum_overview_page')
		{
			$this->tpl_name = 'acp_forum_overview';

			$form_key = 'andreask_forum_overview';

			add_form_key($form_key);

			$template->assign_vars(array(
				''
			));

			$sql_opt = '';

			$parent_id = $request->variable('forum_id', 0);

			if ($parent_id){
				$sql_opt = ' WHERE parent_id =' . $parent_id;
			}
			else
			{
				$sql_opt = ' WHERE parent_id = 0';
			}

			$sql = 'Select * from ' . FORUMS_TABLE .
			$sql_opt .
			' order by forum_id, parent_id';
			// print_r($sql);
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				$forums[] = $row;
			};

			$db->sql_freeresult($result);

			$board_url = generate_board_url().'/';

			$template->assign_var('FORUM_OVERVIEW_PAGE', true);
			$template->assign_var('custome', true);

			foreach ($forums as $forum)
			{
				// Generate image url
				$img_url = ($forum['forum_image']) ? $board_url.$forum['forum_image'] : false;

				switch ($forum['forum_type'])
				{
					case '0':
					$forum_type = 'Category';
					break;

					case '1':
						$forum_type = 'Forum';
					break;

					case '2':
						$forum_type = 'Link';
					break;

					default:
					break;
				}

				// var_dump($this->has_more($forum['forum_id']));
				// $forum['forum_id'] = $this->has_more($forum['forum_id']);

				$template->assign_block_vars('forum_list', array(
					'LINK'			=>	$this->u_action . '&amp;forum_id=' . $forum['forum_id'],
					'HAS_MORE'		=>	$this->has_more($forum['forum_id']),
					'FORUM_ID'		=>	$forum['forum_id'],
					'PARENT_ID'		=>	$forum['parent_id'],
					'IMG'			=>	$img_url,
					'FORUM_NAME'	=>	$forum['forum_name'],
					'FORUM_TYPE'	=>	$forum_type,
				));
				// Reset image url.
				$img_url = '';
				$forum_type = '';
			}

			// echo "<pre>";
			// print_r($forums[61]);
			// echo "</pre>";
		}
	}

	private function has_more($forum_id)
	{
		global $user, $language, $template, $request, $db, $config, $phpbb_container, $phpbb_root_path, $phpEx;

		$sql = 'SELECT COUNT(forum_id) AS forum_counter
				FROM ' . FORUMS_TABLE .'
				WHERE parent_id= '. $forum_id;

		print_r($sql);
		echo "</br>";

		$result = $db->sql_query($sql);

		$count = (bool) $db->sql_fetchfield('forum_counter');
		$db->sql_freeresult($result);

		return($count);
	}

}
