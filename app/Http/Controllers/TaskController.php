<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks  (+ فلتر اختياري: ?status=completed)
    public function index(Request $request): JsonResponse
    {
        $query = Task::query();

        if ($request->filled('status')) {
            $request->validate([
                'status' => ['in:pending,in_progress,completed'],
            ]);
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->get());
    }

    // POST /api/tasks
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateTask($request);

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    // GET /api/tasks/{task}
    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    // PUT/PATCH /api/tasks/{task}
    public function update(Request $request, Task $task): JsonResponse
    {
        $validated = $this->validateTask($request, isUpdate: true);

        $task->update($validated);

        return response()->json($task);
    }

    // DELETE /api/tasks/{task}
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    // قواعد التحقق في مكان واحد لتجنب التكرار
    private function validateTask(Request $request, bool $isUpdate = false): array
    {
        // عند الإنشاء: title مطلوب. عند التعديل: نتحقق منه فقط إذا أُرسل
        $titleRule = $isUpdate ? 'sometimes' : 'required';

        return $request->validate([
            'title'       => [$titleRule, 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'status'      => ['sometimes', 'in:pending,in_progress,completed'],
            'due_date'    => ['nullable', 'date'],
        ]);
    }
}