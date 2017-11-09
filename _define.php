<?php
// +-----------------------------------------------------------------------+
// | tagDescription - a plugin for dotclear                                |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2013-2017 Nicolas Roudaire       https://www.nikrou.net  |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License version 2 as     |
// | published by the Free Software Foundation                             |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,            |
// | MA 02110-1301 USA.                                                    |
// +-----------------------------------------------------------------------+

if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
	/* Name */				"tagDescription",
	/* Description*/		"Add description for tags",
	/* Author */			"Nicolas Roudaire",
	/* Version */			'0.5.4',
	array(
		'permissions' =>	'contentadmin',
		'type' => 'plugin',
		'dc_min' => '2.6',
        'support' => 'http://forum.dotclear.org/viewtopic.php?id=47634',
        'details' => 'http://plugins.dotaddict.org/dc2/details/tagDescription'
	)
);
