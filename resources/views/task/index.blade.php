<x-app-layout>
    <x-slot name="header">
        タスク一覧ページ
    </x-slot>
    <div class="md:p-12 p-4 m-4 bg-white w-96 md:w-4/5 mx-auto">
        @if (session('message'))
            <div class="bg-red-200 text-red-800 p-4 mb-4 rounded">{{ session('message') }}</div>
        @endif
        <table class="w-full table-fixed">
            <thead>
                <tr class="bg-green-500 text-white">
                    <th class="md:w-1/12 hidden md:table-cell py-4 text-center">選択</th>
                    <th class="w-auto md:w-3/12 py-4 md:text-base text-sm md:text-left">タイトル</th>
                    <th class="w-auto md:w-4/12 py-4 md:text-base text-sm md:text-left">内容</th>
                    <th class="w-auto md:w-2/12 py-4 md:text-base text-sm md:text-left">投稿者</th>
                    <th class="w-auto md:w-2/12 py-4 md:text-base text-sm md:text-left">作成日</th>
                    <th class="w-auto md:w-2/12 py-4 md:text-base text-sm md:text-center">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $index => $task)
                    <tr class="border-b cursor-pointer {{ $index % 2 === 1 ? 'bg-gray-100' : '' }}">
                        <fieldset form="check">
                            <td class="hidden md:table-cell text-center"><input type="checkbox" name="selected_tasks[]"
                                    value="{{ $task->id }}"></td>
                        </fieldset>
                        <td onclick="location.href='{{ route('task.show', $task) }}'"
                            class="md:text-base text-sm py-2 text-left"><a
                                href="{{ route('task.show', $task) }}">{{ $task->title }}</a>
                        </td>
                        <td onclick="location.href='{{ route('task.show', $task) }}'" class="md:text-base text-sm py-2">
                            {{ Str::limit($task->body, 50) }}
                        </td>
                        <td onclick="location.href='{{ route('task.show', $task) }}'"
                            class="md:text-base text-sm py-2 text-left">
                            {{ $task->user->name }}
                        </td>
                        <td onclick="location.href='{{ route('task.show', $task) }}'"
                            class="py-2 text-center text-sm md:text-sm">
                            {{ $task->created_at }}
                        </td>
                        <td class="py-2 text-center md:text-base text-sm">
                            <div class="flex justify-center">
                                <x-primary-button class="bg-blue-600 mr-1">
                                    <a href="{{ route('task.edit', $task) }}">更新</a>
                                </x-primary-button>
                                <form action="{{ route('task.destroy', $task) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>削除</x-danger-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <form action="{{ route('csvDownload') }}" id="check" method="get">
                <x-primary-button class="bg-black-400">
                    ダウンロード
                </x-primary-button>
            </form>
        </div>
        {{ $tasks->links() }}
    </div>
</x-app-layout>
