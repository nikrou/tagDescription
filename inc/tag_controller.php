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

if (!defined('DC_CONTEXT_ADMIN')) { exit; }

$tag = array('id' => '', 'desc' => '', 'title' => '');
$tag_manager = new tagManager($core);

if ($_REQUEST['action']=='edit' && !empty($_REQUEST['tag_id'])) {
    $rs = $tag_manager->findById($_REQUEST['tag_id']);
    if (!$rs->isEmpty()) {
        $tag['id'] = $rs->meta_id;
        $tag['desc'] = $rs->tag_desc;
        $tag['title'] = $rs->tag_title;
    }
}

if (!empty($_POST['save_tag'])) {
    // save current values
    $tag['title'] = (string) $_POST['tag_title'];
    $tag['desc'] = (string) $_POST['tag_desc'];

    $cur = $tag_manager->openCursor();
    $cur->tag_id = $tag['id'];
    $cur->tag_desc = $tag['desc'];
    $cur->tag_title = $tag['title'];

    try {
        if (!$rs->isEmpty() && $rs->tag_id) {
            $tag_manager->update($tag['id'], $cur);
        } else {
            $tag_manager->add($cur);
        }
        $message = __('The tag metadatas have been updated.');
        $_SESSION['tag_description_message'] = $message;
        $_SESSION['tag_description_default_tab'] = 'descriptions';
        http::redirect($p_url);
    } catch (Exception $e) {
        $core->error->add($e->getMessage());
    }
}

include(dirname(__FILE__).'/../tpl/form_tag.tpl');
