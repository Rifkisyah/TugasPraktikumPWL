<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookshelf;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['books'] = Book::all();
        return view('books.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=> 'required | max:255 ',
            'author' => 'required | max:255',
            'year' => 'required | integer | digits:4 | min:1900 | max:'.(date('Y')),
            'publisher' => 'required | max:255',
            'city' => 'required | max:255',
            'cover' => 'required | image',
            'bookshelf_id' => 'required | max:255',
        ]);

        if($request->hasFile('cover'))
        {
            $path = $request->file('cover')->storeAs(
                'cover_buku/',
                'cover_buku'.time() . '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }
        Book::create($validated);

        $notification = array(
            'message' => 'Data Berhasil Disimpan!',
            'alert-type' => 'success'
        );

        if($request->save)
            {
                return redirect()->route('book.index')->with($notification);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('produk berhasil dihapus');
    }
}
