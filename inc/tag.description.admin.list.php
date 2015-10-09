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

class tagDescriptionAdminList extends adminGenericList
{
    public static $anchor = 'descriptions';
    private $p_url;

    public function setPluginUrl($p_url) {
        $this->p_url = $p_url;
    }

    public function display($tags, $nb_per_page, $enclose_block) {
        $pager = new tagDescriptionPager($tags, $this->rs_count, $nb_per_page, 10);
        $pager->setVarPage('page');
        $pager->setAnchor(self::$anchor);

        $html_block =
			'<div class="table-outer">'.
            '<table class="tags clear" id="tags-list">'.
            '<thead>'.
            '<tr>'.
            '<th>'. __('Tag').'</th>'.
            '<th>'.__('Description').'</th>'.
            '</tr>'.
            '</thead>'.
            '<tbody>%s</tbody></table>'.
            '</div>';

        echo $pager->getLinks();

        if ($enclose_block) {
            $html_block = sprintf($enclose_block, $html_block);
        }

        $blocks = explode('%s',$html_block);

        echo $blocks[0];

        while ($this->rs->fetch()) {
            echo $this->postLine();
        }

        echo $blocks[1];

        echo $pager->getLinks();
    }

    private function postLine() {
        $res =
            '<tr>'.
            '<td>'.
            '<a href="'.sprintf($this->p_url, $this->rs->meta_id).'">'.
            html::escapeHTML(text::cutString($this->rs->meta_id, 50)).
            '</a>'.
            '</td>'.
            '<td class="nowrap">'.html::escapeHTML(text::cutString($this->rs->meta_desc, 50)).'</td>'.
            '</tr>';

        return $res;
    }
}