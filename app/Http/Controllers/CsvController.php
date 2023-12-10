<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CsvController extends Controller
{
    public function csvDownload(Request $request)
    {
        // チェックボックスの値が存在するとき
        if ($request->selected_tasks) {
            $taskIds = $request->input('selected_tasks');
            $tasks = Task::whereIn('id', $taskIds)->get();
        } else {
            $tasks = Task::all();
        }
        $fileName = 'task.csv';


        $callback = function () use ($tasks) {
            $handle = fopen('php://output', 'w');
            foreach ($tasks as $task) {
                $taskData = [
                    $task->title,
                    $task->body,
                    $task->user->name,
                    $task->created_at
                ];
                fputcsv($handle, $taskData);
            }
            fclose($handle);
        };

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment;'
        ];

        return response()->streamDownload($callback, $fileName, $headers);
    }

    public function csvUpload(CsvUploadRequest $request)
    {
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
        }

        $handle = fopen($csvFile->getPathname(), 'r');
        $csvData = fgetcsv($handle);
        $title = $csvData[0];
        $body = $csvData[1];

        Task::create([
            'title' => $title,
            'body' => $body,
            'user_id' => Auth::id(),
        ]);

        return to_route('task.index')->with('message', 'csvファイルから登録しました。');
    }
}
