<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mb-2">
                <h2>Add A Banner</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('get_banners', $currency->id) }}"> Back</a>
            </div>
        </div>
    </div>
    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('attach_banner', $currency->id) }}" method="GET" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Banner Type:</strong>
                    <select name="banners" class="form-control custom-select">
                        <option value="">Select Type</option>
                        @foreach($all_banners as $banner)
                            <option value="{{ $banner->id }}">{{ $banner->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary ml-3" style="margin-top: 3%">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
