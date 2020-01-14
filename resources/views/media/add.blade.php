@extends('layouts.admin')

@section('title','素材管理-添加')

@section('content')
<h3>素材管理-添加</h3>

<form action="{{url('admin/add_do')}}" method="post"  enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail1">名称</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email" name="media_name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">类型</label>
    <select name="media_type" class="form-control">
    <option value="1">临时</option>
    <option value="2">永久</option>
    </select>
  </div>
<div class="form-group" >
    <label for="exampleInputPassword1">格式</label>
    <select class="form-control" name="media_format">
     <option value="0">请选择</option>
    <option value="images">图片</option>
    <option value="voice">语音</option>
    <option  value="video">视频</option>

    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">素材文件</label>
    <input type="file" id="exampleInputFile" name="file">
  </div>
  <button type="submit" class="btn btn-default">提交</button>
</form>
@endsection