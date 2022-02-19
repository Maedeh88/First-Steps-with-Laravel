<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        table {
            table-layout: fixed;
        }

        td {
            /*max-width: 100px;*/
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }

        th {
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('index_currency') }}" style="margin-top: 3%; margin-bottom: 1%">
                Back </a>
            <a class="btn btn-secondary float-right" href="{{route('add_banner', $currency->id)}}"
               style="margin-top: 3%; margin-bottom: 1%; background-color: darkgreen">Add Banner</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>Banner Type</th>
            <th>Title</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        @foreach ($currency->banners as $banner)
            <tr>
                @isset($banner->id)
                    <td>{{$banner->id}}</td>
                    <td>{{$banner->type->name}}</td>
                    <td>{{ $banner->title }}</td>
                    <td>
                        <img style="" src={{url('/BannerImages/'.$banner->image)}} width="40px" height="40px"
                             alt="no file"/>
                    </td>
                    <td>
                        <a class="btn btn-primary"
                           href="{{ route('remove_banner', [$id, $banner->id])}}"
                           style="background-color: darkred; border-color: darkred">Delete</a>
                    </td>
                @endisset
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>


