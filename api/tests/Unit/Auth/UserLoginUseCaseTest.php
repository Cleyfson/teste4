<?php

namespace Tests\Unit;

use App\Application\UseCases\Auth\UserLoginUseCase;
use App\Domain\Entities\User;
use Tests\Mocks\UserRepositoryMock;
use Tests\TestCase;

class UserLoginUseCaseTest extends TestCase
{
    private UserRepositoryMock $userRepositoryMock;
    private UserLoginUseCase $UserLoginUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->userRepositoryMock = new UserRepositoryMock();
        $this->UserLoginUseCase = new UserLoginUseCase($this->userRepositoryMock);
        
        $this->userRepositoryMock->save(
            (new User())
                ->setName('Test User')
                ->setEmail('test@example.com')
                ->setPassword(bcrypt('correct_password'))
        );
    }

    public function test_login_with_valid_credentials_returns_token()
    {
        $token = $this->UserLoginUseCase->execute(
            'test@example.com',
            'correct_password'
        );

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
        
        $parts = explode('.', $token);
        $this->assertCount(3, $parts);
    }

    public function test_login_with_wrong_password_throws_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $this->UserLoginUseCase->execute(
            'test@example.com',
            'wrong_password'
        );
    }

    public function test_login_with_nonexistent_email_throws_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $this->UserLoginUseCase->execute(
            'nonexistent@example.com',
            'any_password'
        );
    }

    protected function tearDown(): void
    {
        $this->userRepositoryMock->clear();
        parent::tearDown();
    }
}