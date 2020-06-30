<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
// Import per utizzare funzioni per autenticazione Auth
use Illuminate\Support\Facades\Auth;
// Storage
use Illuminate\Support\Facades\Storage;

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

        // Check su path_img
        if( !empty($data['path_img']) ){
            // Salva il file su disco nella directory images e aggiorna la colonna della tabella path_img
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }
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

        if (!empty($data['path_img'])){
            
            // Delete img precedente
            if (!empty($post['path_img'])){
                Storage::disk('public')->delete($post['path_img']);
            }

            // Set nuova img
            $data['path_img'] = Storage::disk('public')->put('images', $data['path_img']);
        }

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
            // Cancellazione img
            if(!empty($post->path_img)){
                Storage::disk('public')->delete($post->path_img);
            }

            return redirect()->route('admin.posts.index')->with('post-deleted',$title);
        }
    }

    // Validation rules
    private function validationRules(){
        return [
            'title' => 'required',
            'body' => 'required',
            // Validation backend su upload img
            'path_img' => 'image'
        ];
    }
}
