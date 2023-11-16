@extends('layouts.master')

@section('content')

<div class="main-content mt-5">
    <div class="card">
        <div class="card-header">
          <div class="row">

            <div class="col-md-6">
              <h4>Trashed Posts</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <a class="btn btn-success mx-1" href="{{route('posts.index')}}">Back</a>
            </div>

          </div>


        </div>
    
        <div class="card-body">
            <table class="table table-striped table-bordered border-dark">
                <thead style="background: #f2f2f2">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="width: 10%">Image</th>
                    <th scope="col" style="width: 20%">Title</th>
                    <th scope="col" style="width: 30%">Description</th>
                    <th scope="col" style="width: 10%">Category</th>
                    <th scope="col" style="width: 10%">Publish Date</th>
                    <th scope="col" style="width: 20%">Action</th>


                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post)          
                  <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>
                        <img src="{{asset('storage/'.$post->image)}}" alt="" width="80">
                    </td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->description}}</td>
                    <td>{{$post->category->title}}</td>
                    <td>{{date('d-m-Y', strtotime($post->created_at))}}</td>
                    <td>
                        <div class="d-flex">
                          @can('restore',$post)
                            <a class="btn-sm btn-success btn" href="{{route('posts.restore',$post->id)}}">Restore</a>                        
                          @endcan
                          <form action="{{route('posts.force_delete', $post->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            @can('forceDelete', $post)
                              <button class="btn-sm btn-danger btn">Delete permanently</button>
                            @endcan
                          </form>
                        </div>

                    </td>

                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
              {{$posts->links()}}
        </div>
    </div>
</div>

@endsection