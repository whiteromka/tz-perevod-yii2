<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\UserService;
use common\repositories\UserRepository;
use common\models\User;

/**
 * Тесты для сервиса пользователей
 */
class UserServiceTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @var UserRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    private $repositoryMock;

    /**
     * @var UserService
     */
    private $service;

    protected function _before()
    {
        // Создаём мок репозитория
        $this->repositoryMock = $this->createMock(UserRepository::class);
        $this->service = new UserService($this->repositoryMock);
    }

    /**
     * Тест: успешное создание пользователя
     *
     * @return void
     */
    public function testCreateUserSuccess(): void
    {
        $username = 'testuser';
        $email = 'test@example.com';
        $password = 'password123';

        // Ожидаем, что пользователь не существует
        $this->repositoryMock
            ->expects($this->once())
            ->method('existsByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(false);

        // Создаём мок пользователя с методами для получения свойств
        $userMock = $this->createMock(User::class);
        $userMock->method('getAttribute')->willReturnCallback(function ($attribute) use ($username, $email) {
            return $attribute === 'username' ? $username : ($attribute === 'email' ? $email : null);
        });
        $userMock->username = $username;
        $userMock->email = $email;

        // Ожидаем вызов create() с правильными параметрами
        $this->repositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($username, $email, $password)
            ->willReturn($userMock);

        $result = $this->service->createUser($username, $email, $password);

        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * Тест: создание пользователя с существующим email
     *
     * @return void
     */
    public function testCreateUserWithExistingEmail(): void
    {
        $username = 'testuser';
        $email = 'existing@example.com';
        $password = 'password123';

        // Ожидаем, что пользователь существует
        $this->repositoryMock
            ->expects($this->once())
            ->method('existsByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(true);

        // Ожидаем исключение
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Пользователь с таким email или username уже существует');

        // create() не должен быть вызван
        $this->repositoryMock
            ->expects($this->never())
            ->method('create');

        $this->service->createUser($username, $email, $password);
    }

    /**
     * Тест: создание пользователя с существующим username
     *
     * @return void
     */
    public function testCreateUserWithExistingUsername(): void
    {
        $username = 'existinguser';
        $email = 'new@example.com';
        $password = 'password123';

        // Ожидаем, что пользователь существует
        $this->repositoryMock
            ->expects($this->once())
            ->method('existsByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(true);

        // Ожидаем исключение
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Пользователь с таким email или username уже существует');

        // create() не должен быть вызван
        $this->repositoryMock
            ->expects($this->never())
            ->method('create');

        $this->service->createUser($username, $email, $password);
    }

    /**
     * Тест: создание пользователя с пустым username
     *
     * @return void
     */
    public function testCreateUserWithEmptyUsername(): void
    {
        $username = '';
        $email = 'test@example.com';
        $password = 'password123';

        $this->repositoryMock
            ->expects($this->once())
            ->method('existsByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(false);

        $userMock = $this->createMock(User::class);
        $userMock->username = $username;
        $userMock->email = $email;

        $this->repositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($username, $email, $password)
            ->willReturn($userMock);

        $result = $this->service->createUser($username, $email, $password);

        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * Тест: создание пользователя со сложным паролем
     *
     * @return void
     */
    public function testCreateUserWithComplexPassword(): void
    {
        $username = 'secureuser';
        $email = 'secure@example.com';
        $password = 'Str0ng_P@ssw0rd!';

        $this->repositoryMock
            ->expects($this->once())
            ->method('existsByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(false);

        $userMock = $this->createMock(User::class);
        $userMock->username = $username;
        $userMock->email = $email;

        $this->repositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($username, $email, $password)
            ->willReturn($userMock);

        $result = $this->service->createUser($username, $email, $password);

        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * Тест: порядок вызовов методов репозитория
     *
     * @return void
     */
    public function testRepositoryMethodsCallOrder(): void
    {
        $username = 'orderuser';
        $email = 'order@example.com';
        $password = 'password';

        // Сначала проверяем существование
        $this->repositoryMock
            ->expects($this->once())
            ->method('existsByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(false)
            ->will($this->returnValue(false));

        // Потом создаём
        $userMock = $this->createMock(User::class);
        
        $this->repositoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($userMock);

        $result = $this->service->createUser($username, $email, $password);

        $this->assertInstanceOf(User::class, $result);
    }
}
