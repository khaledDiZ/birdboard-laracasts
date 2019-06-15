@extends('layouts.app')

@section('content')

        <form method="POST" action="/projects" >
            @csrf
                <h1>Create a project</h1>
            <div class="field">
                <label class="lable" for="title">Title</label>
                <div class="control">
                    <input type="text" class="input" name="title" placeholder="title">
                </div>
            </div>

            <div class="field">
                    <label class="lable" for="description">Description</label>
                    <div class="control">
                        <textarea  class="textarea" name="description" placeholder="description"></textarea>
                    </div>
                </div>

            <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Create a project</button>
                        <a class="button " href="/projects">Canceal</a>
                    </div>
                </div>
        </form>



@endsection