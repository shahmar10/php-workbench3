<?php


namespace App\models;


use App\core\Model;

class RegisterModel extends Model
{
    public string $name;
    public string $email;
    public string $password;
    public string $passwordConfirm;

    public function register()
    {
        return "Creating new user";
    }

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN,'min'=>8] ],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']]
        ];
    }
}