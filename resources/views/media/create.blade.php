@extends('layouts.admin')

@section('title','素材管理-添加')

@section('content')
<h1>添加</h1>
	<form action="{{url('admin/store')}}" method="post">
	 <div class="form-group">
	@csrf
    标题<input type="input" name="c_name" class="form-control"><br>
    内容<textarea name="c_desc"></textarea ><br>
    作者<input type="input" name="c_author" class="form-control"><br>
    <input type="submit" value="提交">
      </div>
    </form>
@endsection