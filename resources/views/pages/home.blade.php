@extends('layouts.app')

@section('title', $page->title)

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-20">
        {!! $page->content !!}
    </section>
@endsection
