<?php

namespace Tests\Unit;

use App\Application\UseCases\Auth\RegisterUserUseCase;
use App\Domain\Entities\User;
use Tests\Mocks\UserRepositoryMock;
use Tests\TestCase;

class RegisterUserUseCaseTest extends TestCase
{
    private UserRepositoryMock $userRepositoryMock;
    private RegisterUserUseCase $registerUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->userRepositoryMock = new UserRepositoryMock();
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepositoryMock);
    }

    public function test_register_new_user_successfully()
    {
        $user = $this->registerUserUseCase->execute(
            'John Doe',
            'john@example.com',
            'password123'
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->getName());
        $this->assertEquals('john@example.com', $user->getEmail());
        
        $savedUsers = $this->userRepositoryMock->getUsers();
        $this->assertCount(1, $savedUsers);
        $this->assertEquals('john@example.com', $savedUsers[0]->getEmail());
    }

    public function test_register_with_existing_email_throws_exception()
    {
        $this->registerUserUseCase->execute(
            'Existing User',
            'existing@example.com',
            'password123'
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('E-mail já está em uso.');

        $this->registerUserUseCase->execute(
            'New User',
            'existing@example.com',
            'newpassword'
        );
    }

    protected function tearDown(): void
    {
        $this->userRepositoryMock->clear();
        parent::tearDown();
    }
}