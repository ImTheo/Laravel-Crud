<?php

namespace App\Http\Controllers;

use App\Events\PostRegistered;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::paginate(5);
        $posts = Cache::remember('posts-page-'.request("page",1), 60, function () {
            return Post::with('category')->paginate(5);
        });
        return view('index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Post::class);
        $categories = Category::all();
        return view('create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Post::class);

        $request->validate([
            'title' => 'required',
            'category_id' => 'required_without:null',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required'
        ]);
        
        $postData = $request->all();
        
        if ($request->hasFile('image')) {
            $postData['image'] = $request->file('image')->store('images','public');
        }
        
        Post::create($postData);
        
        //forget cache
        Cache::flush();
        event(new PostRegistered(Post::latest()->first()));
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update',[Post::class,$post]);
        $categories = Category::all();
        return view('edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update',[Post::class,$post]);
        $request->validate([
            'title' => 'required',
            'category_id' => 'required_without:null',
            'description' => 'required'
        ]);
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            //delete old image from storage
            $image_path = public_path().'/storage/'.$post->image;
            unlink($image_path);
            //upload new image
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('storage/images'),$imageName);
            $post->image = 'images/'.$imageName;
        }
        $post->title = $request->get('title');
        $post->category_id = $request->get('category_id');
        $post->description = $request->get('description');
        $post->save();
        //forget cache
        Cache::forget('posts-page-'.request("page",1));
        return redirect()->route('posts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete',[Post::class,$post]);
        $post->delete();
        //forget cache
        Cache::flush();
        //refresh page
        return redirect()->route('posts.index');
    }

    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete',[Post::class,$post]);
        $post->forceDelete();
        //delete image from storage
        $image_path = public_path().'/storage/'.$post->image;
        unlink($image_path);
        //forget cache
        Cache::flush();
        return redirect()->route('posts.trashed');
    }

    public function restore(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $this->authorize('restore',[Post::class,$post]);
        $post->restore();
        //forget cache from trashed and update index
        Cache::flush();
        return redirect()->route('posts.index');
    }


    public function trashed()
    {
        $this->authorize('viewTrashed',Post::class);
        //$posts = Post::onlyTrashed()->paginate(10);
        $posts = Cache::remember('posts-trashed-page-'.request("page",1), 60, function () {
            return Post::onlyTrashed()->with('category')->paginate(5);
        });
        return view('trashed',compact('posts'));

    }


}
