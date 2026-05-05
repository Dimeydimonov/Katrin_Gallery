<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

// проверка ролей
class UserModelTest extends TestCase
{
    public function test_is_admin_returns_true_for_admin_role(): void
    {
        $user = new User(['role' => 'admin']);
        $this->assertTrue($user->isAdmin());
    }

    public function test_is_admin_returns_false_for_user_role(): void
    {
        $user = new User(['role' => 'user']);
        $this->assertFalse($user->isAdmin());
    }

    public function test_has_role_checks_role_correctly(): void
    {
        $user = new User(['role' => 'admin']);
        $this->assertTrue($user->hasRole('admin'));
        $this->assertFalse($user->hasRole('user'));
    }
}
