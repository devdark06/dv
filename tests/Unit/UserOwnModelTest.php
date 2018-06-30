<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;

class UserOwnModelTest extends TestCase
{
    use RefreshDatabase;
    
    function test_user_owns_a_model()
    {
        $userA = $this->createUser();
        $userB = $this->createUser();

        $ownByUserA = new OwnedModel(['user_id' => $userA->id]);
        $ownByUserB = new OwnedModel(['user_id' => $userB->id]);

        $this->assertTrue($userA->owns($ownByUserA));
        $this->assertTrue($userB->owns($ownByUserB));

        $this->assertFalse($userA->owns($ownByUserB));
        $this->assertFalse($userB->owns($ownByUserA));
    }
}

class OwnedModel extends Model
{
    protected $guarded = [];
}
