<?php

namespace App\controllers;


use App\Services\Checking;
use App\Services\Database;
use App\Services\Mail;
use League\Plates\Engine;

class AjaxController
{
    private $view;
    private $database;
    private $mailer;
    private $check;

    public function __construct(Engine $view, Database $database, Mail $mailer, Checking $check)
    {
        $this->view = $view;
        $this->database = $database;
        $this->mailer = $mailer;
        $this->check = $check;
    }

    public function index()
    {
        $email = 'marina@tehotdel.ru';
        $message = "Имя: " . $_POST['username'] . ", почта: " . $_POST['email'];

        $this->check->checkNotBot($_POST['check']);
        $this->check->captcha($_POST['g-recaptcha-response']);
        $image = $this->check->checkImage($_FILES);
        $this->database->create('forms', [
            'username' => $_POST['username'],
            'email' =>  $_POST['email'],
            'image' =>  $image
        ]);
        $this->mailer->send($email, $message);
        flash()->success(['Письмо отправленно']);

        return back();
    }


}