<?php

class Application_Model_DbTable_Recept extends Zend_Db_Table_Abstract{
    protected $_name = 'recept';

    public function getRecept($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);

        if(!$row) {

            throw new Exception("Нет записи с id - $id");

        }
        return $row->toArray();
    }


    public function addRecept($title, $text, $sectionid)

    {


        $data = array(

            'title' => $title,
            'text'=> $text,
            'sectionid' => $sectionid,

        );

        $this->insert($data);

    }
    public  function updateRecept($id, $title, $text, $sectionid)

    {
        $data = array(

            'title' => $title,
            'text'=> $text,
            'sectionid' => $sectionid,

        );

        $this->update($data, 'id = ' . (int)$id);

    }

    public function deleteRecept($id)

    {

        $this->delete('id = ' . (int)$id);

    }
    public function searchRecept($query)
    {
        $res=$this->_db->query("
        SELECT * FROM ".$this->_name." WHERE title LIKE '%$query%'
        ");
        return $res->fetchAll();
    }

    public function joinRecept($id)
    {
        $res=$this->_db->query
        ("SELECT * FROM ".$this->_name." WHERE recept.sectionid=". (int)$id);
        return $res->fetchAll();    }
}