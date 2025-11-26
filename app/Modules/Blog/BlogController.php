<?php

namespace App\Modules\Blog;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Services\BlogService;
use App\Modules\Blog\Resources\BlogResource;
use App\Modules\Blog\Requests\ListBlogsRequest;
use App\Modules\Blog\Requests\CreateBlogRequest;
use App\Modules\Blog\Requests\UpdateBlogRequest;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;

class BlogController extends Controller
{
    public function __construct(private BlogService $blogService) {}

    public function createBlog(CreateBlogRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $data['image'] = $path;
        }
        $blog = $this->blogService->createBlog($data);
        return successJsonResponse(new BlogResource($blog), __('blog.success.create_blog'));
    }

    public function updateBlog($id, UpdateBlogRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blogs', 'public');
            $data['image'] = $path;
        }
        $blog = $this->blogService->updateBlog($id, $data);
        return successJsonResponse(new BlogResource($blog), __('blog.success.update_blog'));
    }

    public function deleteBlog($id)
    {
        $blog = $this->blogService->deleteBlog($id);
        if ($blog == true) {
            return successJsonResponse([], __('blog.success.delete_blog blog_id = ' . $blog['id']));
        } else {
            return errorJsonResponse("There is No blog with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllBlogs(ListBlogsRequest $request)
    {
        $blogs = $this->blogService->listAllBlogs($request->validated());
        return successJsonResponse(data_get($blogs, 'data'), __('blogs.success.get_all_logs'), data_get($blogs, 'count'));
    }

    public function getBlogById($blogId)
    {
        $blog = $this->blogService->getBlogById($blogId);
        if (!$blog) {
            return errorJsonResponse("blog $blogId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new BlogResource($blog), __('blog.success.blog_details'));
    }
}
