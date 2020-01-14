@extends('layouts.admin')

@section('title','素材管理-添加')

@section('content')
<h3>渠道管理-展示</h3>
<table class="table table-hover table-bordered">
<a href="{{url('/admin/channel_add')}}">添加</a>
<tr>
		<td>名称</td>
		<td>标识</td>
		<td>渠道二维码</td>
		
</tr>

	@foreach($data as $k=>$v)
<tr>
		
		<td>{{$v->channel_name}}</td>
		<td>{{$v->channel_status}}</td>
		<td>
		<img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" width="100px">
		</td>
</tr>
@endforeach
</table>

@endsection