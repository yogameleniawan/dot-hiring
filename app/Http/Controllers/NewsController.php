<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::leftJoin('categories','news.category_id','=','categories.id')
            ->select('news.id','categories.name','news.category_id','news.title','news.detail','news.created_at')
            ->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $json = json_encode($data);
                    $btn = "<td>
                    <div class='dropdown'>
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
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return response()->json(['data' => $categories], 200);
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
        $table = News::create($data);
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
        $table = News::find($id);
        $categories = Category::all();
        return response()->json(['data' => $table, 'categories' => $categories], 200);
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
        $table = News::find($request->id)->update($data);
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
        $table = News::find($request->id)->delete();
        return response()->json(['data' => $table], 200);
    }
}
