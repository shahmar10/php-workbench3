<?php


namespace App\core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';

    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if( property_exists($this,$key) ){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules() :array;

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $rule_name = $rule;
               if(!is_string($rule_name)){
                   $rule_name = $rule[0];
               }
               if($rule_name === self::RULE_REQUIRED && !value){
                   $this->addError($attribute, self::RULE_REQUIRED);
               }
            }
        }
    }

    public function addError(string $attribute, string $rule)
    {
        $message = $this->errorMessages()[$rule] ?? '';
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'Bu boş ola bilməz',
            self::RULE_EMAIL => 'Email adresini doğru daxil edin',
            self::RULE_MIN => 'Minimum {min} rəqəmdən ibarət ola bilər',
            self::RULE_MAX => 'Maximum {max} rəqəmdən ibarət ola bilər',
            self::RULE_MATCH => '{match} doğrulanması yanlışdır!'
        ];
    }
}