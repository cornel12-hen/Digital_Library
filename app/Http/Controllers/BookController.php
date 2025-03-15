<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:0|max:' . date('Y'),
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return response()->json($book, 200);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'writer' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:categories,id',
            'publisher' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer|min:0|max:' . date('Y'),
        ]);

        $book->update($validated);

        return response()->json($book, 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
