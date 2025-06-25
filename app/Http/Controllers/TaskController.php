<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Auth::user()->tasks()->latest()->get();

        $tags = collect();
        $tasks->each(function ($task) use ($tags) {
            if ($task->tags) {
                $tags = $tags->merge(explode(',', $task->tags));
            }
        });

        $tags = $tags->unique()->filter()->values();

        return view('tasks.index', compact('tasks', 'tags'));
    }


    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,completed'
        ]);

        Auth::user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'تم إنشاء المهمة بنجاح');
    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('update', $task);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,completed'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'تم تحديث المهمة بنجاح');
    }
    public function toggle(Request $request, Task $task)
    {
        Gate::authorize('update', $task);

        $request->validate([
            'status' => 'required|in:pending,completed'
        ]);

        $task->update(['status' => $request->input('status')]);

        return redirect()->route('tasks.index')
            ->with('success', 'تم تحديث المهمة بنجاح');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'تم حذف المهمة بنجاح');
    }
}
