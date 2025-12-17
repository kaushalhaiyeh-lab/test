<h1>Open Jobs</h1>

@foreach ($jobs as $job)
    <h3>
        <a href="/jobs/{{ $job->id }}">
            {{ $job->title }}
        </a>
    </h3>
@endforeach
