<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use App\Imports\Bookimport;
use App\Models\Book;
use App\Models\Bookshelf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $author = Book::select('author')->distinct()->orderByDesc('author')->pluck('author');
        $years = Book::select('year')->distinct()->orderByDesc('year')->pluck('year');
        $publishers = Book::select('publisher')->distinct()->orderByDesc('publisher')->pluck('publisher');
        $cities = Book::select('city')->distinct()->orderByDesc('city')->pluck('city');
        $bookshelves = Bookshelf::all();

        $books = Book::when($request->filled('search'), function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->when($request->filled('author'), function ($query, $author) {
            return $query->where('author', 'like', '%' . $author . '%');
        })->when($request->filled('year'), function ($query, $year) {
            return $query->where('year', $year);
        })->when($request->filled('publisher'), function ($query, $publisher) {
            return $query->where('publisher', 'like', '%' . $publisher . '%');
        })->when($request->filled('city'), function ($query, $city) {
            return $query->where('city', 'like', '%' . $city . '%');
        })->when($request->filled('bookshelf_id'), function ($query, $bookshelf_id) {
            return $query->where('bookshelf_id', $bookshelf_id);
        })->latest()->get();

        return view('books.index', compact('books', 'search', 'author', 'years', 'publishers', 'cities', 'bookshelves'));
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
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|digits:4|min:1900|max:'.(date('Y')),
            'publisher' => 'required|max:255',
            'city' => 'required|max:255',
            'cover' => 'required|image',
            'bookshelf_id' => 'required',
        ]);

        if($request->hasFile('cover'))
        {
            $path = $request->file('cover')->storeAs(
                'cover_buku/',
                'cover_buku_'.time(). '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::create($validated);

        $notification = array(
            'message' => 'Data Berhasil diSimpan',
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
        $data['book'] = Book::findOrFail($id);
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|digits:4|min:1900|max:'.(date('Y')),
            'publisher' => 'required|max:255',
            'city' => 'required|max:255',
            'cover' => 'required|image',
            'bookshelf_id' => 'required',
        ]);

        $book = Book::find($id);
        if($request->hasFile('cover'))
        {
            if($book->cover != null)
            {
                Storage::delete('storage/cover_buku/'. $book->cover);
            }
            $path = $request->file('cover')->storeAs(
                'cover_buku/',
                'cover_buku_'.time(). '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::where('id', $id)->update($validated);

        $notification = array(
            'message' => 'Data Berhasil diSimpan',
            'alert-type' => 'success'
        );

        if($request->save)
        {
            return redirect()->route('book.index')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        Storage::delete('public/cover_buku/'.$book->cover);
            
        $book->delete();

        $notification = array(
            'message' => 'Data buku berhasil dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('book.index')->with($notification);

    }

    public function print()
    {
        $data['books'] = Book::all();
        $pdf = Pdf::loadView('books.print', $data);
        return $pdf->stream('data_buku.pdf');
    }

    public function export()
    {
        return Excel::download(new BookExport, 'data-buku.xlsx');
    }

    public function import(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new Bookimport, $req->file('file'));

        $notification = array(
            'message' => 'Import data berhasil dilakukan',
            'alert-type' => 'success'
        );

        return redirect()->route('book.index')->with($notification);
    }
}
