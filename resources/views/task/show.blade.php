<x-app-layout>
    <x-slot:header>
        タスク詳細ページ
    </x-slot:header>
    <div class="p-12 m-4 bg-white">
        @if (session('message'))
            {{ session('message') }}
        @endif
        <div class="p-4 bg-green-50 m-4">
            <h2 class="font-semibold">{{ $task->title }}</h2>
            <hr>
            <p>{{ $task->body }}</p>
            <p class="flex justify-end">{{ $task->user->name }}</p>
        </div>
        <div class="m-4 flex justify-end">
            <x-primary-button class="bg-green-700">
                <a href="{{ route('task.edit', $task) }}">更新</a>
            </x-primary-button>
            <form action="{{ route('task.destroy', $task) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button class="ml-2">
                    削除
                </x-danger-button>
            </form>
        </div>
    </div>
</x-app-layout>
