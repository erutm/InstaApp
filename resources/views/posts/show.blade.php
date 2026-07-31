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

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                
            <!-- Header -->
                <div class="flex items-center gap-3 p-5">

                    <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($post->user->name,0,1)) }}
                    </div>

                    <div>
                        <h3 class="font-bold">
                            {{ $post->user->name }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>

                </div>

                <!-- Gambar -->
                <img
                    src="{{ asset('storage/'.$post->image) }}"
                    alt="Post"
                    class="w-full max-h-[600px] object-contain bg-gray-100">

                <!-- Caption -->
                <div class="px-5 py-4">

                    <p class="text-gray-700 leading-relaxed">
                        {{ $post->caption }}
                    </p>

                </div>

                <!-- Like -->
                <div class="flex items-center gap-6 px-5 py-3 border-t border-gray-100">

                    @if($post->likes()->where('user_id',auth()->id())->exists())

                        <form action="{{ route('posts.unlike',$post) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-2xl hover:scale-110 transition">
                                ❤️
                            </button>

                        </form>

                    @else

                        <form action="{{ route('posts.like',$post) }}" method="POST">
                            @csrf

                            <button class="text-2xl hover:scale-110 transition">
                                🤍
                            </button>

                        </form>

                    @endif

                    <span class="flex items-center gap-2 text-gray-700">
                        ❤️ 
                        
                        <strong>{{ $post->likes->count() }}</strong>

                        Like

                    </span>

                    <span class="flex items-center gap-2 text-gray-700">
                        💬 
                        
                        <strong>{{ $post->comments->count() }}</strong>
                        
                        Komentar

                    </span>

                </div>

                <hr class="my-6">

                <!-- Komentar -->
                <div class="px-5 pb-5">

                    <h3 class="font-semibold text-lg mb-4">
                        Komentar
                    </h3>

                    @forelse($post->comments as $comment)

                        <div class="flex justify-between items-start border-b py-4">

                            <div class="flex gap-3">

                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center font-semibold">

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
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="text-red-500 hover:text-red-700">

                                        Hapus

                                    </button>

                                </form>

                            @endif

                        </div>

                    @empty

                        <div class="text-center text-gray-500 py-5">

                            Belum ada komentar.

                        </div>

                    @endforelse

                </div>

                <!-- Form Komentar -->
                <div class="border-t px-5 py-5">

                    <form
                        action="{{ route('comments.store',$post) }}"
                        method="POST">

                        @csrf

                        <div class="flex gap-3">

                            <input
                                type="text"
                                name="comment"
                                class="flex-1 rounded-xl border-gray-300"
                                placeholder="Tulis komentar..."
                                required>

                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-xl">

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

                <!-- Tombol -->
                <div class="border-t px-5 py-5 flex justify-between">

                    <a
                        href="{{ route('posts.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white px-5 py-2 rounded-xl">

                        Kembali

                    </a>

                    @if(Auth::id() == $post->user_id)

                        <div class="flex gap-2">

                            <a
                                href="{{ route('posts.edit',$post) }}"
                                class="bg-yellow-400 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl">

                                Edit

                            </a>

                            <form
                                action="{{ route('posts.destroy',$post) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus postingan?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-500 hover:bg-red-700 text-white px-5 py-2 rounded-xl">

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