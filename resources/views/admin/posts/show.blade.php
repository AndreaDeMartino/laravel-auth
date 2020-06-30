@extends('layouts.admin')

@section('content')
  <div class="container">
    
    <h1 class="display-4 my-5">Post Archive</h1>
    <table class="table">
      <thead>
          <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Body</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
          </tr>
      </thead>

      <tbody>

          <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->body }}</td>
            <td>{{ $post->created_at }}</td>
            <td>{{ $post->updated_at }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('admin.posts.edit', $post->slug) }}">Edit</a>
            </td>
            <td>
              <form action="{{ route('admin.posts.destroy',$post->slug) }}" method="post">
                @csrf
                @method('delete')
 
                <input class="btn btn-danger" type="submit" value="DELETE">
              </form>
            </td>
          </tr>

      </tbody>
      
    </table>


    <h3 class="mb-4">Post Image</h3>

    @if (!empty($post->path_img))
      <img src="{{ asset('storage/' . $post->path_img) }}" alt="{{ $post->name }}">
    @else
      <div class="alert alert-danger">No Image for this post</div>
    @endif
  </div>
@endsection
