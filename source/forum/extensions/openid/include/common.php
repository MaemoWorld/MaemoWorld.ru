<?php
/**
 * @file common.php
 * @brief Common code to initialize usage of Ext_PunBB_OpenIDHandler.
 */

/*
 *      Copyright 2009 Alexander Steffen <devel.20.webmeister@spamgourmet.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


// include language file
if (file_exists($ext_info['path'].'/lang/'.$forum_user['language'].'/openid.php'))
{
	include $ext_info['path'].'/lang/'.$forum_user['language'].'/openid.php';
}
else
{
	include $ext_info['path'].'/lang/English/openid.php';
}

// temporarily change include path to extension directory
$openid_backup_include_path = ini_get('include_path');
ini_set('include_path', $ext_info['path']);
require_once 'Ext/PunBB/OpenIDHandler.php';
ini_set('include_path', $openid_backup_include_path);

// add URL to OpenID profile section
$forum_url['profile_openid'] = preg_replace('/settings(?!.*settings)/', 'openid', $forum_url['profile_settings']);


function openid_remove_required_notice($fields)
{
	global $lang_common;

	$text = forum_trim(ob_get_clean());

	foreach ($fields as $field)
	{
		$text = preg_replace('/ required(">[^>]*>[^>]*>'.preg_quote($field, '/').') <em>'.preg_quote($lang_common['Required'], '/').'<\/em>/', '$1', $text);
	}

	ob_start();
	echo $text;
}
?>
