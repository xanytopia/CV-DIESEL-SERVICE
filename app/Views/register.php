<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
       
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <form class="row g-3 needs-validation" novalidate action="<?= base_url('home/aksiregister') ?>" method="POST" id="loginForm">
    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="<?= base_url('index.html') ?>" class="">
                <h3 class="text-primary">Service</h3>
            </a>
            <h3>Sign Up</h3>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mb-4">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating mb-4">
            <input type="text" name="email" class="form-control" id="floatingPassword" placeholder="email">
            <label for="floatingPassword">Email</label>
        </div>
        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
    </div>
</form>

                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>