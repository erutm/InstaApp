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

            <!-- Form Upload -->
            <div
    x-data="{ imageUrl: null }"
    class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">

    <h3 class="text-xl font-bold mb-5">
        Buat Postingan Baru
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
                placeholder="Apa yang sedang Anda pikirkan?"
                class="w-full mt-2 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('caption') }}</textarea>

        </div>

        <div class="mb-4">

            <label class="font-medium">
                Upload Gambar
            </label>

            <input
                type="file"
                name="image"
                accept="image/*"
                class="block w-full mt-2"
                @change="imageUrl = URL.createObjectURL($event.target.files[0])">

        </div>

        {{-- Preview --}}

        <template x-if="imageUrl">

            <div class="mb-4">

                <img
                    :src="imageUrl"
                    class="rounded-xl max-h-96 mx-auto shadow">

            </div>

        </template>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">

            Posting Sekarang

        </button>

    </form>

</div>

            <!-- Feed -->
            @forelse($posts as $post)

                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">

                    <!-- Header -->
                    <div class="flex items-center gap-3 p-5">
                    
                    <div
                    class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0">

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
                        alt="Post Image"
                        class="w-full max-h-[550px] object-contain bg-gray-100">

                    <!-- Caption -->
                    <div class="p-5">

                        <p class="text-gray-700 leading-relaxed text-[15px]">

                            {{ $post->caption }}

                        </p>

                    </div>

                    <!-- Like -->
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

                    <!-- Statistik  -->
                    <div class="flex items-center gap-6 px-5 py-3 border-t border-gray-100">

                    <span class="flex items-center gap-2 text-gray-700">

                        ❤️

                    <strong>{{ $post->likes->count() }}</strong>

                        Like

                    </span>

                    <a
                        href="{{ route('posts.show',$post) }}"
                        class="flex items-center gap-2 text-gray-700 hover:text-blue-600">

                        💬

                    <strong>{{ $post->comments->count() }}</strong>

                        Komentar

                    </a>

                    </div>

                    <!-- Preview komentar -->
                    <div class="px-5 pb-5">

                        @if($post->comments->count())

                            @php
                                $lastComment = $post->comments->last();
                            @endphp

                            <p class="mt-2">

                                <span class="font-semibold">

                                    {{ $lastComment->user->name }}

                                </span>

                                {{ $lastComment->comment }}

                            </p>

                        @endif

                        @if($post->comments->count() > 1)

                            <a
                                href="{{ route('posts.show',$post) }}"
                                class="text-gray-500 text-sm hover:text-blue-600">

                                Lihat semua {{ $post->comments->count() }} komentar

                            </a>

                        @endif

                    </div>

                    <!-- Tombol -->
                    <div class="flex gap-2 px-5 py-5 border-t border-gray-100"> </div>
                    <div class="flex gap-2 p-5">

                        <a
                            href="{{ route('posts.show',$post) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                            Lihat Detail

                        </a>

                        @if(Auth::id() == $post->user_id)

                            <a
                                href="{{ route('posts.edit',$post) }}"
                                class="bg-yellow-400 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                                Edit

                            </a>

                            <form
                                action="{{ route('posts.destroy',$post) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus postingan?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded-lg">

                                    Hapus

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-2xl shadow-lg p-10 text-center">

                    <div class="text-6xl">

                        📷

                    </div>

                    <h2 class="text-2xl font-bold mt-4">

                        Belum ada postingan

                    </h2>

                @endforelse

            <div class="mt-8">
                {{ $posts->links() }}
            </div>

        </div>
    </div>

</x-app-layout>