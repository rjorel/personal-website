Hey bro', t'as reçu un message !<br />
<br />
Voilà l'adresse : {{ $request->get('email') }}<br />
<br />
et le message : <br />
--------------- <br />
<br />
{!! nl2br($request->get('message')) !!}