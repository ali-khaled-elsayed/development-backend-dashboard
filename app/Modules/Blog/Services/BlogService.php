<?php

namespace App\Modules\Blog\Services;

use App\Modules\Blog\Repositories\BlogRepository;
use App\Modules\Blog\Requests\ListAllBlogsRequest;
use App\Modules\Blog\Resources\BlogCollection;

class BlogService
{
    public function __construct(private BlogRepository $blogRepository) {}

    public function createBlog($request)
    {
        $blog = $this->constructBlogModel($request);
        return $this->blogRepository->create($blog);
    }

    public function updateBlog($id, $request)
    {
        $blog = $this->constructBlogModel($request);
        return $this->blogRepository->update($id, $blog);
    }

    public function deleteBlog($id)
    {
        return $this->blogRepository->delete($id);
    }

    public function listAllBlogs(array $queryParameters)
    {
        $listAllBlogs = (new ListAllBlogsRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $blogs = $this->blogRepository->findAllBy($listAllBlogs);

        return [
            'data' => new BlogCollection($blogs['data']),
            'count' => $blogs['count']
        ];
    }

    public function getBlogById($id)
    {
        return $this->blogRepository->find($id);
    }

    public function constructBlogModel($request)
    {
        $blogModel = [
            'title_en' => $request['title_en'],
            'title_ar' => $request['title_ar'],
            'description_en' => $request['description_en'],
            'description_ar' => $request['description_ar'],
        ];

        if (isset($request['image'])) {
            $blogModel['image'] = $request['image'];
        }

        return $blogModel;
    }
}
