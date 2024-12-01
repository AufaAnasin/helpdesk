<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk | BAI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-9/assets/css/login-9.css">
    <style>
        body {
            background-color: #111111; /* Set the background color to white */
        }
        .login-card {
            background-color: #ff6600; /* Orange background color */
            border-radius: 15px; /* Rounded borders */
        }
        .login-card .form-control {
            border-radius: 10px; /* Rounded borders for input fields */
        }
        .login-card .btn-primary {
            background-color: #007BFF; /* Bootstrap Blue for button */
            border-color: #007BFF; /* Bootstrap Blue for button border */
        }
        .login-card .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .margin-container {
          padding-top: 5vh;
        }
    </style>
</head>
<body>
<!-- Login 9 - Bootstrap Brain Component -->
<section class="py-3 py-md-5 py-xl-8">
    <div class="container margin-container">
      <div class="row gy-5 align-items-center">
        <div class="col-12 col-md-6 col-xl-7">
          <div class="d-flex justify-content-center">
            <div class="col-12 col-xl-9">
              <img class="img-fluid rounded mb-4" loading="lazy" src={{ asset('images/bailogo.png') }} width="245" height="80" alt="BAI LOGO">
              <hr class="border-primary-subtle mb-4">
              <h2 style="color: white" class="h1 mb-4">Your Trusted Partner in Technology Support.</h2>
              <p style="color: white" class="lead mb-5">At PT Borneo Alumina Indonesia, we understand that technology is the backbone of your operations. Our dedicated IT Helpdesk is here to ensure that your systems run smoothly, allowing you to focus on what you do best.</p>
              <div class="text-endx">
                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-grip-horizontal" viewBox="0 0 16 16">
                  <path d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-5">
          <div class="card border-0 rounded-4 login-card"> <!-- Added class login-card -->
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="row">
                <div class="col-12">
                  <div class="mb-4">
                    <h3 style="color: white">Sign in</h3>
                  </div>
                </div>
              </div>
              <form action="#!">
                <div class="row gy-3 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                      <label for="email" class="form-label">Email</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                      <label for="password" class="form-label">Password</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                      <label class="form-check-label" style="color: white" for="remember_me" >
                        Keep me logged in
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button class="btn btn-primary btn-lg" type="submit">Log in now</button>
                    </div>
                  </div>
                </div>
              </form>
              <div class="row">
                <div class="col-12">
                  <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                    <a style="color: white;" href="#!">Forgot password</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
