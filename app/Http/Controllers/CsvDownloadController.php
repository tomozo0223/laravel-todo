<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class CsvDownloadController extends Controller
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
}
