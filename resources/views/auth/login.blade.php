<!DOCTYPE html>
<html class="no-js" lang="">

  <head>
    <meta charset="utf-8">
    <title>Sistem Presensi Siswa | SMK Ma'arif NU Tonjong</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('auth/styles/app.min.css') }}"/>
    <link rel="shortcut icon" href="../img/LogoMaarif.jpeg">
 <!-- SweetAlert2 -->
   <link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
   <!-- Toastr -->
   <link rel="stylesheet" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">

  </head>

  <body class="page-loading">
    <!-- page loading spinner -->
    <div class="pageload">
      <div class="pageload-inner">
        <div class="sk-rotating-plane"></div>
      </div>
    </div>
    <!-- /page loading spinner -->
    <div class="app signin v2 usersession">
      <div class="session-wrapper">
        <div class="session-carousel slide" data-ride="carousel" data-interval="3000">
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active" style="background-image:url(../img/smktonjong.jpg);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;">
            </div>
            <div class="item" style="background-image:url(../img/smk.jpg);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;">
            </div>
            <div class="item" style="background-image:url(../img/smktonjong.jpg);background-size:cover;background-repeat: no-repeat;background-position: 50% 50%;">
            </div>
          </div>
        </div>
        <div class="card bg-white  blue no-border" style="background-color:#ffffff;">
          <div class="card-body mb-4">
            <form role="form" class="form-layout" action="{{ route('verify') }}" method="post">
              @csrf
              <div class="text-center mt-5">    
                <img src="../img/LogoMaarif.jpeg"> 
                <h4 class="text-uppercase"><b><font color="#000000">SISTEM PRESENSI SISWA</font></b></h4>
                <h4 class="text-uppercase"><font color="#000000">SMK Ma'arif NU Tonjong</font></h4>
              </div>
              <div class="form-inputs p-b">
                <label class="text-uppercase"><font color="#000000">Username</font></label>
                <input type="username" class="form-control input-lg" name="username" id="username" placeholder="input username" required>
                <label class="text-uppercase"><font color="#000000">Password</font></label>
                <input type="password" class="form-control input-lg" name="password" id="password"  placeholder="input password" required>
              </div>
                
              <button class="btn btn-success btn-block btn-lg" type="submit" name= "login" style="background-color:#0f8c2f;"><font color="#ffffff"><img src="../img/personkey-white.png">&nbsp<b>Login</b></font></button>
          
              <center><font color="#000000"><small><em> Copyright &copy; SMK MA'ARIF NU TONJONG </a></em></</small></font>
            <br/>  
            <font color="#000000"><?php echo date("Y"); ?></</small></font>
              </center>
            </form>
            

          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset("auth/scripts/app.min.js") }}"></script>
  </body>
      <!-- AdminLTE App -->
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
    <script>
      var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
    </script>
  @if (session('loginError'))
  <script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ session('loginError') }}',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    });
  </script>
  @endif


</html>