<?php

class Application_Form_Section extends Zend_Form
{

    public function init()
    {

        $this->setName('section');

        // Создаём элемент hidden c именем = id
        $id = new Zend_Form_Element_Hidden('id');
        // Данные фильтруются как число int
        $id->addFilter('Int');

        // Создаём переменную, которая будет хранить сообщение валидации
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';

        // Создаём элемент формы – text c именем = section
        $section = new Zend_Form_Element_Text('section');
        $section->setLabel('Категория')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        // Создаём элемент формы Submit c именем = submit
        $submit = new Zend_Form_Element_Submit('submit');
        // Создаём атрибут id = submitbutton
        $submit->setAttrib('id', 'submitbutton');

        // Добавляем все созданные элементы к форме.
        $this->addElements(array($id, $section, $submit));
    }
}
