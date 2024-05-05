@extends('layouts.main')

@section('content')


  <div class="row my-4">

    <div class="scheduled-posts-table-data">
      @include('post.scheduled-posts-table-data')
    </div>

    <div class="posts-repeat-table-data">
      @include('post.posts-repeat-table-data')
    </div>

  </div>

@endsection