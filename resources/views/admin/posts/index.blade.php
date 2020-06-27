@extends('layouts.admin')

@section('content')
<div class="container">
   
   @if (session('post-deleted'))
      <div class="alert alert-success">
         <span class="text-muted">Post Delete Successifully:</span>
         <p class="text-primary"> {{ session('post-deleted') }}</p>
      </div>
   @endif

   <h1 class="display-4 my-5">Post Archive</h1>
   <table class="table">
      <thead>
         <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
            <th></th>
         </tr>
      </thead>

      <tbody>
         @foreach($posts as $post)
         <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->created_at }}</td>
            <td>{{ $post->updated_at }}</td>
            <td>
               <a class="btn btn-success" href="{{ route('admin.posts.show',$post->slug) }}">Show</a>
            </td>
            <td>
               <a class="btn btn-primary" href="{{ route('admin.posts.edit',$post->slug) }}">Edit</a>
            </td>
            <td>
               <form action="{{ route('admin.posts.destroy',$post->slug) }}" method="post">
               @csrf
               @method('delete')

               <input class="btn btn-danger" type="submit" value="DELETE">
               </form>
            </td>
         </tr>
         @endforeach
      </tbody>
      
   </table>

   <div class="pagination d-flex justify-content-end mt-5">
      {{ $posts->links() }}
    </div>
</div>
@endsection
