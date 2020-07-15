<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
            // ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();
        // $posts = BlogPost::with('comments')->get();

        // foreach($posts as $post) {
        //     foreach($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        // comments_count

        return view(
            'posts.index',
            ['posts' => BlogPost::withTrashed()->withCount('comments')->get()]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $blogPost = BlogPost::create($validatedData);
        $request->session()->flash('status', 'Blog post was created!');

        // uspjesni redirect => status -> 302
        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // keep message for one more request
        // $request->session()->reflash();
        return view('posts.show', ['post' => BlogPost::withTrashed('comments')->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);


        $this->authorize('update', $post);
        // automatski se user passa
        // if(Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit blog post!");
        // }

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illum inate\Http\Response
     */
    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);
        // automatski se user passa
        // if(Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog post!");
        // }

        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status', 'Blog post was Updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // posts.delete ali smo stavitili u policies protected i zbog tog mozemo maknuti posts.
        $this->authorize('delete', $post);

        // isto jedna od solucija
        // $this->authorize($post);

        // automatski se user passa
        // if(Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog post!");
        // }

        $post->delete();

        // BlogPost::destroy($id);

        $request->session()->flash('status', 'Blog post was Deleted!');

        return redirect()->route('posts.index');
    }
}
