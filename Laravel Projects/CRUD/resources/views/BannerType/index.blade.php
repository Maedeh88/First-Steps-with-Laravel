<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>

        td {
            /*max-width: 100px;*/
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }
        th{
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left" style="margin-top: 4%">
                <h2></h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('create_banner_type') }}"> Add Banner Type </a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if($message = Session::get('error'))
        <div class="alert alert-error">
            <p>{{$message}}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>Name</th>
{{--            <th>related_banners</th>--}}
            <th>Action</th>
        </tr>
        @foreach ($banner_types as $banner_type)
            <tr>
                <td>{{ $banner_type->id }}</td>
                <td>{{ $banner_type->name }}</td>
{{--                <td>{{ $banner_type->banners->title }}</td>--}}

                <td>
                    <a class="btn btn-primary" href="{{ route('edit_banner_type',$banner_type->id)}}"
                       style="background-color: darkblue; border-color: darkblue">Edit</a>
                    <a class="btn btn-primary" href="{{ route('destroy_banner_type',$banner_type->id)}}"
                       style="background-color: darkred; border-color: darkred">Delete</a>
                </td>
            </tr>
        @endforeach
    </table>
{!! $banner_types->links() !!}
</body>
</html>
