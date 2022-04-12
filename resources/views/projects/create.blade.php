@extends('layouts.app')

@section('content')
<div class="">
    <form method="POST" action="/projects">
        <h1>Create a Project!</h1>
        @csrf
        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase" for="title">
            Title
        </label>
        <input class="w-full p-2 border border-gray-400 rounded" type="text" id="title" name="title" required>
</div>

<div class="mb-6">
    <label class="block mb-2 text-xs font-bold text-gray-700 uppercase" for="description">
        Description
    </label>
    <textarea class="w-full p-2 border border-gray-400 rounded" type="text" id="description" name="description" required></textarea>
</div>
<div class="field">
    <div class="control">
        <button type="submit" class="button">Create a Project</button>
        <a href="/projects">Cancel</a>
    </div>
</div>
</div>
</form>
@endsection