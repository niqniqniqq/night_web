<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use App\Models\CastBlog;
use App\Services\CastService;
use Illuminate\View\View;

class CastBlogController extends Controller
{
    public function __construct(
        private readonly CastService $castService,
    ) {}

    public function index(Cast $cast): View
    {
        $cast = $this->castService->getCastWithDetails($cast);
        $blogs = $this->castService->getCastBlogs($cast);

        return view('cast.blogs', compact('cast', 'blogs'));
    }

    public function show(Cast $cast, CastBlog $blog): View
    {
        $blog = $this->castService->getBlogWithDetails($blog);
        $this->castService->incrementBlogViewCount($blog);

        $recentBlogs = $this->castService->getRecentBlogs($cast, $blog->id);

        return view('cast.blog-show', compact('cast', 'blog', 'recentBlogs'));
    }
}
