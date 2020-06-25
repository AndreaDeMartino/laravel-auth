<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    function index(){

        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        
        return view('guest.posts.index', compact('posts'));
    }
}
