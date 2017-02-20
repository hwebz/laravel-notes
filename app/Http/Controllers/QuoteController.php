<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Quote;
use App\AuthorLog;
use App\Events\QuoteCreated;
use Illuminate\Support\Facades\Event;

class QuoteController extends Controller
{
    public function getIndex($author = null) {
    	if (!is_null($author)) {
    		$quote_author = Author::where('name', $author)->first();
    		if ($quote_author) {
    			$quotes = $quote_author->quotes()->orderBy('created_at', 'desc')->paginate(8);
    		}
    	} else $quotes = Quote::orderBy('created_at', 'desc')->paginate(8);
    	return view('home', compact('quotes'));
    }

    public function postQuote(Request $request) {

    	$this->validate($request, [
    		'author' => 'required|max:60|alpha',
    		'quote' => 'required|max:500',
            'email' => 'required|email'
    	]);

    	$authorText = ucfirst($request['author']);
    	$quoteText = $request['quote'];
        $emailText = $request['email'];

    	$author = Author::where('name', $authorText)->first();
    	if (!$author) {
    		$author = new Author();
    		$author->name = $authorText;
            $author->email = $emailText;
    		$author->save();
    	}

    	$quote = new Quote();
    	$quote->quote = $quoteText;
    	$author->quotes()->save($quote);

        Event::fire(new QuoteCreated($author));

    	return redirect()->route('index')->with('message', 'Quote saved!');
    }

    public function getDeleteQuote($quote_id) {
    	$quote = Quote::find($quote_id);
    	$author_deleted = false;
    	// $quote = Quote::where('id', $quote_id)->first();
    	if (count($quote->author->quotes) === 1) {
    		$quote->author->delete();
    		$author_deleted = true;
    	}

    	$quote->delete();

    	$msg = $author_deleted ? 'Quote and author deleted!' : 'Quote deleted!';
    	return redirect()->route('index')->with('message', $msg);
    }

    public function getMailCallback($author_name) {
        $author_log = new AuthorLog();
        $author_log->author = $author_name;
        $author_log->save();
        
        return view('email.callback', array('author' => $author_name));
    }
}
