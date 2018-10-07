<?php

namespace Furbook\Http\Controllers;

use Illuminate\Http\Request;
use Furbook\Http\Requests\CatRequest;
use Furbook\Cat;
use Furbook\Breed;
use Validator;


class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Cat::orderBy('created_at', 'DESC')->get();
        //dd($cats);
        return view('cats.index')->with('cats', $cats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'name'          => 'required|max:255',
                'date_of_birth' => 'required|date_format:"Y-m-d"',
                'breed_id'      => 'required|numeric',
            ],
            [
                'required'    => 'Trường :attribute là bắt buộc',
                'max'         => 'Trường :attribute tối đa là :max kí tự',
                'numeric'     => 'Trường bắt buộc :attribute là kiểu số nguyên',
                'date_format' => 'Trường :attribute format không đúng định dạng :format',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                //->with('errors', $validator)
                ->withInput();
        }

        $data = $request->all();
        Cat::create($data);
        return redirect()
            ->route('cats.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  object  $cat
     * @return \Illuminate\Http\Response
     */
    public function show(\Furbook\Cat $cat)
    {
        return view('cats.show', compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Cat::find($id);
        //dd($cat);
        return view('cats.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatRequest $request, $id)
    {
        $data = $request->all();
        $cat = Cat::find($id);
        $cat->update($data);
        return redirect()
            ->route('cats.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Cat::find($id);
        $cat->delete();
        return redirect()
            ->route('cats.index');
    }

    /**
     * Show list cats belong to breed
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function breed($name)
    {
        $breed = Breed::where('name', $name)
            ->first();
        $cats = $breed->cats;
        //dd($cats);
        return view('cats.index', compact('breed', 'cats'));
    }
}