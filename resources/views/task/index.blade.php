<x-app-layout>
    <x-slot:header>
        タスク一覧ページ
    </x-slot:header>
    <div class="p-12 m-4 bg-white">
        @foreach ($tasks as $task)
            <div class="p-4 bg-green-50 m-4">
                <h2 class="font-semibold">{{ $task->title }}</h2>
                <hr>
                <p>{{ $task->body }}</p>
                <p class="flex justify-end">{{ $task->user->name }}</p>
            </div>
        @endforeach
    </div>
</x-app-layout>
