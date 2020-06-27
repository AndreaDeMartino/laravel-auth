@extends('layouts.admin')

@section('content')
<div class="container">
   
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
               <a class="btn btn-primary" href="#">Edit</a>
            </td>
            <td>
               <a class="btn btn-danger" href="#">Delete</a>
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
