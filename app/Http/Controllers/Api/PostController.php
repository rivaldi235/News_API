<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Events\PostCreated;
use App\Events\PostDeleted;
use App\Events\PostUpdated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\DetailPostResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return DetailPostResource::collection($posts->loadMissing(['user:id,name', 'comments:id,post_id,user_id,comment']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,svg'
        ]);

        $image_path = $request->file('image')->store('image', 'public');

        $post = Post::create([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'image' => $image_path,
            'user_id' => $request->user_id,
        ]);

        PostCreated::dispatch($post);

        return new DetailPostResource($post->loadMissing('user:id,name'));
    }

    public function show($id)
    {
        $post = Post::with(['user:id,name', 'comments:id,post_id,user_id,comment'])->findOrFail($id);
        return new DetailPostResource($post);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,svg'
        ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($post->image) {
                // Hapus file gambar lama
                Storage::delete($post->image);
            }

            $image_path = $request->file('image')->store('image', 'public');

            $post->update([
                'title' => $request->title,
                'news_content' => $request->news_content,
                'image' => $image_path,
                'user_id' => $request->user_id,
            ]);

            PostUpdated::dispatch($post);

            return new DetailPostResource($post->loadMissing('user:id,name'));
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            // Hapus file gambar jika ada
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        PostDeleted::dispatch($post);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $post
        ], 200);
    }
}

