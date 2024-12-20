<?php

namespace Azuriom\Plugin\Wiki\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Wiki\Models\Category;
use Azuriom\Plugin\Wiki\Models\Page;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class CategoryPageController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Category $category, Page $page)
    {
        $this->authorize('view', $category);

        abort_if(! $category->is_enabled && ! Gate::allows('wiki.admin'), 403);

        $page->load([
            'category.pages',
            'category.categories' => fn (Builder $q) => $q->scopes('enabled'),
        ]);

        return view('wiki::pages.show', ['page' => $page]);
    }
}
