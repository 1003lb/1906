<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Curd;

class CurdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
     $c_name = request()->c_name;
     $c_author = request()->c_author;
        $where=[];
        if ($c_name) {
            $where[]=['c_name','like',"%$c_name%"];
        }
    if ($c_author) {
            $where[]=['c_author','like',"%$c_author%"];
        }
        $data = Curd::where($where)->orderBy('c_id','desc')->paginate(2);
        $query = request()->all();
       return view('media.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $post=$request->except('_token');
      // dd($post);
        $res=Curd::create([
                'c_name'=>$post['c_name'],
                'c_desc'=>$post['c_desc'],
                'c_author'=>$post['c_author'],
                'c_time'=>time(),
                 ]);
        //dd($res);
    if($res){
        echo "<script>alert('添加成功');location.href='/admin/index';</script>";
        }
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
           if(!$id){
             abort(404);
        }
        $data=Curd::where('c_id',$id)->first();
        //dd($data);
    return view('media.edit',['data'=>$data]);
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
          if(!$id){
            echo 404;
        }
      $post=$request->except('_token');
        $res=Curd::where('c_id',$id)->update($post);
       if($res){
            echo "<script>alert('修改成功');location.href='/admin/index';</script>";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //echo time();die;
        if(!$id){
            echo 404;
        }
        $res=Curd::where('c_id',$id)->delete();
        //dd($res);
    if($res){
            echo "<script>alert('删除成功');location.href='/admin/index';</script>";
        }
    }
}
