@extends('layouts.admin')

@section('title','素材管理-添加')

@section('content')
<h3>素材管理-添加</h3>

<form action="{{url('admin/channel_add_do')}}" method="post"  enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail1">名称</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="channel_name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">标识</label>
       <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="channel_status">
  </div>
  <button type="submit" class="btn btn-default">提交</button>
</form>
@endsection