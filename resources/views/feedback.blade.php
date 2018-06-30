@extends('layouts.app')

@section('title', 'Feedback')

@section('content')
<div id="content-page">
    <div class="row">
        <div class="content">
            <div class="xs-1-1">
                <h1 class="sub-header">Let us know what you think</h1>
            </div>
            <div class="xs-1-1">
                <p>Here at Rentt we believe things can always be better (which is why we built Rentt). The only way that we can get better is if our users tell us how we can improve.</p>
                <p>If there is something that Rentt does or doesn't do that you feel needs to change please let us know by filling out the form below. We are still a new company so if you come across anything that doesn't look right or isn't working we would love to hear about those issues to so that we can get them fixed for you.</p>
            </div>
        </div>
    </div>
    <div class="row secondary">
        <div class="content">
            <div class="xs-1-1">
                <h2 class="sub-header">Please fill out the form below</h2>
            </div>
            <div class="xs-1-1">
                <feedback-form></feedback-form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
