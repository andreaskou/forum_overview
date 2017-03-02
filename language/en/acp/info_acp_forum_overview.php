<?php

/**
* This file is part of the phpBB Forum extension package
* 'Forum Overview'.
*
* @copyright (c) 2016 by Andreas Kourtidis
* @license   GNU General Public License, version 2 (GPL-2.0)
*
* For full copyright and license information, please see
* the CREDITS.txt file.
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty( $lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge(
		$lang, array(
	'ACP_FORUM_OVERVIEW_TITLE'	=>	'Forum Overview',
	'FORUM_OVERVIEW_TITLE'	=>	'Forum Overvew',
	'FORUM_OVERVIEW_EXPLAIN'	=> 'Explanation',
	'ACP_FO_PAGE'			=>	'Forum Overvew',
	'FORUM_ID'				=> 'ID',
	'TITLE'					=>	'Title',
	'ASSIGNED_IMAGE'		=>	'Image',
	'FORUM_TYPE'			=>	'Type',

	'FORUM_TYPE_CATEGORY'	=>	'Category',
	'FORUM_TYPE_FORUM'		=>	'Forum',
	'FORUM_TYPE_LINK'		=>	'Link',
	)
);
