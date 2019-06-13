<!DOCTYPE html>
<html lang="en">

<head>

    <title>Document</title>
</head>

<body>
        <h1>pgojects</h1>

    <ul>
        @forelse ($projects as $project)
        <li>
        <a href="{{$project->path()}}">
            {{$project->title}}
            </a>
        </li>
        @empty
        <li>No projects</li>

        @endforelse
    </ul>
</body>

</html>