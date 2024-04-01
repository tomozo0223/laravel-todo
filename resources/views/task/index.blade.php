<x-app-layout>
    <x-slot:header>
        タスク一覧ページ
    </x-slot:header>
    <div class="p-12 m-4 bg-white">
        @if (session('message'))
            {{ session('message') }}
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
            @if (!$tasks->isEmpty())
                <x-primary-button class="bg-black-400">
                    ダウンロード
                </x-primary-button>
            @endif
        </form>
    </div>
    {{ $tasks->links() }}
</x-app-layout>
