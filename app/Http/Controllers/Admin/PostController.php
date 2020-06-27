<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
// Import per utizzare funzioni per autenticazione Auth
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Filtro su post utenticato
        $posts = Post::where('user_id',Auth::id())->orderBy('created_at', 'desc')->paginate(6);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules());
        $data = $request->all();

        // Prendo dati e aggiungo slug e user
        $newPost = new Post();
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'],'-');

        $newPost->fill($data);

        $saved = $newPost->save();

        if($saved){
            return redirect()->route('admin.posts.show',$newPost->slug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug',$slug)->first();

        if (empty($post)) {
            abort(404);
        }

        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug',$slug)->first();

        if (empty($post)) {
            abort(404);
        };

        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validationRules());

        $data = $request->all();

        $data['slug'] = Str::slug($data['title'],'-');

        $updated = $post->update($data);

        if ($updated){
            return redirect()->route('admin.posts.show',$post->slug);
        };

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::where('slug',$slug)->first();

        if (empty($post)){
            abort(404);
        };

        $title = $post->title;

        $deleted = $post->delete();

        if ($deleted){
            return redirect()->route('admin.posts.index')->with('post-deleted',$title);
        }
    }

    // Validation rules
    private function validationRules(){
        return [
            'title' => 'required',
            'body' => 'required'
        ];
    }
}
