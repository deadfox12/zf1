<?php

class ReceptController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $recepts = new Application_Model_DbTable_Recept();
        $this->view->recept = $recepts->FetchAll();
    }

    public function addAction()
    {
        // Создаём форму
        $form = new Application_Form_Recept();

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
                $title = $form->getValue('title');

                $text = $form->getValue('text');

                $sectionid = $form->getValue('sectionid');

                $recepts = new Application_Model_DbTable_Recept();
                $recepts->addRecept($title, $text, $sectionid);
                $this->_helper->redirector('index');
            } else {
                // Если форма заполнена неверно,
                // используем метод populate для заполнения всех полей
                // той инфомацией, которую ввёл пользователь
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        // Создаём форму
        $form = new Application_Form_Recept();

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

                $title = $form->getValue('title');

                $text = $form->getValue('text');

                $sectionid = $form->getValue('sectionid');

                $sections = new Application_Model_DbTable_Recept();
                $sections->updateRecept($id, $title, $text, $sectionid);

                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {

            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                // Создаём объект модели
                $section = new Application_Model_DbTable_Recept();

                // Заполняем форму информацией при помощи метода populate
                $form->populate($section->getRecept($id));
            }
        }
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Да') {
                $id = $this->getRequest()->getPost('id');
                $recept = new Application_Model_DbTable_Recept();
                $recept->deleteRecept($id);
            }

            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id');

            $recept = new Application_Model_DbTable_Recept();
            $this->view->recept = $recept->getRecept($id);
        }
    }

    public function viewAction()
    {
        $recept = new Application_Model_DbTable_Recept();
        $id = $this->getRequest()->getParam('id');
        $res = $recept->getRecept($id);
        $this->view->recept = $res;
    }

    public function searchAction()
    {
        if ($this->getRequest()->isPost()) {
            $query = $this->getRequest()->getParam('query');
            //$query= trim($query);
            $search = new Application_Model_DbTable_Recept();
            $res=$search->searchRecept($query);
            $this->view->recept=$res;
        }

    }

}

