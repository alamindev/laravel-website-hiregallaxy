<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\PostTag;
use App\Models\SavedPost;
use App\Models\Tag;
use Illuminate\Http\Request;
use Session;

class TagController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    Tag list

     */

    public function index()
    {

        $tags = Tag::orderBy('name', 'DESC')->get();

        return view('backend.pages.tag.index', compact('tags'));

    }

    /*

    Tag add form

     */

    public function create()
    {

        return view('backend.pages.tag.add');

    }

    /*

    Tag save

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',

        ]);

        $tag = new Tag;

        $tag->name = $request->name;

        $tag->slug = StringHelper::createSlug($request->name, 'Tag', 'slug');

        $tag->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'website-images/tag');

        $tag->description = $request->description;

        $tag->save();

        session()->flash('success', 'Tag added successfully');

        return redirect()->route('admin.tag.index');

    }

    /*

    Tag edit form

     */

    public function edit($slug)
    {

        $tag = Tag::where('slug', $slug)->first();

        if ($tag) {

            return view('backend.pages.tag.edit', compact('tag'));

        } else {

            return redirect()->route('admin.tag.index');

        }

    }

    /*

    Tag update

     */

    public function update(Request $request, $slug)
    {

        $tag = Tag::where('slug', $slug)->first();

        if ($tag) {

            $this->validate($request, [

                'name' => 'required',

                'slug' => 'required|unique:tags,slug,' . $tag->id,

            ]);

            $tag->name = $request->name;

            if ($request->image) {

                if ($tag->image) {

                    $tag->image = ImageUploadHelper::update('image', $request->file('image'), time(), 'website-images/tag', $tag->image);

                } else {

                    $tag->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'website-images/tag');

                }

            }

            $tag->description = $request->description;

            $tag->slug = StringHelper::createSlug($request->slug, 'Tag', 'slug');

            $tag->save();

            session()->flash('success', 'Tag updated successfully');

            return redirect()->route('admin.tag.index');

        } else {

            return redirect()->route('admin.tag.index');

        }

    }

    /*

    Tag delete and also delete all related data of this tag

     */

    public function destroy($slug)
    {

        $tag = Tag::where('slug', $slug)->first();

        if ($tag) {

            if ($tag->image) {

                ImageUploadHelper::delete('website-images/category/' . $tag->image);

            }

            $postTags = PostTag::where('tag_id', $tag->id)->get();

            foreach ($postTags as $postTag) {

                $posts = Post::where('id', $postTag->post_id)->get();

                foreach ($posts as $post) {

                    if ($post->image) {

                        ImageUploadHelper::delete('website-images/posts/' . $post->featured_image);

                        PostCategory::where('post_id', $post->id)->delete();

                        PostLike::where('post_id', $post->id)->delete();

                        PostComment::where('post_id', $post->id)->delete();

                        SavedPost::where('post_id', $post->id)->delete();

                        $post->delete();

                    }

                }

                $postTag->delete();

            }

            $tag->delete();

            session()->flash('error', 'Tag deleted successfully');

            return redirect()->route('admin.tag.index');

        } else {

            return redirect()->route('admin.tag.index');

        }

    }

}
