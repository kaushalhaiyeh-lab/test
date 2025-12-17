<h1>Our Services</h1>

@foreach ($services as $service)
    <h3>
        <a href="/services/{{ $service->slug }}">
            {{ $service->title }}
        </a>
    </h3>
@endforeach
