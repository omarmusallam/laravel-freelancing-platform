<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\FilterRule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{

    protected $rules = [
        'name' => ['required', 'string', 'between:2,30'],
        'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        'desc' => ['nullable', 'string'],
        'art_path' => ['nullable', 'string', 'max:255'],
        'slug' => ['nullable', 'string', 'max:255'],
    ];

    protected $messages = [
        'name.required' => 'The :attribute Field is Empty'
    ];

    public function index()
    {
        // if (Gate::denies('categories.view')) {
        //     abort(403);
        // }
        //$this->authorize('view-any', Category::class);

        $categories1 = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->paginate(10);

        $title = 'Categories';
        return view('categories.index', compact('categories1', 'title'));
    }

    public function show(Category $category)
    {
        $categories1 = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])
            ->get();

        return view('categories.show', compact('category', 'categories1'));
    }

    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('categories.create', compact('category', 'parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages);
        $data['slug'] = Str::slug(($data['slug'] ?? '') ?: $data['name']);

        Category::create($data);

        return redirect(route('dashboard.categories.index'))
            ->with('success', 'Category Created');
    }

    public function edit(Category $category)
    {
        // $category = Category::findOrFail($id);
        $parents = Category::all();

        return view('categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate($this->rules($category), $this->messages);
        $data['slug'] = Str::slug(($data['slug'] ?? '') ?: $data['name']);

        if (($data['parent_id'] ?? null) === $category->id) {
            return redirect()
                ->back()
                ->withErrors(['parent_id' => 'A category cannot be its own parent.'])
                ->withInput();
        }

        $category->update($data);
        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category Updated');
    }

    public function destroy($id)
    {
        // Category::where('id' , $id)->delete();

        // $category = Category::findOrFail($id);
        // $category->delete();

        Category::destroy($id);

        session()->flash('success', 'Category Deleted');
        return redirect()->route('dashboard.categories.index');
        //->with('success', 'Category Deleted');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('categories.trash', [
            'categories' => $categories,
        ]);
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()
            ->route('dashboard.categories.trash')
            ->with('success', 'Category restored!');

    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()
            ->route('dashboard.categories.trash')
            ->with('success', 'Category deleted for ever!');
    }

    protected function rules(?Category $category = null)
    {
        $rules = $this->rules;
        $rules['slug'][] = Rule::unique('categories', 'slug')->ignore(optional($category)->id);

        $rules['name'][] = new FilterRule();
        return $rules;
    }
}
