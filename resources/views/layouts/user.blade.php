
 <div class="container">

    @if(session()->has('success'))
    <div class="alert alert-success">
        {!! session('success') !!}
    </div>
    @endif

    @if(session()->has('failure'))
    <div class="alert alert-danger">
        Er waren problemen met de invoer van de volgende users:<br>
        {!! session('failure') !!}
    </div>
    @endif

    {!! Form::open(['route' => 'xml.store', 'method' => 'POST', 'files' => true]) !!}

        <div class="form-group">
            {!! Form::file('xml', ['class' => 'form-control']) !!}
            {!! $errors->has('xml', '<p class="text-error">:message</p>') !!}
        </div>

        <div class="form-group">
            {!! Form::select('school', [
                'rocva' => 'ROC van Amsterdam',
                'hva' => 'Hogeschool van Amsterdam'
            ], '', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <button type="submit">Aufslaan</button>
        </div>

    {!! Form::close() !!}
</div>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;

class XmlController extends Controller
{
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
$request->validate([
    'xml' => 'required|file|mimes:xml|max:2048',
    'school' => 'required|in:rocva,hva',
]);

$xmlData = file_get_contents($request->xml);

$xmlObject = new \SimpleXMLElement($xmlData);

$errors = [];

foreach($xmlObject->user as $userData) {
    if(User::where('email', $userData->email)->count()) {
        array_push($errors, $userData);
    }
    else {
        $user = new User;
        $user->name = $userData->name;
        $user->email = $userData->email;
        $user->password = Hash::make($userData->password);
        $user->school = $request->school;
        $user->save();
    }
}
if(count($errors)) {
    return redirect()->back()->with('failure', json_encode($errors));
}

return redirect()->back()->with('success', 'Est is gelukt!');

}
}