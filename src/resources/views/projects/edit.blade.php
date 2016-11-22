@extends('larafolio::master')

@section('title')

@stop

@section('content')
    <project-form
        action="{{ route('update-project', ['project' => $project]) }}"
        cancel-action="{{ route('show-project', ['project' => $project]) }}"
        :icons="{{ json_encode([
            'down' => file_get_contents(public_path('vendor/larafolio/zondicons/arrow-thin-down.svg')),
            'remove' => file_get_contents(public_path('vendor/larafolio/zondicons/close.svg')),
            'up' => file_get_contents(public_path('vendor/larafolio/zondicons/arrow-thin-up.svg'))
        ]) }}"
        :next-in-order="{{ $nextInOrder }}"
        :project="{{ json_encode($project) }}"
        title="Edit Project: {{ $project->name() }}"
        type="update"
    ></project-form>
@stop