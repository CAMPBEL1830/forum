<?php

require 'Authenticator.php';
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    public function testAuthenticateWithValidCredentials()
    {
        $authenticator = new Authenticator();
        $result = $authenticator->authenticate('validUsername', 'validPassword');
        $this->assertTrue($result);
    }

    public function testRegisterWithValidData()
    {
        $authenticator = new Authenticator();
        $result = $authenticator->register('validUsername', 'validPassword', 'validEmail');
        $this->assertTrue($result);
    }

    public function testRegisterWithInvalidData()
    {
        $authenticator = new Authenticator();
        $result = $authenticator->register('', '', ''); // Les données d'inscription sont vides ici
        $this->assertFalse($result);
    }
    
}
