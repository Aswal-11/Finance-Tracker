@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Posts</h1>
                <p class="mt-2 text-sm text-slate-500">Browse, edit, and publish posts.</p>
            </div>
            @can('create', App\Models\Post::class)
                <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">Create New Post</a>
            @endcan
        </div>

        @if(session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($posts as $post)
                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">{{ $post->title }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">{{ Str::limit($post->content, 100) }}</p>
                    <p class="mt-4 text-xs uppercase tracking-[0.2em] text-slate-400">By {{ $post->user->name }}</p>

                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="{{ route('posts.show', $post->id) }}" class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">View</a>
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post->id) }}" class="rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">Edit</a>
                        @endcan
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-2xl bg-rose-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-400" onclick="return confirm('Delete this post?')">Delete</button>
                            </form>
                        @endcan
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection