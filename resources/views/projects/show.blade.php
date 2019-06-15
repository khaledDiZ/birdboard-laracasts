@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4" >
        <div class="flex justify-between w-full items-end">
                <p class="text-grey text-sm font-normal">
                        <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects</a> / {{$project->title}}
                </p>
                <button href="/projects/create" class="button">Create a project</button>
        </div>
    </header>

    <main>
            <div class="lg:flex -mx-3">
                    <div class="lg:w-3/4 px-3 mb-6">
                        <div class="mb-8">
                                <h2 class="text-grey text-lg font-normal mb-3">Tasks</h2>
                                {{-- Tasks --}}
                                <div class="card">Lorem Ipsum</div>
                        </div>

                        <div>
                                <h2 class="text-grey text-lg font-normal mb-3">General notes</h2>
                                {{-- General notes --}}
                                <textarea style="min-height: 200px;" class="card w-full">Lorem Ipsum</textarea>
                        </div>
                    </div>
                    <div class="lg:w-1/4 px-3" >
                        @include('projects.card')
                    </div>
            </div>
    </main>


@endsection
