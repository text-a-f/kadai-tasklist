@extends('layouts.app')

@section('content')
    <h1>メッセージ一覧</h1>
    @if  (count($tasks ) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>メッセージ</th>
                </tr>
            </thead>
            <tbody>
                @foreach  ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    {!! link_to_route('Tasks.create', '新規メッセージの投稿', [], ['class' => 'btn btn-primary']) !!}
@endsection
