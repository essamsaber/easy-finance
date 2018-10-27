<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\SourceOfIncome;
use Illuminate\Http\Request;

/**
 * Class IncomeSourcesController
 * @package App\Http\Controllers
 */
class IncomeSourcesController extends Controller
{

    /**
     * IncomeSourcesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // This prop is used to set the pagination limit per page

    /**
     * @var int
     */
    protected $limit = 15;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sources = SourceOfIncome::latest()->mine()->paginate($this->limit);
        return view('sources.index',compact('sources'));
    }

    /**
     * @param $id
     * @return int
     */
    public function show($id)
    {
        $source = SourceOfIncome::where('id', $id)->first();
        if($source) return $source;
        return 0;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sources.create');
    }

    /**
     * @param AddNewSourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddNewSourceRequest $request)
    {
        $request->user()->sources()->create($request->all());
        return redirect()->route('sources.index')
            ->with('success', 'New income source has been created successfully !');
    }

    /**
     * @param SourceOfIncome $source
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(SourceOfIncome $source)
    {
        $this->authorize('edit', $source);
        return view('sources.edit', compact('source'));
    }

    /**
     * @param UpdateSourceRequest $request
     * @param SourceOfIncome $source
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateSourceRequest $request, SourceOfIncome $source)
    {
        $this->authorize('update', $source);
        $source->update($request->except('user_id'));
        return redirect()->route('sources.index')
            ->with('success', 'The income source has been updated successfully !');
    }

    /**
     * @param SourceOfIncome $source
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(SourceOfIncome $source)
    {
        $this->authorize('delete', $source);
        if($source->delete()) {
            return session()
                ->flash('success', 'Income source has been deleted successfully');
        }
        return session()->flash('failed', 'Something went wrong');
    }
}
