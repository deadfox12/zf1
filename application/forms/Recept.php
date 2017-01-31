<?php

class Application_Form_Recept extends Zend_Form
{

    public function init()
    {

        $this->setName('recept');

        // Создаём элемент hidden c именем = id
        $id = new Zend_Form_Element_Hidden('id');
        // Данные фильтруются как число int
        $id->addFilter('Int');

        // Создаём переменную, которая будет хранить сообщение валидации
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';

        // Создаём элемент формы – text c именем = title
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Название рецепта')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage)));

        // Создаём элемент формы – text c именем = text
        $text = new Zend_Form_Element_Text('text');
        $text->setLabel('Рецепт')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage)));

        // Создаём элемент формы – text c именем = sectionid
        $sectionid = new Zend_Form_Element_Text('sectionid');
        $sectionid->setLabel('Категория рецепта')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage)));
        $section_list=new Application_Model_DbTable_Section();
        $section_list->getSectionList();
        /*$section = new Zend_Form_Element_Multiselect('section');
        $section->setLabel('Категории');
        */
        // Создаём элемент формы Submit c именем = submit
        $submit = new Zend_Form_Element_Submit('submit');
        // Создаём атрибут id = submitbutton
        $submit->setAttrib('id', 'submitbutton');

        // Добавляем все созданные элементы к форме.
        $this->addElements(array($id, $title, $text, $sectionid, $submit));

    }
}
