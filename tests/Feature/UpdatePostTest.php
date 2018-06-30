<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    // use RefreshDatabase;

    function test_admin_can_update_all_posts()
    {
        $admin= $this->createAdmin();
        $this->be($admin);

        $post = factory(Post::class)->create();
        $response = $this->put("update/posts/{$post->id}",[
            'title' => 'Im updated',
        ]);
        $response->assertStatus(200)
                 ->assertSee('Post updated');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Im updated',
        ]);
    }

    function test_guest_cannot_update_post()
    {
        $post = factory(Post::class)->create();
        $response = $this->put("update/posts/{$post->id}",[
            'title' => 'Im updated',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Im updated',
        ]);
    }

    function test_user_cannot_update_posts()
    {
        $post = factory(Post::class)->create();

        $user = $this->createUser();
        $this->be($user);
        
        $response = $this->put("update/posts/{$post->id}",[
            'title' => 'Im updated',
        ]);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Im updated',
        ]);
    }

    function test_user_can_update_his_own_posts()
    {
        $user = $this->createUser();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $this->be($user);
        $response = $this->put("update/posts/{$post->id}",[
            'title' => 'Im updated',
        ]);
        $response->assertStatus(200)
                 ->assertSee('Post updated');
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Im updated',
        ]);
    }
}
