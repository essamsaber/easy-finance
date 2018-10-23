<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\SourceOfIncome;
use Illuminate\Http\Request;

class IncomeSourcesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // This prop is used to set the pagination limit per page
    protected $limit = 15;

    public function index()
    {
        $sources = SourceOfIncome::latest()->mine()->paginate($this->limit);
        return view('sources.index',compact('sources'));
    }

    public function show($id)
    {
        $source = SourceOfIncome::where('id', $id)->first();
        if($source) return $source;
        return 0;
    }

    public function create()
    {
        return view('sources.create');
    }
    public function store(AddNewSourceRequest $request)
    {
        $request->user()->sources()->create($request->all());
        return redirect()->route('sources.index')
            ->with('success', 'New income source has been created successfully !');
    }
    public function edit(SourceOfIncome $source)
    {
        return view('sources.edit', compact('source'));
    }

    public function update(UpdateSourceRequest $request, SourceOfIncome $source)
    {
        $source->update($request->except('user_id'));
        return redirect()->route('sources.index')
            ->with('success', 'The income source has been updated successfully !');
    }
    public function destroy(SourceOfIncome $source)
    {
        if($source->delete()) {
            return session()
                ->flash('success', 'Income source has been deleted successfully');
        }
        return session()->flash('failed', 'Something went wrong');
    }
}
