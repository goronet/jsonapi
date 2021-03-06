<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $sortFields = Str::of(request('sort'))->explode(',');
        $articleQuery = Article::query();

        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (Str::of($sortField)->startsWith('-')) {
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }
            $articleQuery->orderBy($sortField, $direction);
        }

        return ArticleCollection::make($articleQuery->get());
    }

    public function show(Article $article)
    {
        return ArticleResource::make($article);
    }
}
