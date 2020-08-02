<?php

namespace App\Modules\Search;

use App\KeyboardLayoutConverter;
use App\Models\Article\Article;

class ArticleSearch
{
    public static function applyFilters(\Illuminate\Http\Request $request)
    {
        $q = Article::query();

        if ($request->has('query')) {
            $q->where(function ($q) {
                $q->like(request()->input('query'))
                    ->orWhere(function ($q) {
                        $q->like(
                            KeyboardLayoutConverter::convert(request()->input('query'))
                        );
                    });
            });
        }

        if ($request->has('category')) {
            $q->inCategory($request->category);
        }

        if ($request->has('markers_of')) {
            $q->markedBy(request('markers_of'));
        }

        return $q;
    }
}
