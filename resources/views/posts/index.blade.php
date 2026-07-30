<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('InstaApp') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form Upload --}}
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">

                <h3 class="text-lg font-semibold mb-4">
                    Buat Postingan
                </h3>

                <form action="{{ route('posts.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="font-medium">
                            Caption
                        </label>

                        <textarea
                            name="caption"
                            rows="3"
                            class="w-full border rounded-lg mt-2 p-3"
                            placeholder="Apa yang sedang Anda pikirkan?"></textarea>

                    </div>

                    <div class="mb-4">

                        <label class="font-medium">
                            Upload Gambar
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="block mt-2">

                    </div>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                        Posting

                    </button>

                </form>

            </div>

            {{-- Feed --}}
            @forelse($posts as $post)

                <div class="bg-white rounded-xl shadow-md mb-8 overflow-hidden">

                    {{-- Header --}}
                    <div class="p-5">

                        <h3 class="font-bold text-lg">

                            {{ $post->user->name }}

                        </h3>

                        <p class="text-sm text-gray-500">

                            {{ $post->created_at->diffForHumans() }}

                        </p>

                    </div>

                    {{-- Gambar --}}
                    <img
                        src="{{ asset('storage/'.$post->image) }}"
                        class="w-full object-cover max-h-[600px]">

                    {{-- Caption --}}
                    <div class="p-5">

                        <p class="text-gray-800">

                            {{ $post->caption }}

                        </p>

                    </div>

                    {{-- Like --}}
                    <div class="px-5 pb-2">

                        @if($post->likes()->where('user_id', auth()->id())->exists())

                            <form action="{{ route('posts.unlike',$post) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="text-2xl hover:scale-110 transition">

                                    ❤️

                                </button>

                            </form>

                        @else

                            <form action="{{ route('posts.like',$post) }}"
                                  method="POST">

                                @csrf

                                <button class="text-2xl hover:scale-110 transition">

                                    🤍

                                </button>

                            </form>

                        @endif

                    </div>

                    {{-- Statistik --}}
                    <div class="px-5 text-sm text-gray-600">

                        <span class="font-medium">
                            ❤️ {{ $post->likes->count() }} Like
                        </span>

                        <span class="mx-3">•</span>

                        <a
                            href="{{ route('posts.show',$post) }}"
                            class="hover:text-blue-600">

                            💬 {{ $post->comments->count() }} Komentar

                        </a>

                    </div>

                    {{-- Preview komentar --}}
                    <div class="px-5 mt-4">

                        @if($post->comments->count())

                            @php
                                $lastComment = $post->comments->last();
                            @endphp

                            <p>

                                <span class="font-semibold">

                                    {{ $lastComment->user->name }}

                                </span>

                                {{ $lastComment->comment }}

                            </p>

                        @endif

                        @if($post->comments->count() > 1)

                            <a
                                href="{{ route('posts.show',$post) }}"
                                class="text-gray-500 text-sm hover:underline">

                                Lihat semua {{ $post->comments->count() }} komentar

                            </a>

                        @endif

                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-2 p-5">

                        <a
                            href="{{ route('posts.show',$post) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                            Detail

                        </a>

                        @if(Auth::id() == $post->user_id)

                            <a
                                href="{{ route('posts.edit',$post) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                                Edit

                            </a>

                            <form
                                action="{{ route('posts.destroy',$post) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus postingan?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">

                                    Hapus

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-xl shadow-md p-6 text-center text-gray-500">

                    Belum ada postingan.

                </div>

            @endforelse

            <div class="mt-8">
                {{ $posts->links() }}
            </div>

        </div>
    </div>

</x-app-layout>