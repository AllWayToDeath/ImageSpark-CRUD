<?php

namespace Controllers;

use Core\Router;
use Core\View;
use Controllers\DataController;
use Form\Builder;
use Form\UserForm;
use Models\UserModel;

class UserController
{
    protected $modelClass = UserModel::class;

    public function print()
    {
        $userList = UserModel::getAll();
        //View::render("users", ["userList" => $userList]);
        $output = View::render("users", ["userList" => $userList]);
        echo $output;
    }

    public function editOrCreate()
    {
        $id = Router::getVar("id");

        //Edit&Create
        $form = new UserForm();

        $form->setModel(UserModel::class);
        $form->loadFromModel($id);

        if($form->isSubmitted() 
            && $form->isValid() 
            && $form->save($id))
        {
            header("Location: /users");
            return;
        }
        $form->render();
    }

    public function delete()
    {
        $id = Router::getVar("id");
        UserModel::delete($id);
        header("location: /users");
    }
}