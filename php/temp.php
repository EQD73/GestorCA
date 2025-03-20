<body>
    <div class="container d-flex flex-column">
      <div class="row align-items-center justify-content-center
          min-vh-100">
        <div class="col-12 col-md-8 col-lg-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="mb-4">
                <h5>Forgot Password?</h5>
                <p class="mb-2">Enter your registered email ID to reset the password
                </p>
              </div>
              <form>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" id="email" class="form-control" name="email" placeholder="Enter Your Email"
                    required="">
                </div>
                <div class="mb-3 d-grid">
                  <button type="submit" class="btn btn-primary">
                    Reset Password
                  </button>
                </div>
                <span>Don't have an account? <a href="sign-in.html">sign in</a></span>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>



  <div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center"">      
        <!-- <img src="../images/Logo.png" class="img-fluid" /> -->
        <img src="../images/Logo.png" class="rounded mx-auto d-block" alt="logo">      
    </div>
    <div class="row text-center">
      <div class="col-md-6">
      <p class="h2">Software Gestor de Contenidos</p></div>
    </div>
    <div class="align-self-center w-100 px-lg-4 py-lg-4 p-4" id="login">
      <div class="card shadow-lg-4 border-0 rounded-lg mt-3">
        <div class="card-header">
          <h3 class="text-center font-weight-light my-2">Restablecer Contraseña</h3>
        </div>
        <div class="card-body">
          <form id="form-login" method="POST">
            <div class="form-group">
              <label class="small mb-1" for=" inputemail">Correo de Recuperación</label>
              <div class="input-group-prepend">
                <span class="input-group-text"><span class="fa fa-user"></span></span>
                <input class="form-control" id="inputemail" name="email" type="email" placeholder="Ingrese correo e" autofocus />
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-danger btn-block">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
  </div>