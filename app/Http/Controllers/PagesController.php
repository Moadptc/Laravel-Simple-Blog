<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function dosend(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'body'=>'required|min:10'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $body = $request->input('body');

        Mail::to('mouadptc@gmail.com')
            ->send(new ContactUs($name ,$email ,$subject ,$body));

        return redirect('/contact')->with('success','your message is sent');


    }
}
