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

class tagManager
{
    private $fields = array('meta_id', 'meta_type', 'post_id', 'meta_desc');
    private $required_fields = array('meta_id', 'meta_type', 'post_id');

    public function __construct($core) {
        $this->core = $core;
        $this->blog = $core->blog;
        $this->con = $this->blog->con;
        $this->table = $this->blog->prefix.'meta';
    }

    public function openCursor() {
        return $this->con->openCursor($this->table);
    }

    public function update($id, $cur) {
        $cur->update('WHERE meta_id = \''.$this->con->escape($id).'\' AND meta_type=\'tag\'');

        return $cur;
    }

    public function findById($id) {
        $strReq =  'SELECT '.implode(',', $this->fields);
        $strReq .= ' FROM '.$this->table;
        $strReq .= ' WHERE meta_id=\''.$this->con->escape($id).'\'';
        $strReq .= ' AND meta_type=\'tag\'';

        $rs = $this->con->select($strReq);
        $rs = $rs->toStatic();

        return $rs;
    }

    public function getList(array $limit=array()) {
        $strReq =  'SELECT distinct(meta_id), meta_desc';
        $strReq .= ' FROM '.$this->table;
        $strReq .= ' WHERE meta_type=\'tag\'';
        $strReq .= ' ORDER BY meta_id ASC';

        if (!empty($limit)) {
			$strReq .= $this->con->limit($limit);
        }

        $rs = $this->con->select($strReq);
        $rs = $rs->toStatic();

        return $rs;
    }

    public function getcountList() {
        $strReq =  'SELECT count(distinct(meta_id))';
        $strReq .= ' FROM '.$this->table;
        $strReq .= ' WHERE meta_type=\'tag\'';

        $rs = $this->con->select($strReq);
        $rs = $rs->toStatic();

        return $rs->f(0);
    }

    public function getAll() {
        $strReq =  'SELECT '.implode(',', $this->fields);
        $strReq .= ' FROM '.$this->table;
        $strReq .= ' WHERE meta_type=\'tag\'';

        if (!empty($limit)) {
			$strReq .= $this->con->limit($limit);
        }

        $rs = $this->con->select($strReq);
        $descriptions = array();
        while ($rs->fetch()) {
            $descriptions[$rs->meta_id] = $rs->meta_desc;
        }

        return $descriptions;
    }
}