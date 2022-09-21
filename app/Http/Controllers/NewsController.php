<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
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
            $data = News::leftJoin('categories','news.category_id','=','categories.id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $json = json_encode($data);
                    $btn = "<td>
                    <div class='dropdown'>
                        <button class='btn btn-primary dropdown-toggle me-1' type='button'
                            id='dropdownMenuButtonIcon' data-bs-toggle='dropdown'
                            aria-haspopup='true' aria-expanded='false'>
                            <i class='bi bi-error-circle me-50'></i> Action
                        </button>
                        <div class='dropdown-menu' aria-labelledby='dropdownMenuButtonIcon'>
                            <a class='dropdown-item' href='#' onclick='editPage($json)'>
                            <i class='bi bi-bar-chart-alt-2 me-50'></i>
                            Edit</a>
                            <a class='dropdown-item' href='#' onclick='deleteModal($json)' data-bs-toggle='modal' data-bs-target='#exampleModalCenter'>
                            <i class='bi bi-bar-chart-alt-2 me-50'></i>
                            Delete</a>
                        </div>
                    </div>
                    </td>";
                    return $btn;
                })
                ->addColumn('created_at', function ($row){
                    return $row->created_at->format('d-M-Y');
                })
                ->rawColumns(['action','created_at'])

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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
