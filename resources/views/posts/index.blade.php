<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('InstaApp') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Upload -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <form action="{{ route('posts.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="block font-medium">
                            Caption
                        </label>

                        <textarea
                            name="caption"
                            class="w-full border rounded mt-2"
                            rows="3"></textarea>

                    </div>

                    <div class="mb-4">

                        <label class="block font-medium">
                            Upload Gambar
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="mt-2">

                    </div>

                    <button
                        class="bg-blue-500 text-white px-4 py-2 rounded">

                        Posting

                    </button>

                </form>

            </div>

            <!-- Daftar Post -->

            @forelse($posts as $post)

                <div class="bg-white shadow rounded-lg p-6 mb-6">

                    <h3 class="font-bold">

                        {{ $post->user->name }}

                    </h3>

                    <p class="text-gray-500 text-sm">

                        {{ $post->created_at->diffForHumans() }}

                    </p>

                    <img
                        src="{{ asset('storage/'.$post->image) }}"
                        class="mt-4 rounded-lg w-full">

                    <p class="mt-4">

                        {{ $post->caption }}

                        <div class="mt-4 flex items-center gap-3">

                        @if($post->likes()->where('user_id', auth()->id())->exists())

                            <form action="{{ route('posts.unlike', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-2xl hover:scale-110 transition">
                                ❤️
                            </button>
                            </form>

                        @else

                            <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf

                            <button class="text-2xl hover:scale-110 transition">
                                🤍
                            </button>
                            </form>

                        @endif

                        <span class="text-gray-600">
                            {{ $post->likes->count() }} Like
                        </span>

                        </div>

                        @if(Auth::id() == $post->user_id)

                        <div class="mt-4 flex gap-2">

                            <a href="{{ route('posts.edit',$post) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">

                                Edit

                            </a>

                            <form action="{{ route('posts.destroy',$post) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus postingan?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="bg-red-600 text-white px-3 py-1 rounded">

                                Hapus

                            </button>

                            </form>

                        </div>

                        @endif

                    </p>

                </div>

            @empty

                <div class="bg-white p-6 rounded shadow">

                    Belum ada postingan.

                </div>

            @endforelse

        </div>
    </div>

</x-app-layout>