<?php
namespace App\Services;

use App\Types\Email;

class AuthService
{
    /**
     * @param Email $email
     * @param string $password
     * @return string
     */
    public function auth(Email $email, string $password)
    {
        if($email ==='diego.tg.franca@gmail.com' && $password === '123456') {
            return $this->createToken();
        }
        return null;
    }
    /**
     * @return string
     */
    private function createToken()
    {
        return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjcGYiOiIwNzYzNDQ5MzY5NCIsIm5hbWUiOiJEaWVnbyBUaGlhZ28gR3VpbWFyw6NlcyBGcmFuw6dhIiwiaWF0IjoxNTE2MjM5MDIyfQ.97T2kJGpVWx202AwFN8hkOukcEPw4QHEEj8ObijdFjs";
    }
}
