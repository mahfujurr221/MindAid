@extends('frontend.layouts.master')

@section('content')
<div class="py-5 about-us-page">
    <div class="container">
        <!-- Page Header -->
        <div class="mb-5 text-center">
            <h1 class="display-4">{{ $aboutUs->title??'' }}</h1>
            @if ($aboutUs->sub_title??'')
                <p class="lead text-muted">{{ $aboutUs->sub_title??'' }}</p>
            @endif
        </div>

        <!-- Short Description -->
        @if ($aboutUs->short_description??'')
            <div class="mb-4 text-center short-description">
                <p>{{ $aboutUs->short_description?? ''}}</p>
            </div>
        @endif

        <!-- Main Description -->
        <div class="mb-5 main-description">
            <h2>About Us</h2>
            <p>{!! nl2br(e($aboutUs->description??'')) !!}</p>
        </div>

        <!-- About the Course -->
        @if ($aboutUs->about_course_desc??'')
            <div class="p-4 rounded about-course bg-light">
                <h3>About Our Course</h3>
                <p>{!! nl2br(e($aboutUs->about_course_desc??'')) !!}</p>
            </div>
        @endif
    </div>
</div>
@endsection
