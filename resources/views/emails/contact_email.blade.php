@extends('components.mail._main')
@section('content')
<div class="col-12">
    <h1>Contacto ANDA</h1>
    <h2>El cliente:{{$contact->name}} intento contactar</h2>
    <h2>Su correo electrónico de contacto es:{{$contact->email}}</h2>
    <h2>Su teléfono:{{$contact->phone}}</h2>
    <h2>Su duda es:{{$contact->message}}</h2>
    <br />
    <div style="text-align: center;">
    </div>
</div>
@endsection
