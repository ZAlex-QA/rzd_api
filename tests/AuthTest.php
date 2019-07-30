<?php

use PHPUnit\Framework\TestCase;
use Rzd\Auth;

class AuthTest extends TestCase
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @throws Exception
     */
    protected function setUp()
    {
        $config = new Rzd\Config();
        $config->setAuth(USERNAME, PASSWORD);

        $this->auth = new Auth($config);
    }

    /**
     * Тест авторизации
     *
     * @runInSeparateProcess
     */
    public function testLogin(): void
    {
        // Проверка авторизации
        if (empty(USERNAME) || empty(PASSWORD)) {
            $this->markTestSkipped('Установите логин и пароль в файле bootstrap.php');
        } else {
            $this->assertTrue($this->auth->login());
        }
    }

    /**
     * Тест получения данных
     *
     * @runInSeparateProcess
     * @throws Exception
     */
    public function testProfile(): void
    {
        $this->auth->login();
        $profile = $this->auth->getProfile();

        if (! $profile) {
            $this->markTestSkipped('Не удалось авторизоваться на сайте');
        } else {

            $profile = json_decode($profile, true);

            $this->assertIsArray($profile);
            $this->assertArrayHasKey('uid', $profile);
        }
    }
}
