<x-app-layout>
    <x-slot:header>
        タスク登録ページ
    </x-slot:header>
    <div class="p-12 m-4 bg-white">
        <form action="{{ route('task.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="m-4">
                <label for="title">タイトル</label>
                <input type="text" name="title" id="title" class="w-full" value="{{ old('title', $task->title) }}">
                @error('title')
                    {{ $message }}
                @enderror
            </div>
            <div class="m-4">
                <label for="body">本文</label>
                <textarea name="body" id="body" cols="30" rows="10" placeholder="本文を入力してください" class="w-full">{{ old('body', $task->body) }}</textarea>
                @error('body')
                    {{ $message }}
                @enderror
                <div class="flex justify-end">
                    <x-primary-button>更新</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
