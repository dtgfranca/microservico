<?php
namespace App\Types;

use Exception;
use InvalidArgumentException;

class Email
{
    private $email;

    public function __construct($email)
    {   $this->email =  $email;
        if(!$this->valid()) {
            throw new InvalidArgumentException('O e-mail é inválido', 422);
        }

    }
    public function valid()
    {
        return !!filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }
    public function __toString()
    {
        return $this->email;
    }
}
