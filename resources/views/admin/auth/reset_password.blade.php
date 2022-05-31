@extends('admin.auth.template.main_login')
@if(Session::has('resetError'))
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        setTimeout(function () {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error',
                showConfirmButton: '#B29658',
                text: 'Las contraseñas que ingreso no coinciden, por favor vuelva a intentarlo.',
                timer: 10000
            })
        }, 10);
    </script>
@endif

@section('content')
    <div class="container-login">
        <div class="row justify-content-fluid align-items-center">
            <div class="col-6 square-left p-0">
                <img src="{{asset('img/admin/login/login.png')}}" class="img-log" width="100%" alt="">
            </div>
            <div class="col-6 square-right text-center">
                <div class="col-12">
                    <img src="{{asset('img/admin/login/logo_white.png')}}" width="175" alt="" style="width: 23rem;">
                </div>
                <div class="col-12">
                    <form action="{{route('reset.password', ['token'=>$token])}}" method="POST" class="reset-skew mt-5">
                        @csrf
                        <div class="form-row">

                            <div class="col-12 login-form-group">
                                <label class="login-form-control-label text-login" for="password" style="margin-left: -13rem">
                                    NUEVA CONTRASEÑA</label>
                                <br>
                                <div class="form-group">
                                    <span><i class="fas fa-lock"></i></span>
                                    <input class="form-field" type="password"  minlength="8" id="password" placeholder="* * * * * * * *" name="password"
                                           required/>
                                </div>
                            </div>
                            <div class="col-12 login-form-group">
                                <label class="login-form-control-label text-login" for="password" style="margin-left: -13rem">
                                    REPETIR CONTRASEÑA</label>
                                <br>
                                <div class="form-group">
                                    <span><i class="fas fa-lock"></i></span>
                                    <input class="form-field" type="password" minlength="8" id="password-confirm"
                                           name="password-confirm" placeholder="* * * * * * * *"
                                           required/>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn-green-login rounded text-white">
                                    <b>RECUPERAR CONTRASEÑA</b>
                                </button>
                            </div>
                        </div>
                    </form>
                    <footer class="pt-5">
                        <div class="container mt-5">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-12">
                                    <p class="text-center">
                                        <small class="text-white"> © 2022 MJYJ. Todos los derechos reservados | Powered by Satoritech</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
@endsection
