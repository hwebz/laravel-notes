@extends('layouts.master')

@section('title')
	Trending Quotes
@endsection

@section('content')
	<div class="container">
        @if(!empty(Request::segment(1)))
            <section class="filter-bar">
                A filter has been set! <a href="{{ route('index') }}">Show all quotes</a>
            </section>
        @endif
        @if(count($errors) > 0)
            <section class="info-box fail">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if (Session::has('message'))
            <section class="info-box success">
                {{ Session::get('message') }}
            </section>
        @endif
        <section class="quotes">
            <h1>Latest Quotes</h1>
            
            @if (isset($quotes))
                @foreach($quotes as $key => $quote)
                    <article class="quote {{ $key % 4 === 0 ? 'first-in-line' : (($key + 1) % 4 === 0 ? 'last-in-line' : '') }}">
                        <div class="delete">
                            <a href="{{ route('delete_quote', array('quote_id' => $quote->id)) }}">x</a>
                        </div>
                        {{ $quote->quote }}
                        <div class="info">Created by <a href="{{ route('index', array('author' => $quote->author->name)) }}">{{ $quote->author->name }}</a> on {{ $quote->created_at }}</div>
                    </article>
                @endforeach
                <div class="pagination">
                    @if($quotes->currentPage() !== 1)
                        <a href="{{ $quotes->previousPageUrl() }}"><span class="fa fa-caret-left"></span></a>
                    @endif
                    @if($quotes->currentPage() !== $quotes->lastPage() && $quotes->hasPages())
                        <a href="{{ $quotes->nextPageUrl() }}"><span class="fa fa-caret-right"></span></a>
                    @endif
                </div>
            @endif
        </section>   
        <section class="edit-quote">
            <h1>Add a Quote</h1>
            <form action="{{ route('new_quote') }}" method="post">
                <div class="input-group">
                    <label for="author">Your Name</label>
                    <input type="text" name="author" id="author" placeholder="Your Name" />
                </div>
                <div class="input-group">
                    <label for="email">Your Email</label>
                    <input type="text" name="email" id="email" placeholder="Your Email" />
                </div>
                <div class="input-group">
                    <label for="author">Your Quote</label>
                    <textarea name="quote" id="quote" rows="5" placeholder="Your Name"></textarea>
                </div>
                <button type="submit" class="btn">Submit Quote</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </section>
    </div>
@endsection

@section('scripts')
	
@endsection
