<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Your form for adding titles -->
    <form method="POST" action="{{ route('add.title') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}">
        <button type="submit">Add Title</button>
    </form>

    @foreach ($titles as $title)
        @if ($title->spotify_track_id)
            <img src="{{$title->getCoverArt($title->spotify_track_id)}}" alt="Title Cover">
            <!-- Display the cover art for each track along with other details -->
        @else
            hello
        @endif
    @endforeach

</body>
</html>
