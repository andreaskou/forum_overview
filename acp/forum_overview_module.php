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
		global $user, $template, $request, $db, $config, $phpbb_container, $phpbb_root_path, $phpEx;

		$this->tpl_name = 'acp_forum_overview';
		$this->page_title = $user->lang('ACP_FO_PAGE');

		$config_text = $phpbb_container->get('config_text');
		$helper = $phpbb_container->get('controller.helper');
		$language = $phpbb_container->get('language');


		if ($mode == 'forum_overview_page')
		{
			$this->tpl_name = 'acp_forum_overview';

			$form_key = 'andreask_forum_overview';

			add_form_key($form_key);


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

			// Prepare breadcrumbs
			$breadcrumbs = null;
			if($request->variable('forum_id', 0) != 0)
			{
				// Get forum name and id for breadcrumbs
				$crumbs = $this->crumbs($request->variable('forum_id', 0));

				// Generate breadcrumbs
				$breadcrumbs = $this->show_path($crumbs);
			}

			$forum_id = $request->variable('forum_id', 0);
			$forum_info = $this->get_title($forum_id);
			$forum_link = $this->u_action . '&amp;forum_id=' . $forum_id;

			$template->assign_vars(array(
				'FORUM_OVERVIEW_PAGE'	=>	true,
				'custome'				=>	true,
				'HOME'					=>	$this->u_action,
				'FORUM_ID'				=>	$forum_id,
				'FORUM_NAME'			=>	$forum_info['forum_name'],
				'FORUM_LINK'			=>	$forum_link,
				'BREADCRUMB'			=>	$breadcrumbs,
				'BOARD_URL'				=>	$board_url,
				'S_ID'					=>	$user->data['session_id'],
				'AJ_GET_MORE'			=>	htmlspecialchars($helper->route('andreask_forum_overview_get_info')),
			));


			foreach ($forums as $forum)
			{
				// Generate image url
				$img_url = ($forum['forum_image']) ? $board_url.$forum['forum_image'] : false;

				switch ($forum['forum_type'])
				{
					case '0':
					$forum_type = $language->lang('FORUM_TYPE_CATEGORY');
					break;

					case '1':
						$forum_type = $language->lang('FORUM_TYPE_FORUM');
					break;

					case '2':
						$forum_type = $language->lang('FORUM_TYPE_LINK');
					break;

					default:
					break;
				}

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
		}
	}

	private function has_more($forum_id)
	{
		global $db;

		$sql = 'SELECT COUNT(forum_id) AS forum_counter
				FROM ' . FORUMS_TABLE .'
				WHERE parent_id= '. $forum_id;

		$result = $db->sql_query($sql);

		$count = (bool) $db->sql_fetchfield('forum_counter');
		$db->sql_freeresult($result);

		return($count);
	}

	private function crumbs($forum_id)
	{

		if ($forum_id == 0)
		{
			return false;
		}

		// See if there are any higher level forums...
		$parent_ids[] = $this->get_parent($forum_id);

		// While we are not on the top forum keep searching for parent ids
		while ($parent_ids[0] != 0)
		{
			array_unshift($parent_ids, $this->get_parent($parent_ids[0]));
		}

		$crumb = [];

		foreach ($parent_ids as $array => $crumbs)
		{
			// Get the title of forum...
			$crumb[] = $this->get_title($crumbs);
		}

		return $crumb;
	}

	private function get_parent($forum_id)
	{
		global $db;

		$sql = 'SELECT parent_id
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $forum_id;

		$result = $db->sql_query($sql);
		$var = $db->sql_fetchrow($result);
		$parent_id = array_shift($var);
		$db ->sql_freeresult($result);
		return $parent_id;
	}

	private function get_title($forum_id)
	{
		global $db;

		$sql = 'SELECT forum_id, forum_name
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id= ' . $forum_id;

		$result = $db->sql_query($sql);
		$info = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		return $info;
	}

	private function show_path($crumbs)
	{
		global $phpbb_container;
		$language = $phpbb_container->get('language');

		$breadcrumb = '';
		$size = sizeof($crumbs);
		// print_r($crumbs);
		foreach ($crumbs as $key => $value)
		{
			if ($size != $key - 1){
				$arrow = ' <i class="icon fa-arrow-right fa-xsm"></i> ';
				// $arrow = ' -> ';
			}
			else
			{
				$arrow = '';
			}
			// var_dump($value);
			$breadcrumb .= '<a href="' . $this->u_action .'&amp;forum_id=' . $value['forum_id'] . '">' . htmlspecialchars_decode($value['forum_name']) .'</a>' . $arrow;
		}
		return $breadcrumb;
	}

}
