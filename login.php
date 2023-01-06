<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="asset/seal.png">
  <title>Kipoint</title>
  <link rel="stylesheet" href="index.css">
  <script src="jquery.js"></script>
  <script src="plugins/formToJson.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <style>
    .login {
      width: 25vw;
      display: flex;
      flex-direction: column;
      gap: 10px;
      padding-top: 2rem;
    }

    .login > img {
      width: 50%;
      height: auto;
      object-fit: cover;
      align-self: center;
    }

    .backdrop {
      background-color: var(--backdrop);
      width: 100vw;
      height: 100vh;
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 1;
      position: fixed; 
    }
  </style>
  <div class="modal fade" id="alertmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Alert</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Username and password is incorrect
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid d-flex flex-column align-items-center">
    <div class="backdrop">
      <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div class="login">
      <img src="asset/seal.png" class="mb-4">
      <h4>Login</h4>
      <form id="login-form">
        <div class="form-floating mb-3">
          <input required type="text" name="username" class="form-control" placeholder="Username">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mb-3">
          <input required type="password" name="password" class="form-control form-control-sm" placeholder="Password">
          <label for="floatingInput">Password</label>
        </div>
        <button class="btn btn-primary w-100">Login</button>
      </form>
      <button class="btn btn-link btn-sm">Forgot Password?</button>
      <hr>
      <button class="btn btn-outline-dark">Register</button>
    </div>
  </div>

  <script src="index.js"></script>
  <script src="asset/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>