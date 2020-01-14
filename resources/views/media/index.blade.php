<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="" method="">
    标题<input type="input" name="c_name" value="{{$query['c_name']??''}}" placeholder="请输入名称关键字">
 作者<input type="input" name="c_author" value="{{$query['c_author']??''}}" placeholder="请输入作者名称">
    <input type="submit" value="搜索">
    </form>
<a href="{{url('admin/create')}}">添加</a>
<table border="3">
<tr>
<td>标题</td>
<td>内容</td>
<td>作者</td>
<td>时间</td>
<td>访问量</td>
<td>编辑</td>
</tr>
@foreach($data as $v)
<tr>
<td>{{$v->c_name}}</td>
<td>{{$v->c_desc}}</td>
<td>{{$v->c_author}}</td>
<td>{{date('Y-m-d H:i:s',$v->c_time)}}  </td>
<td>{{$v->c_wwl}}</td>
<td>
<a href="{{url('/admin/delete/'.$v->c_id)}}">删除</a>
<a href="{{url('/admin/edit/'.$v->c_id)}}">修改</a>
</td>
</tr>
@endforeach
</table>
{{$data->appends($query)->links()}}
</body>
</html>
