<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvUploadRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CsvController extends Controller
{
    public function downloadCsv(Request $request)
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

    public function uploadCsv(CsvUploadRequest $request)
    {
        if ($request->file('csv_file')->getClientOriginalExtension() === 'csv') {
            $handle = $this->openUploadFile($request);
        } else {
            return to_route('task.create')->with('message', 'csvファイルを選択してください。');
        }

        if ($handle) {
            while (($csvData = fgetcsv($handle)) !== false) {
                $tasks[] = [
                    'title' => $csvData[0],
                    'body' => $csvData[1],
                    'user_id' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            Task::insert($tasks);
            fclose($handle);
            return to_route('task.index')->with('message', 'csvファイルから登録しました。');
        }
    }

    private function openUploadFile($request)
    {
        if (!$request->hasFile('csv_file')) {
            return null;
        }
        $csvFile = $request->file('csv_file');
        // if ($csvFile->getClientOriginalExtension() !== 'csv') {
        //     return to_route('task.index')->with('message', 'csvファイルを選択してください。');
        // }
        return fopen($csvFile->getPathname(), "r");
    }
}
