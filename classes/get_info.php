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

	private $db, $user;
	protected $log, $container;

	function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user,\phpbb\log\log $log, ContainerInterface $container)
	{
		$this->db			=	$db;
		$this->user			=	$user;
		$this->log 			=	$log;
		$this->container	=	$container;
	}


}
