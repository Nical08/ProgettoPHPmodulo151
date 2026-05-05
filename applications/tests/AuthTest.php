<?php

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    protected function setUp(): void
    {
        if (Auth::isLoggedIn()) Auth::logout();
    }

    public function testLoginSuccessAdmin()
    {
        $result = Auth::login('admin@ti.ch', 'Password&1');
        $this->assertEquals('admin', $result);
        $this->assertTrue(Auth::isLoggedIn());
        $this->assertEquals('admin', Auth::getRuolo());
    }

    public function testLoginSuccessDipendente()
    {
        $result = Auth::login('marco@test.com', 'password');
        $this->assertEquals('dipendente', $result);
    }

    public function testLoginWithWrongCredentials()
    {
        $result = Auth::login('wrong@email.com', 'wrongpass');
        $this->assertFalse($result);
        $this->assertFalse(Auth::isLoggedIn());
    }

    public function testLoginWithEmptyFields()
    {
        $result = Auth::login('', '');
        $this->assertFalse($result);
    }

    public function testLogout()
    {
        Auth::login('admin@ti.ch', 'Password&1');
        $this->assertTrue(Auth::isLoggedIn());
        Auth::logout();
        $this->assertFalse(Auth::isLoggedIn());
        $this->assertNull(Auth::getRuolo());
    }

    public function testGetUserInfo()
    {
        Auth::login('admin@ti.ch', 'Password&1');
        $this->assertEquals('Admin', Auth::getUserNome());
        $this->assertEquals('admin@ti.ch', Auth::getUserEmail());
        $this->assertEquals('DIPENDENTE', Auth::getUserTable());
    }

    public function testRedirectIfNotLoggedIn()
    {
        Auth::logout();
        $this->assertFalse(Auth::isLoggedIn());
    }
}
