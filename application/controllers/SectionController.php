<?php

class SectionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $sections = new Application_Model_DbTable_Section();
        $this->view->section = $sections->FetchAll();
    }

    public function addAction ()
    {
        // Создаём форму
        $form = new Application_Form_Section();

        // Указываем текст для submit
       $form->submit->setLabel('Добавить');

        // Передаём форму в view
        $this->view->form = $form;

        // Post запрос
        if ($this->getRequest()->isPost()) {
            // Принимаем его
            $formData = $this->getRequest()->getPost();

            // Если форма заполнена верно
            if ($form->isValid($formData)) {
                // Извлекаем категорию
                $section = $form->getValue('section');

                $sections = new Application_Model_DbTable_Section();
                $sections->addSection($section);
                $this->_helper->redirector('index');
            } else {
                // Если форма заполнена неверно,
                // используем метод populate для заполнения всех полей
                // той инфомацией, которую ввёл пользователь
                $form->populate($formData);
            }
        }
    }

    public  function editAction()
    {
        // Создаём форму
        $form = new Application_Form_Section();

        // Указываем текст для submit
        $form->submit->setLabel('Сохранить');
        $this->view->form = $form;

        // Если к нам идёт Post запрос
        if ($this->getRequest()->isPost()) {
            // Принимаем его
            $formData = $this->getRequest()->getPost();

            // Если форма заполнена верно
            if ($form->isValid($formData)) {
                // Извлекаем id
                $id = (int)$form->getValue('id');

                // Извлекаем категорию
                $section = $form->getValue('section');

                // Создаём объект модели
                $sections = new Application_Model_DbTable_Section();
                $sections->updateSection($id, $section);

                // Используем библиотечный helper для редиректа на action = index
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {

            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                // Создаём объект модели
                $section = new Application_Model_DbTable_Section();

                // Заполняем форму информацией при помощи метода populate
                $form->populate($section->getSection($id));
            }
        }
}

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Да') {
             $id = $this->getRequest()->getPost('id');
             $section = new Application_Model_DbTable_Section();
             $section->deleteSection($id);}

             $this->_helper->redirector('index');
            } else {
            $id = $this->_getParam('id');

        $section = new Application_Model_DbTable_Section();
        $this->view->section = $section->getSection($id);
        }
    }

    public function viewAction()
    {
        $recept = new Application_Model_DbTable_Recept();
        $id = $this->getRequest()->getParam('id');
        $res = $recept->joinRecept($id);
        $this->view->recept = $res;
    }
}

