<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\DB;

// Get all coursetypes
Route::get('/coursetypes', function () {
    $coursestypes = DB::select('SELECT * FROM types');
    return response()->json($coursestypes);
});

// Get all courses
Route::get('/courses', function () {
    $courses = DB::select('SELECT * FROM courses');
    return response()->json($courses);
});

// Get a specific course by ID
Route::get('/courses/{id}', function ($id) {
    $course = DB::select('SELECT * FROM courses WHERE id = ?', [$id]);
    if (empty($course)) {
        return response()->json(['message' => 'Course not found'], 404);
    }
    return response()->json($course[0]);
});

// Create a new course
Route::post('/courses', function (\Illuminate\Http\Request $request) {
    $name = $request->input('name');
    $price = $request->input('price');
    $start = $request->input('start');
    $duration = $request->input('duration');
    $type_id = $request->input('type_id');

    DB::insert('INSERT INTO courses (name, price, start, duration, type_id) VALUES (?, ?, ?, ?, ?)', [$name, $price, $start, $duration, $type_id]);

    return response()->json(['message' => 'Course created successfully'], 201);
});

// Update a course by ID
Route::put('/courses/{id}', function (\Illuminate\Http\Request $request, $id) {
    $name = $request->input('name');
    $price = $request->input('price');
    $start = $request->input('start');
    $duration = $request->input('duration');
    $type_id = $request->input('type_id');

    // $affected = DB::update('UPDATE courses SET title = ?, description = ? WHERE id = ?', [$title, $description, $id]);
    $affected = DB::update('UPDATE courses SET name = ?, price = ?, start = ?, duration = ?, type_id = ? WHERE id = ?', [$name, $price, $start, $duration, $type_id, $id]);

    if ($affected === 0) {
        return response()->json(['message' => 'Course not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Course updated successfully']);
});

// Delete a course by ID
Route::delete('/courses/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM courses WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Course not found'], 404);
    }
    return response()->json(['message' => 'Course deleted successfully']);
});