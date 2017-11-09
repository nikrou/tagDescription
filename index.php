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

if (!empty($_SESSION['tag_description_message'])) {
    $message = $_SESSION['tag_description_message'];
    unset($_SESSION['tag_description_message']);
}

$is_super_admin = $core->auth->isSuperAdmin();
$core->blog->settings->addNameSpace('tagdescription');
$tag_description_active = $core->blog->settings->tagdescription->active;
$tag_description_was_actived = $tag_description_active;

$page_title = __('Tag Description');
$default_tab = 'settings';

$Actions = array('edit');
if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $Actions)) {
    $action = $_REQUEST['action'];
}

if (!empty($_REQUEST['object']) && $_REQUEST['object']=='tag') {
    include(dirname(__FILE__).'/inc/tag_controller.php');
} else {
    if (!empty($_POST['saveconfig'])) {
        try {
            $tag_description_active = (empty($_POST['tag_description_active']))?false:true;
            $core->blog->settings->tagdescription->put('active', $tag_description_active, 'boolean');

            $_SESSION['tag_description_message'] = __('The configuration has been updated.');
            http::redirect($p_url);
        } catch(Exception $e) {
            http::redirect($p_url);
        }
    }

    # list
    $tag_manager = new tagManager($core);

    $page_tags = !empty($_GET['page']) ? (integer) $_GET['page'] : 1;
    $nb_per_page_tags =  10;

    if (!empty($_GET['nb']) && (integer) $_GET['nb'] > 0) {
        $nb_per_page_tags = (integer) $_GET['nb'];
    }
    $limit_tags = array((($page_tags-1)*$nb_per_page_tags), $nb_per_page_tags);

    try {
        $tags_counter = $tag_manager->getCountList();

        $tags_list = new tagDescriptionAdminList($core, $tag_manager->getList($limit_tags), $tags_counter);
        $tags_list->setPluginUrl("$p_url&amp;object=tag&amp;action=edit&amp;tag_id=%s");
    } catch (Exception $e) {
        $core->error->add($e->getMessage());
    }

    if ($tag_description_active) {
        if (!empty($_SESSION['tag_description_default_tab'])) {
            $default_tab = $_SESSION['tag_description_default_tab'];
            unset($_SESSION['tag_description_default_tab']);
        } else {
            $default_tab = 'descriptions';
        }
    } else {
        $default_tab = 'settings';
    }

    include(dirname(__FILE__).'/tpl/index.tpl');
}
