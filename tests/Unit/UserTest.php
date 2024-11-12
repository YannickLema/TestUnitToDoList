<?php
namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserIsValid()
    {
        $user = new User([
            'email' => 'test@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'password' => 'Password123',
            'birthdate' => '2000-01-01'
        ]);

        $this->assertTrue($user->isValid());
    }
}
