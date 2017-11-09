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

class tagManager
{
    private $fields = array('tag_id', 'tag_desc', 'tag_title');

    public function __construct($core) {
        $this->core = $core;
        $this->blog = $core->blog;
        $this->con = $this->blog->con;
        $this->table = $this->blog->prefix.'tagdescription';
        $this->foreign_table = $this->blog->prefix.'meta';
    }

    public function openCursor() {
        return $this->con->openCursor($this->table);
    }

    public function add($cur) {
        $cur->insert();
    }

    public function update($id, $cur) {
        $cur->update('WHERE tag_id = \''.$this->con->escape($id).'\'');

        return $cur;
    }

    public function findById($id) {
        $strReq =  'SELECT distinct(meta_id), tag_id, tag_desc, tag_title';
        $strReq .= ' FROM '.$this->foreign_table.' AS m';
        $strReq .= ' LEFT JOIN '.$this->table.' AS td ON td.tag_id=m.meta_id';
        $strReq .= ' WHERE meta_id=\''.$this->con->escape($id).'\'';
        $strReq .= ' AND m.meta_type=\'tag\'';

        $rs = $this->con->select($strReq);
        $rs = $rs->toStatic();

        return $rs;
    }

    public function getList(array $limit=array()) {
        $strReq =  'SELECT distinct(meta_id), tag_desc, tag_title';
        $strReq .= ' FROM '.$this->foreign_table.' AS m';
        $strReq .= ' LEFT JOIN '.$this->table.' AS td ON td.tag_id=m.meta_id';
        $strReq .= ' WHERE m.meta_type=\'tag\'';
        $strReq .= ' ORDER BY tag_id ASC';

        if (!empty($limit)) {
			$strReq .= $this->con->limit($limit);
        }

        $rs = $this->con->select($strReq);
        $rs = $rs->toStatic();

        return $rs;
    }

    public function getcountList() {
        $strReq =  'SELECT count(meta_id)';
        $strReq .= ' FROM '.$this->foreign_table.' AS m';
        $strReq .= ' LEFT JOIN '.$this->table.' AS td ON td.tag_id=m.meta_id';
        $strReq .= ' WHERE m.meta_type=\'tag\'';

        $rs = $this->con->select($strReq);
        $rs = $rs->toStatic();

        return $rs->f(0);
    }

    public function getAll() {
        $strReq =  'SELECT '.implode(',', $this->fields);
        $strReq .= ' FROM '.$this->table.' AS td';
        $strReq .= ' LEFT JOIN '.$this->foreign_table.' AS m ON td.tag_id=m.meta_id';
        $strReq .= ' WHERE m.meta_type=\'tag\'';
        $strReq .= ' GROUP BY m.post_id';

        if (!empty($limit)) {
			$strReq .= $this->con->limit($limit);
        }

        $rs = $this->con->select($strReq);
        $results = array();
        while ($rs->fetch()) {
            $results[$rs->tag_id] = array(
                'description' => $rs->tag_desc,
                'title' => $rs->tag_title ? $rs->tag_title : $rs->tag_id
            );
        }

        return $returndescriptions;
    }
}