@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-20">
        <h1 class="text-4xl font-bold mb-8">{{ $page->title }}</h1>

        {!! $page->content !!}
    </section>
@endsection
