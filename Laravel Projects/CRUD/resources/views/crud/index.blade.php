<!DOCTYPE html>
<html lang="en">
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

        th {
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
                <a class="btn btn-success" href="{{ route('create_currency') }}"> Add Currency </a>
            </div>
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
            <th>Name</th>
            <th>Symbol</th>
            <th>Rank</th>
            <th>Icon</th>
            <th>Total Volume</th>
            <th>Daily Volume</th>
            <th>Action</th>
        </tr>
        @foreach ($currencies as $digital_currency)
            <tr>
                <td>{{ $digital_currency->id }}</td>
                <td>{{ $digital_currency->name }}</td>
                <td>{{ $digital_currency->symbol }}</td>
                <td>{{ $digital_currency->rank }}</td>
                <td>
                    <img style="" src={{url('/icon/'.$digital_currency->icon)}} width="40px" height="40px"
                         alt="no file"/>
                </td>
                <td>{{ $digital_currency->total_volume }}</td>
                <td>{{ $digital_currency->daily_volume }}</td>
                <td>
                    <form action="{{ route('destroy_currency',$digital_currency) }}" method="Post">
                        <a class="btn btn-primary" href="{{ route('edit_currency',$digital_currency->id)}}">Edit</a>
                        <a class="btn btn-primary" href="{{route('show_currency', $digital_currency->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{route('get_banners', $digital_currency->id)}}">Banners</a>
                        <a class="btn btn-primary" href="{{route('test_redis', $digital_currency->id)}}">Redis</a>

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
{!! $currencies->links() !!}
</body>
</html>
