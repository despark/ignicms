@extends('ignicms::admin.layouts.default')

@section('pageTitle', 'Home')

@section('content')
<section id="introduction">
    <div class="titles-section">
        <h1>
            <img src="{{ asset('images/logo.png') }}" alt="Logo" />
        </h1>
        <h2>
            Welcome to Despark Content Managment System
        </h2>
        <p class="subtitle">
            The interface of the CMS is relatively simple and self explanatory. Hope you will enjoy it.
        </p>
    </div>
    <div class="lead">
        <div>
            <p>
                <span class="p-title">Who we are - </span>
                Despark is a team of <strong>curious</strong> thinkers, <strong>fearless</strong> creators and <strong>technical</strong> artisans. We help the world’s dreamers,
                pioneers and entrepreneurs to communicate their vision with the world through innovative technology and to craft
                beautiful products that have disruptive potential.
            </p>
        </div>
        <div>
            <p>
                <span class="p-title">What we do - </span>
                <strong>We create innovative digital products that impact the way people experience the world.</strong>
            </p>
        </div>
        <div>
            <p>
                <span class="p-title">How we do it - </span>
                We bring a startup mentality to our clients through our entrepreneurial, user-centric approach that includes discovery, prototyping and product development.
            </p>
        </div>
    </div>
</section>
@stop
