<?php
// +-----------------------------------------------------------------------+
// | tagDescription - a plugin for dotclear                                |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2013-2015 Nicolas Roudaire        http://www.nikrou.net  |
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

$tag = array('meta_id' => '', 'meta_desc' => '');
$tag_manager = new tagManager($core);

if ($_REQUEST['action']=='edit' && !empty($_GET['id'])) {
    $rs = $tag_manager->findById($_GET['id']);
    if (!$rs->isEmpty()) {
        $tag['meta_id'] = $rs->meta_id;
        $tag['meta_desc'] = $rs->meta_desc;
        $_SESSION['meta_id'] = $_GET['id'];
    }
}

if (!empty($_POST['save_tag'])) {
    // save current values
    $tag['meta_id'] = $_POST['tag_meta_id'];
    $tag['meta_desc'] = (string) $_POST['tag_meta_desc'];

    $cur = $tag_manager->openCursor();
    $cur->meta_desc = (string) $_POST['tag_meta_desc'];

    try {
        if ($action=='edit') {
            $tag_manager->update($_SESSION['meta_id'], $cur);
            $message = __('The tag description has been updated.');
            unset($_SESSION['meta_id']);
        }
        $_SESSION['tag_description_message'] = $message;
        $_SESSION['tag_description_default_tab'] = 'descriptions';
        http::redirect($p_url);
    } catch (Exception $e) {
        $core->error->add($e->getMessage());
    }
}

include(dirname(__FILE__).'/../tpl/form_tag.tpl');
