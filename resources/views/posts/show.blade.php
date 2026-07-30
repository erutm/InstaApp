<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Detail Postingan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center gap-4 p-6 border-b">

                    <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr($post->user->name,0,1)) }}
                    </div>

                    <div>
                        <h2 class="font-bold text-lg">
                            {{ $post->user->name }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>

                </div>

                {{-- Gambar --}}
                <img
                    src="{{ asset('storage/'.$post->image) }}"
                    class="w-full object-cover max-h-[650px]">

                {{-- Caption --}}
                <div class="p-6">

                    <p class="text-lg text-gray-800 leading-relaxed">
                        {{ $post->caption }}
                    </p>

                </div>

                {{-- Like --}}
                <div class="px-6 flex items-center gap-5">

                    @if($post->likes()->where('user_id',auth()->id())->exists())

                        <form action="{{ route('posts.unlike',$post) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-3xl hover:scale-110 transition">
                                ❤️
                            </button>

                        </form>

                    @else

                        <form action="{{ route('posts.like',$post) }}" method="POST">
                            @csrf

                            <button class="text-3xl hover:scale-110 transition">
                                🤍
                            </button>

                        </form>

                    @endif

                    <span class="font-medium text-gray-700">
                        ❤️ {{ $post->likes->count() }} Like
                    </span>

                    <span class="font-medium text-gray-700">
                        💬 {{ $post->comments->count() }} Komentar
                    </span>

                </div>

                <hr class="my-6">

                {{-- Komentar --}}
                <div class="px-6">

                    <h3 class="text-xl font-semibold mb-5">
                        Komentar
                    </h3>

                    @forelse($post->comments as $comment)

                        <div class="flex justify-between items-start border-b py-4">

                            <div class="flex gap-3 flex-1">

                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center font-bold">

                                    {{ strtoupper(substr($comment->user->name,0,1)) }}

                                </div>

                                <div>

                                    <div class="font-semibold">

                                        {{ $comment->user->name }}

                                    </div>

                                    <div class="text-gray-700">

                                        {{ $comment->comment }}

                                    </div>

                                </div>

                            </div>

                            @if(Auth::id() == $comment->user_id)

                                <form
                                    action="{{ route('comments.destroy',$comment) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus komentar ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="text-red-500 hover:text-red-700 text-sm">

                                        Hapus

                                    </button>

                                </form>

                            @endif

                        </div>

                    @empty

                        <div class="text-center text-gray-500 py-6">

                            Belum ada komentar.

                        </div>

                    @endforelse

                </div>

                {{-- Form Komentar --}}
                <div class="px-6 py-6 border-t">

                    <form
                        action="{{ route('comments.store',$post) }}"
                        method="POST">

                        @csrf

                        <div class="flex gap-3">

                            <input
                                type="text"
                                name="comment"
                                class="flex-1 border rounded-lg px-4 py-3"
                                placeholder="Tulis komentar..."
                                required>

                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-lg">

                                Kirim

                            </button>

                        </div>

                        @error('comment')

                            <p class="text-red-500 text-sm mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </form>

                </div>

                {{-- Tombol --}}
                <div class="flex justify-between items-center px-6 py-6 border-t">

                    <a
                        href="{{ route('posts.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                        ← Kembali

                    </a>

                    @if(Auth::id() == $post->user_id)

                        <div class="flex gap-3">

                            <a
                                href="{{ route('posts.edit',$post) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg">

                                Edit

                            </a>

                            <form
                                action="{{ route('posts.destroy',$post) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus postingan?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>