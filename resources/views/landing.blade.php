@extends('layouts.app')

@section('title', 'Hire Smarter with HR Portal')

@section('content')

{{-- HERO --}}
<section class="bg-indigo-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-24 text-center">
        <h1 class="text-4xl md:text-5xl font-bold">
            Smart Hiring & HR Management
        </h1>
        <p class="mt-6 text-lg">
            Manage jobs, services, and recruitment — all in one platform.
        </p>

        <div class="mt-8 space-x-4">
            <a href="/jobs" class="bg-white text-indigo-600 px-6 py-3 rounded font-semibold">
                View Jobs
            </a>
            <a href="/services" class="border border-white px-6 py-3 rounded">
                Our Services
            </a>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="max-w-7xl mx-auto px-6 py-20">
    <h2 class="text-3xl font-bold text-center mb-12">
        Our Services
    </h2>

    <div class="grid md:grid-cols-3 gap-8">
        @foreach ($services as $service)
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold">
                    {{ $service->title }}
                </h3>
                <div class="mt-4 text-sm text-gray-600">
                    {!! Str::limit(strip_tags($service->description), 120) !!}
                </div>

                <a href="/services/{{ $service->slug }}"
                   class="inline-block mt-4 text-indigo-600 font-semibold">
                    Learn more →
                </a>
            </div>
        @endforeach
    </div>
</section>

{{-- JOBS --}}
<section class="bg-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">
            Latest Jobs
        </h2>

        <div class="space-y-4 max-w-3xl mx-auto">
            @foreach ($jobs as $job)
                <div class="bg-white p-5 rounded shadow flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $job->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $job->location }}</p>
                    </div>

                    <a href="/jobs/{{ $job->id }}"
                       class="text-indigo-600 font-semibold">
                        View →
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-indigo-700 text-white py-20 text-center">
    <h2 class="text-3xl font-bold">
        Ready to hire or get hired?
    </h2>
    <p class="mt-4">
        Start using HR Portal today.
    </p>

    <a href="/jobs"
       class="inline-block mt-6 bg-white text-indigo-700 px-8 py-3 rounded font-semibold">
        Get Started
    </a>
</section>

@endsection
