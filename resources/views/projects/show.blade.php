@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 pb-4">
        <div class="flex justify-between w-full items-end">
                <p class="text-grey text-sm font-normal">
                        <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects</a> / {{$project->title}}
                </p>
        <a href="{{$project->path().'/edit'}}" class="button">Edit Project</a>
        </div>
    </header>

    <main>
            <div class="lg:flex -mx-3">
                    <div class="lg:w-3/4 px-3 mb-6">
                        <div class="mb-8">
                                <h2 class="text-grey text-lg font-normal mb-3">Tasks</h2>
                                {{-- Tasks --}}
                                @foreach ($project->tasks as $task)
                                        <div class="card mb-3">
                                                <form method="POST" action="{{$task->path()}}">
                                                        @method('PATCH')
                                                        @csrf
                                                        <div class="flex">
                                                                <input class="w-full {{$task->completed ? 'text-grey' : ''}}" name="body" value="{{$task->body}}">
                                                                <input name="completed" type="checkbox" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                                        </div>
                                                </form>
                                        </div>
                                @endforeach
                                <div class="card mb-3">
                                        <form method="POST" action="{{$project->path() . '/tasks'}}">
                                                @csrf
                                                <input name="body" class="w-full" placeholder="Add a new task...">
                                         </form>
                                </div>
                        </div>

                        <div>
                                <h2 class="text-grey text-lg font-normal mb-3">General notes</h2>
                                {{-- General notes --}}
                                <form method="POST" action="{{$project->path()}}">
                                        @csrf
                                        @method('PATCH')
                                        <textarea placeholder="Leave a note here ..."
                                        name="notes"
                                         style="min-height: 200px;"
                                         class="card w-full mb-4">
                                         {{$project->notes}}
                                        </textarea>
                                        <button type="submit" class="button">Save</button>
                                </form>

                                @if ($errors->any())
                                        <div class="field mt-6">
                                                @foreach ($errors->all() as $error)
                                                <li class="text-sm text-red">{{ $error }}</li>
                                                @endforeach
                                        </div>
                                @endif
                        </div>
                    </div>
                    <div class="lg:w-1/4 px-3" >
                        @include('projects.card')
                    </div>
            </div>
    </main>


@endsection
