<x-app-layout>
    <x-slot:header>
        タスク登録ページ
    </x-slot:header>
    <div class="p-12 m-4 bg-white">
        <form action="{{ route('csvUpload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (session('message'))
                {{ session('message') }}
            @endif
            @error('csv_file')
                {{ $message }}
            @enderror
            <input type="file" name="csv_file" class="block mb-2">
            <x-primary-button>
                インポート
            </x-primary-button>
        </form>
        <form action="{{ route('task.store') }}" method="POST">
            @csrf
            <div class="m-4">
                <label for="title">タイトル</label>
                <input type="text" name="title" id="title" class="w-full">
                @error('title')
                    {{ $message }}
                @enderror
            </div>
            <div class="m-4">
                <label for="body">本文</label>
                <textarea name="body" id="body" cols="30" rows="10" placeholder="本文を入力してください" class="w-full"></textarea>
                @error('body')
                    {{ $message }}
                @enderror
                <div class="flex justify-end">
                    <x-primary-button>登録</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
