<?php
class users{

var $name;
var $email;

 private function __construct($value, $value2)
    {
        $this->name = $value;
        $this->email = $value2;
    }

 function Login(){
     // code 
     echo 'Login';
 }


}
$writer = new users('Writer Account (Writer)', 'w@w.com');









?>