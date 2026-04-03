@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">{{ $post->title }}</h1>
                <p class="mt-2 text-sm text-slate-500">By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
            </div>
            <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Back</a>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <p class="whitespace-pre-line text-slate-700 leading-7">{{ $post->content }}</p>

            <div class="mt-8 flex flex-wrap gap-3">
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-amber-400">Edit</a>
                @endcan
            </div>
        </div>
    </div>
@endsection