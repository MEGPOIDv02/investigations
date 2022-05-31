@extends('components.mail._main')
@section('content')
<div class="col-12">
    <h1>Estás intentando recuperar tu contraseña, si no has sido tú, favor de ignorar este correo.</h1>
    <h2>Si has olvidado tu contraseña, haz click en el siguiente botón.</h2>
    <br />
    <div style="text-align: center;">
        <a class="btn" href="{{route('client_post_password_reset',['token' => $token])}}">Recuperar Contraseña</a>
    </div>
</div>
@endsection
