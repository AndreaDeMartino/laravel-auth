@extends('layouts.admin')

@section('content')
  <div class="container">
    <h1>Edit {{ $post->title }}</h1>


    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>

    @endif


    <form action="{{ route('admin.posts.update',$post->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method("PATCH")
    
      <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control" type="text" name="title" id="title" value="{{ old('title',$post->title) }}">
      </div>

      <div class="form-group">
        <label for="body">Body</label>
        <textarea class="form-control" name="body" id="body"> {{ old('post',$post->body) }}</textarea>
      </div>

      <div class="form-group">
        <label class="d-block" for="path_img">Post Image</label>
        {{-- Accept, è una verifica frontend per scegliere immagini --}}
        @isset($post->path_img)
          <img style="height: 300px" src="{{ asset('storage/' . $post->path_img) }}" alt="{{ $post->name }}">
          <h6 class="my-3">Change</h6>
        @endisset
        <input class="form-control" type="file" name="path_img" id="path_img" accept="image/*">
      </div>

      <input class="btn btn-success" type="submit" value="UPDATE">
      
    </form>
  </div>
@endsection
