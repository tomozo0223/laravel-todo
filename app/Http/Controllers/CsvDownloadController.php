<?php

namespace App\Http\Controllers;

use App\Models\Task;

class CsvDownloadController extends Controller
{
    public function csvDownload(Task $task)
    {
        $fileName = 'task.csv';

        $callback = function () use ($task) {
            $handle = fopen('php://output', 'w');
            $task = [$task->title, $task->body];
            fputcsv($handle, $task);
            fclose($handle);
        };

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment;'
        ];

        return response()->streamDownload($callback, $fileName, $headers);
    }
}
