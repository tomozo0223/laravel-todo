<x-app-layout>
    <x-slot name="header">
        タスク一覧ページ
    </x-slot>
    <div class="md:p-12 p-4 m-4 bg-white w-96 md:w-4/5 mx-auto">
        @if (session('message'))
            <div class="bg-red-200 text-red-800 p-4 mb-4 rounded">{{ session('message') }}</div>
        @endif
        <form action="{{ route('csvDownload') }}" method="GET">
            @foreach ($tasks as $task)
                <div class="p-4 bg-green-50 m-4">
                    <div class="flex">
                        <a href="{{ route('task.show', $task) }}">
                            <h2 class="font-semibold mr-4">{{ $task->title }}</h2>
                        </a>
                        <input type="checkbox" name="selected_tasks[]" value="{{ $task->id }}">
                    </div>
                    <hr>
                    <p>{{ $task->body }}</p>
                    <p class="flex justify-end">{{ $task->user->name }}</p>
                    <p class="flex justify-end">{{ $task->created_at }}</p>
                </div>
            @endforeach
            <x-primary-button class="bg-black-400">
                ダウンロード
            </x-primary-button>
        </form>
    </div>
    {{ $tasks->links() }}
</x-app-layout>
