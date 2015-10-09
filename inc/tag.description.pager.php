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

class tagDescriptionPager extends dcPager
{
    protected $anchor;

    public function __construct($env,$nb_elements,$nb_per_page=10,$nb_pages_per_group=10) {
        parent::__construct($env,$nb_elements,$nb_per_page,$nb_pages_per_group);
    }

    public function setAnchor($anchor) {
        $this->anchor = $anchor;
    }

    public function setVarPage($var_page) {
        $this->var_page = $var_page;
    }

	public function setURL() {
        parent::setUrl();
        $this->page_url .= '#'.$this->anchor;
        $this->form_action .= '#'.$this->anchor;
    }
}
