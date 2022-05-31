@extends('admin.auth.template.main_login')
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
                    <form action="{{route('admin.send.recovery.password')}}" method="POST" class="reset-skew mt-5">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 login-form-group">
                                <label class="login-form-control-label text-login" style="margin-left: -14rem" for="email">Correo electrónico</label>
                                <br>
                                <div class="form-group">
                                    <span><i class="far fa-user"></i></span>
                                    <input class="form-field" type="email" id="email"  name="email" required/>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn-green-login rounded text-white"><b>RECUPERAR CONTRASEÑA</b>
                                </button>
                            </div>

                        </div>
                    </form>
                    <footer class="pt-5">
                        <div class="container mt-5">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-12">
                                    <p class="text-center">
                                        <small class="text-white"> © 2022 Grupo Odontológico Especializado. Todos los derechos reservados | Powered by Satoritech</small>
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
