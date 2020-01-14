<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<h1>修改</h1>
	<form action="{{url('admin/update/'.$data->c_id)}}" method="post">
	@csrf
    标题<input type="input" name="c_name" value="{{$data->c_name}}"><br>
    内容<textarea name="c_desc">{{$data->c_name}}</textarea><br>
    作者<input type="input" name="c_author" value="{{$data->c_author}}"><br>
    <input type="submit" value="提交">
    </form>
</body>
</html>