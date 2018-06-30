<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    function test_admin_can_update_posts()
    {
        $admin = $this->createAdmin();
        $this->be($admin);

        $post = factory(Post::class)->create();

        $result = Gate::allows('update', $post);

        //Resultado
        $this->assertTrue($result);
    }

    function test_unauthorizad_user_cannot_update_posts()
    {
        $user = $this->createUser();
        $this->be($user);

        $post = factory(Post::class)->create();

        $result = Gate::allows('update', $post);

        //Resultado
        $this->assertFalse($result);
    }

    function test_author_can_update_his_posts()
    {
        $user = $this->createUser();
        $this->be($user);
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $result = Gate::allows('update', $post);

        $this->assertTrue($result);
    }

    function test_admin_can_delete_posts()
    {
        $admin = $this->createAdmin();
        $this->be($admin);
        $post = factory(Post::class)->create();
        $result = Gate::allows('delete', $post);
        $this->assertTrue($result);
    }

    function test_user_cannot_delete_posts()
    {
        $user = $this->createUser();
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $this->assertFalse(Gate::forUser($user)->allows('delete', $post));
    }
}
