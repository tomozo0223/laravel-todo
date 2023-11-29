<x-app-layout>
    <x-slot:header>
        タスク登録ページ
    </x-slot:header>
    <div class="p-12 m-4 bg-white">
        <form action="" method="POST">
            @csrf
            <div class="m-4">
                <label for="title">タイトル</label>
                <input type="text" name="title" id="taitle" class="w-full">
            </div>
            <div class="m-4">
                <label for="body">本文</label>
                <textarea name="body" id="body" cols="30" rows="10" placeholder="本文を入力してください" class="w-full"></textarea>
                <div class="flex justify-end">
                    <x-primary-button>登録</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
