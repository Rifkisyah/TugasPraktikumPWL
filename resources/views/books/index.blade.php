<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="m-4"
                    x-data="{
                        openFilter: {{
                            request()->filled('search') ||
                            request()->filled('author') ||
                            request()->filled('year') ||
                            request()->filled('publisher') ||
                            request()->filled('city') ||
                            request()->filled('bookshelf_id') ||
                            request()->filled('cover_status')
                                ? 'true'
                                : 'false'
                        }}
                    }"
                >
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Filter Data Buku
                        </h3>

                        <x-secondary-button
                            type="button"
                            x-on:click="openFilter = !openFilter"
                        >
                            <span x-show="!openFilter">Buka Filter</span>
                            <span x-show="openFilter">Tutup Filter</span>
                        </x-secondary-button>
                    </div>

                    <div
                        x-show="openFilter"
                        x-transition
                        class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4"
                    >
                        <form method="GET" action="{{ route('book.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">

                                <div>
                                    <x-input-label for="search" value="Title" />
                                    <x-text-input
                                        id="search"
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Cari judul buku..."
                                        class="mt-1 block w-full"
                                    />
                                </div>

                                <div>
                                    <x-input-label for="author" value="Author" />
                                    <x-text-input
                                        id="author"
                                        type="text"
                                        name="author"
                                        value="{{ request('author') }}"
                                        placeholder="Cari author..."
                                        class="mt-1 block w-full"
                                    />
                                </div>

                                <div>
                                    <x-input-label for="year" value="Year" />
                                    <select
                                        id="year"
                                        name="year"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    >
                                        <option value="">Semua Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="publisher" value="Publisher" />
                                    <select
                                        id="publisher"
                                        name="publisher"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    >
                                        <option value="">Semua Publisher</option>
                                        @foreach ($publishers as $publisher)
                                            <option value="{{ $publisher }}" {{ request('publisher') == $publisher ? 'selected' : '' }}>
                                                {{ $publisher }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="city" value="City" />
                                    <select
                                        id="city"
                                        name="city"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    >
                                        <option value="">Semua Kota</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                                {{ $city }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="bookshelf_id" value="Bookshelf" />
                                    <select
                                        id="bookshelf_id"
                                        name="bookshelf_id"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    >
                                        <option value="">Semua Rak</option>
                                        @foreach ($bookshelves as $bookshelf)
                                            <option value="{{ $bookshelf->id }}" {{ request('bookshelf_id') == $bookshelf->id ? 'selected' : '' }}>
                                                {{ $bookshelf->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="cover_status" value="Cover" />
                                    <select
                                        id="cover_status"
                                        name="cover_status"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
                                    >
                                        <option value="">Semua Cover</option>
                                        <option value="has_cover" {{ request('cover_status') == 'has_cover' ? 'selected' : '' }}>
                                            Ada Cover
                                        </option>
                                        <option value="no_cover" {{ request('cover_status') == 'no_cover' ? 'selected' : '' }}>
                                            Tidak Ada Cover
                                        </option>
                                    </select>
                                </div>

                                <div class="flex items-end gap-2">
                                    <x-primary-button type="submit">
                                        Filter
                                    </x-primary-button>

                                    <x-secondary-button tag="a" href="{{ route('book.index') }}">
                                        Reset
                                    </x-secondary-button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex justify-end m-4">
                    <x-primary-button
                        class="mx-1"
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'import-book')"
                    >Import Book</x-primary-button>

                    <x-primary-button tag="a" href="{{ route('book.export') }}" class="mx-1" target="_blank">
                        Export Book
                    </x-primary-button>
                    <x-primary-button tag="a" href="{{ route('book.print') }}" class="mx-1" target="_blank">
                        Print Book
                    </x-primary-button>
                    <x-primary-button tag="a" href="{{ route('book.create') }}" class="mx-1">
                        Add Book
                    </x-primary-button>
                </div>
                <x-table>
                    <x-slot name="head">
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year</th>
                        <th>Publisher</th>
                        <th>City</th>
                        <th>Cover</th>
                        <th>Bookshelf</th>
                        <th>Actions</th>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->year }}</td>
                                <td>{{ $book->publisher }}</td>
                                <td>{{ $book->city }}</td>
                                <td>
                                    <img src="{{ asset('storage/cover_buku/'. $book->cover) }}" alt="cover" width="100px">
                                    
                                </td>
                                <td>{{ $book->bookshelf->name}}</td>
                                <td>
                                    <x-primary-button tag="a" href="{{ route('book.edit', $book->id) }}">Edit</x-primary-button>
                                    <x-danger-button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-book-deletion')"
                                        x-on:click="$dispatch('set-action', '{{ route('book.destroy', $book->id) }}')"
                                    >Delete</x-danger-button>

                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
    
    <x-modal name="confirm-book-deletion" focusable maxWidth="xl">
        <form method="post" x-bind:action="action" class="p-6">
            @csrf
            @method('delete')
                        
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Apakah anda yakin akan menghapus data?') }}
            </h2>
                        
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Setelah proses dilaksanakan. Data akan dihilangkan secara permanen.') }}
            </p>
                        
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                        
                <x-danger-button class="ml-3">
                    {{ __('Delete!!!') }}
                </x-danger-button>
            </div>
        </form>
        </x-modal>

    <x-modal name="import-book" focusable maxWidth="xl">
        <form method="post" action="{{ route('book.import') }}" class="p-6" enctype="multipart/form-data">
        @csrf
                    
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Import Data Buku') }}
        </h2>

        <div class="max-w-xl">
            <x-input-label for="cover" class="sr-only" value="File Import"/>
            <x-file-input id="cover" name="file" class="mt-1 block w-full" required/>
        </div>
                    
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
                    
            <x-primary-button class="ml-3">
                {{ __('Upload') }}
            </x-primary-button>
        </div>
        </form>
    </x-modal>

</x-app-layout>
