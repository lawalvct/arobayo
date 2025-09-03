@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description)

@section('content')
<div class="page-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-header mb-5">
                    <h1 class="page-title text-center mb-3">{{ $page->title }}</h1>
                    @if($page->meta_description)
                        <p class="page-subtitle text-center text-muted">{{ $page->meta_description }}</p>
                    @endif
                </div>

                <div class="page-body">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.page-content {
    background: #f8f9fa;
    min-height: 60vh;
}

.page-title {
    color: #2596be;
    font-weight: 700;
    font-size: 2.5rem;
}

.page-subtitle {
    font-size: 1.2rem;
    line-height: 1.6;
}

.page-body {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    line-height: 1.8;
}

.page-body h1,
.page-body h2,
.page-body h3 {
    color: #2596be;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.page-body h1 {
    font-size: 2.2rem;
}

.page-body h2 {
    font-size: 1.8rem;
}

.page-body h3 {
    font-size: 1.5rem;
}

.page-body p {
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.page-body ul,
.page-body ol {
    margin-bottom: 1.5rem;
}

.page-body li {
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.page-body a {
    color: #2596be;
    text-decoration: none;
    font-weight: 500;
}

.page-body a:hover {
    color: #1e7a9e;
    text-decoration: underline;
}

.page-body img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 20px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.page-body blockquote {
    background: #f8f9fa;
    border-left: 4px solid #2596be;
    padding: 20px;
    margin: 30px 0;
    border-radius: 5px;
}

.page-body table {
    width: 100%;
    margin: 30px 0;
    border-collapse: collapse;
}

.page-body table th,
.page-body table td {
    padding: 12px;
    border: 1px solid #dee2e6;
    text-align: left;
}

.page-body table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #2596be;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .page-body {
        padding: 25px;
    }

    .page-body h1 {
        font-size: 1.8rem;
    }

    .page-body h2 {
        font-size: 1.5rem;
    }

    .page-body h3 {
        font-size: 1.3rem;
    }
}
</style>
@endsection
