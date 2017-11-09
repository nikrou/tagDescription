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

class tagDescriptionTpl
{
    public static function TagDescription($attr) {
		$content_only = !empty($attr['content_only']) ? 1 : 0;

		$f = $GLOBALS['core']->tpl->getFilters($attr);

        $res = "<?php\n echo ".sprintf($f,'$_ctx->tag_manager->findById($_ctx->meta->meta_id)->tag_desc').'; ?>';
        if (!$content_only) {
            $res = '<div class="tagDescription">'.$res.'</div>';
        }

        return $res;
    }

    public static function TagTitle($attr) {
		$content_only = !empty($attr['content_only']) ? 1 : 0;

		$f = $GLOBALS['core']->tpl->getFilters($attr);

        $res = "<?php\n";
        $res .= '$tag = $_ctx->tag_manager->findById($_ctx->meta->meta_id);'."\n";
        $res .= 'echo '.sprintf($f,'$tag->tag_title?$tag->tag_title:$tag->tag_id').'; ?>';
        if (!$content_only) {
            $res = '<div class="tagTitle">'.$res.'</div>';
        }

        return $res;
    }

    public static function breadcrumb($elements=null,$options=array()) {
        if (method_exists('dcPage', 'breadcrumb')) {
            return dcPage::breadcrumb($elements, $options);
        } else {
            $with_home_link = isset($options['home_link'])?$options['home_link']:true;
            $hl = isset($options['hl'])?$options['hl']:true;
            $hl_pos = isset($options['hl_pos'])?$options['hl_pos']:-1;
            // First item of array elements should be blog's name, System or Plugins
            $res = '<h2>';
            $index = 0;
            if ($hl_pos < 0) {
                $hl_pos = count($elements)+$hl_pos;
            }
            foreach ($elements as $element => $url) {
                if ($hl && $index == $hl_pos) {
                    $element = sprintf('<span class="page-title">%s</span>',$element);
                }
                $res .= ($index == 0 ? ' ' : ' &rsaquo; ').
                    ($url ? '<a href="'.$url.'">' : '').$element.($url ? '</a>' : '');
                $index++;
            }
            $res .= '</h2>';

            return $res;
        }
    }
}