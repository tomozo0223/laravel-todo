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
            foreach ($taskIds as $taskId) {
                $tasks[] = Task::findOrFail($taskId);
            }
        } else {
            $tasks = Task::all();
        }
        $fileName = 'task.csv';


        $callback = function () use ($tasks) {
            $handle = fopen('php://output', 'a');
            foreach ($tasks as $task) {
                $taskData[] = [
                    $task->title,
                    $task->body,
                    $task->user->name,
                    $task->created_at
                ];
            }
            foreach ($taskData as $data) {
                fputcsv($handle, $data);
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
