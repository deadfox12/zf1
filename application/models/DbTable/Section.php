<?php

class Application_Model_DbTable_Section extends Zend_Db_Table_Abstract{
    protected $_name = 'section';

    public function getSection($id)
    {

        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);

        if(!$row) {

            throw new Exception("Нет записи с id - $id");

        }
        return $row->toArray();

    }

    public function addSection($section)
    {
        $data = array(

            'section' => $section,

        );
        $this->insert($data);
    }
    public  function updateSection($id, $section)
    {
        $data = array(

            'section' => $section,
        );
        $this->update($data, 'id = ' . (int)$id);

    }


    public function deleteSection($id)

    {
        $this->delete('id = ' . (int)$id);
        $this->_db->query("DELETE FROM recept WHERE sectionid=".(int)$id);

    }

    public function getSectionList()
    {
        $list = new Application_Model_DbTable_Section();
        return $list->fetchAll();
    }

}