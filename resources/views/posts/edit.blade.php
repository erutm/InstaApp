<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Postingan
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

            <form action="{{ route('posts.update',$post) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-4">

                    <label>Caption</label>

                    <textarea
                        name="caption"
                        class="w-full border rounded mt-2"
                        rows="4">{{ old('caption',$post->caption) }}</textarea>

                </div>

                <div class="mb-4">

                    <label>Gambar Saat Ini</label>

                    <img
                        src="{{ asset('storage/'.$post->image) }}"
                        class="w-64 rounded mt-2">

                </div>

                <div class="mb-4">

                    <label>Ganti Gambar</label>

                    <input
                        type="file"
                        name="image"
                        class="mt-2">

                </div>

                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded">

                    Simpan Perubahan

                </button>

                <a href="{{ route('posts.index') }}"
                   class="ml-3">

                    Batal

                </a>

            </form>

        </div>

    </div>

</x-app-layout>