<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan daftar tugas
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    // Menampilkan form tambah tugas
    public function create()
    {
        return view('tasks.create');
    }

    // Menyimpan data tugas baru ke database
    // ...existing code...
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Belum selesai,Selesai',
        ]);

        $isCompleted = $request->status === 'Selesai' ? 1 : 0;

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $isCompleted,
        ]);

        return redirect('/tasks')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Belum selesai,Selesai',
        ]);

        $task = Task::findOrFail($id);
        $isCompleted = $request->status === 'Selesai' ? 1 : 0;

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $isCompleted,
        ]);

        return redirect('/tasks')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified task from storage.
     */
}
