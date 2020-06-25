@extends('layouts.app')

@section('content')
<div class="container flex-column">
    <h1 class="mt-3 mb-5 text-center display-4">Posts Archive</h1>

    <div class="row">
      @foreach($posts as $post)
      <article class="col-6">
        <h2 class="text-primary">{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
      </article>
      @endforeach
    </div>

    <div class="pagination d-flex justify-content-end mt-5">
      {{ $posts->links() }}
    </div>
</div>
@endsection
