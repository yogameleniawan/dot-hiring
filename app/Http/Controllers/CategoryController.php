<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $json = json_encode($data);
                    $btn = "<td>
                    <div class='dropdown text-center'>
                        <button class='btn btn-action dropdown-toggle me-1' type='button'
                            id='dropdownMenuButtonIcon' data-bs-toggle='dropdown'
                            aria-haspopup='true' aria-expanded='false'>
                            <i class='bi bi-error-circle me-50'></i> Action
                        </button>
                        <div class='dropdown-menu' aria-labelledby='dropdownMenuButtonIcon'>
                            <a class='dropdown-item' onclick='editPage($json)'>
                            <i class='bi bi-pencil-square'></i>
                            Edit</a>
                            <a class='dropdown-item' onclick='deleteModal($json)' data-bs-toggle='modal' data-bs-target='#exampleModalCenter'>
                            <i class='bi bi-trash-fill'></i>
                            Delete</a>
                        </div>
                    </div>
                    </td>";
                    return $btn;
                })
                ->rawColumns(['action'])

                ->make(true);
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $table = Category::create($data);
        return response()->json(['data' => $table], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = Category::find($id);
        return response()->json(['data' => $table], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $table = Category::find($request->id)->update($data);
        return response()->json(['data' => $request->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $table = Category::find($request->id)->delete();
        return response()->json(['data' => $table], 200);
    }
}
