<?php
/**
 * Created by PhpStorm.
 * User: Апчхи
 * Date: 14.11.2018
 * Time: 20:35
 */

namespace App\Services;


use Respect\Validation\Validator;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class Checking
{
    private $imageManager;
    private $validator;

    public function __construct(ImageManager $imageManager, Validator $validator)
    {
        $this->imageManager = $imageManager;
        $this->validator = $validator;
    }

    public function checkNotBot($check)
    {
        if($check!= NULL){
            flash()->error(['Вы БОТ!!!']);
            return back();
            exit();
        }
    }

    public function captcha($recaptcha)
    {
        if (isset($recaptcha)) {
            $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";
            $secret_key = '6LdBcXoUAAAAALg7RgnoqyWfg4W6it4MxfyQA7Jj';
            $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $recaptcha . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
            $data = json_decode(file_get_contents($query));
            if ($data->success) {
                // Продолжаем работать с данными для авторизации из POST массива
            } else {
                flash()->success(['Вы не прошли валидацию reCaptcha']);
                return back();
            }
        } else {
            flash()->errors(['Вы бот']);
            exit;
        }
    }

    public function checkImage($photos)
    {
        if ($photos['image']{'name'}!= NULL){
            $validator = v::keyNested('image.tmp_name', v::image());
            $this->validate($validator, $photos, [
                'image' =>  'Неверный формат картинки'
            ]);
            $image = $this->imageManager->uploadImage($photos['image']);
        }
        else{
            $image = 'NULL';
            return $image;
        }
        return $image;
    }

    private function validate($validator, $data, $message)
    {

        try {
            $validator->assert($data);
        }
        catch (ValidationException $exception) {
            flash()->error($exception->findMessages($message));

            return back();
        }
    }

}
