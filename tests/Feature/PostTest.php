<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    // refresa bazu za svaki test(metodu)
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostsWhenNothingInDatabase()
    {
        // ARRANGE
        // ACT
        // ASSERT

        $response = $this->get('/posts');

        $response->assertSeeText('No blog posts yet!');
    }

    public function testSee1BlogPostWhereThereIsOne() {
        // ARRANGE
        $post = $this->createDummyBlogPost();

        // ACT
        $response = $this->get('/posts');

        // ASSERT
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);
    }

    public function testSee1BlogPostWithComments() {
        // ARRANGE
        $post = $this->createDummyBlogPost();
        factory(Comment::class, 4)->create([
            'blog_post_id' => $post->id
        ]);

        // ACT
        $response = $this->get('/posts');

        $response->assertSeeText('4 Comments');
    }

    public function testStoreValid() {

        // $user = $this->user();

        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        // treathed like its auth..
        // $this->actingAs($user);

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was created!');
    }

    public function testStoreFail() {

        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');

    }

    public function testUpdateValid() {
        // ARRANGE
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            "title" => "New Title",
            "content" => "Content of the blog post"
        ]);

        $params = [
            "title" => "Updated title",
            "content" => "This is updated content"
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was Updated!');

        $this->assertDatabaseMissing('blog_posts', [
            "title" => "New Title",
            "content" => "Content of the blog post"
        ]);

        $this->assertDatabaseHas('blog_posts', [
            "title" => "Updated title",
            "content" => "This is updated content"
        ]);
    }

    public function testDelete() {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
            'content' => 'Content of the blog post'
        ]);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was Deleted!');
        // $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertSoftDeleted('blog_posts', [
        'title' => 'New Title',
        'content' => 'Content of the blog post'
    ]);
    }

    private function createDummyBlogPost($userId = null) : BlogPost {
        // ARRANGE
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        return factory(BlogPost::class)->state('new-title')->create(
            [
                // ako nije null koristi prvi ak je koristi drugi
                'user_id' => $userId ?? $this->user()->id
            ]
        );

        // return $post;
    }
}
