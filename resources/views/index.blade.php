<!-- Hello I am a blade template

@isset($name)
The name is : {{ $name }}
@else
The name is : default name
@endif

@isset($script)
Automatically block the html tags for security reasons {{ $script }}
@endif -->
@extends('layouts.app')

@section('title',"The list of tasks")



@section('content')

    <nav class="mb-4">
        <a href="{{ route('tasks.create') }}" class="link">Add Task!</a>
    </nav>

    <!-- @if(count($tasks) == 0)<div>There are no task to do</div>
    @elseif (count($tasks) == 1)
    <div>There are {{count($tasks)}} task to do</div>
    @foreach ($tasks as $task )
        <div>
            <h2>{{$task -> title}}</h2>
        </div>
    @endforeach
    @else <div>There are {{count($tasks)}} tasks to do</div>
    @foreach ($tasks as $task )
        <div>
            <h2>{{$task -> title}}</h2>
        </div>
    @endforeach
    @endif -->

    @forelse ($tasks as $task)
        <div>
            <a href="{{ route('tasks.show' , ['task' => $task->id] )}}" @class(['line-through' => $task->completed])>{{$task -> id}}. {{$task -> title}}</a>
            <!-- <h3>{{$task -> id}} : {{$task -> title}}</h3> -->
            <!-- <p style="margin-left: 10px;">{{$task -> description}}</p> -->
        </div>
    @empty
        <div>There is no task to do</div>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-4">
        {{ $tasks->links() }}
        </nav>
    @endif

@endsection