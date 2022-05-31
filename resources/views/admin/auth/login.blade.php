@extends('admin.auth.template.main_login')
@if(Session::has('emailFail'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                showConfirmButton: '#7DAF3C',
                text: 'El correo o contraseña son incorrectos.',
                timer: 10000
            })
        }, 10);
    </script>
@endif
@if(Session::has('emailInactive'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                showConfirmButton: '#7DAF3C',
                text: 'El correo ingresado esta inactivo.',
                timer: 10000
            })
        }, 10);
    </script>
@endif
@if(Session::has('success'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Hecho',
                showConfirmButton: '#7DAF3C',
                text: 'Se le ha enviado un correo de recuperación.',
                timer: 10000
            })
        }, 10);
    </script>
@endif
@if(Session::has('resetSuccess'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Hecho',
                showConfirmButton: '#7DAF3C',
                text: 'Su contraseña ha sido reestablecida con éxito.',
                timer: 10000
            })
        }, 10);
    </script>
@endif
@if(Session::has('error'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                showConfirmButton: '#7DAF3C',
                text: 'El correo que ingreso no está registrado, contacte al administrador',
                timer: 10000
            })
        }, 10);
    </script>
@endif
@if(Session::has('errorMail'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                showConfirmButton: '#7DAF3C',
                text: 'Ocurrio un problema al enviar el correo, por favor vuelva a intentar mas tarde.',
                timer: 10000
            })
        }, 10);
    </script>
@endif
@section('content')
    <div class="container position-relative container-login" style="background-color: black">
        <div class="row justify-content-center align-items-center">
            <div class="col-7 square-left p-5 border-login">
                <img src="{{asset('img/admin/login/max_logo.jpg')}}" class="img-log" width="100%" alt="">
            </div>
            <div class="col-5 square-right text-center">
                <div class="col-12" style="margin-left: -2%">
                    <p class="mt-3 text-white" style="font-size: large"><b>I N I C I A R &nbsp;&nbsp; S E S I Ó N</b></p>
                </div>
                <form action="{{route('admin.authenticate')}}" method="POST" class="reset-skew">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="omrs-input-group">
                            <label class="omrs-input-underlined omrs-input-danger login-form-control-label text-login">
                                <input type="email" id="email" name="email" required
                                       style="height: 3.5rem;width: 18rem;"/>
                                <span class="omrs-input-label">EMAIL</span>
                            </label>
                        </div>
                        <div class="omrs-input-group">
                            <label class="omrs-input-underlined omrs-input-danger login-form-control-label text-login">
                                <input type="password" id="password" name="password" required
                                       style="height: 3.5rem;width: 18rem;"/>
                                <span class="omrs-input-label">CONTRASEÑA</span>
                            </label>
                        </div>
{{--                        <div class="col-12">--}}
{{--                            <a href="{{route('admin.recovery.password')}}" style="font-size: x-small; margin-left: 25%">¿Olvidaste--}}
{{--                                tú contraseña?</a>--}}
{{--                        </div>--}}
                        <div class="col-12 mt-3">
                            <button type="submit" class="bg-blue-light rounded px-5 text-white"
                                    style="width: 15rem;height: 3rem; font-size: medium">INICIAR SESIÓN
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
