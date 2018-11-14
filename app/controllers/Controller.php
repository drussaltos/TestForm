<?php

namespace App\Controllers;



use App\Services\Database;
use App\Services\ImageManager;
use App\Services\Mail;
use League\Plates\Engine;
use Respect\Validation\Validator;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class Controller
{

    private $view;

    public function __construct(Engine $view, Database $database, ImageManager $imageManager, Mail $mailer, Validator $validator)
    {
        $this->view = $view;
        $this->database = $database;
        $this->imageManager = $imageManager;
        $this->mailer = $mailer;
        $this->validator = $validator;
    }

    public function index()
    {
        echo $this->view->render('index');
    }

  /*  public function store()
    {
        if($_POST['protection']!= NULL){
            flash()->error(['Вы БОТ!!!']);
            return back();
            exit();
        }

        $validator = v::keyNested('image.tmp_name', v::image());

        $this->validate($validator, array_merge($_POST, $_FILES), [
            'image' =>  'Неверный формат картинки'
        ]);

        $image = $this->imageManager->uploadImage($_FILES['image']);
        $this->database->create('forms', [
            'username' => $_POST['username'],
            'email' =>  $_POST['email'],
            'image' =>  $image
        ]);

        $email = 'druss.altos@yandex.ru';
        $message = "Имя: " . $_POST['username'] . ", почта: " . $_POST['email'];
        $this->mailer->send($email, $message);
        flash()->success(['Письмо отправленно']);

        return back();
    }

    private function validate($validator, $data, $message)
    {

        try {
            $validator->assert($data);

        } catch (ValidationException $exception) {
            flash()->error($exception->findMessages($message));

            return back();
        }
    }*/
}
