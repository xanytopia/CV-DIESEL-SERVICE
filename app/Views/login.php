<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <form class="row g-3 needs-validation" novalidate action="<?= base_url('home/aksi_login') ?>"
                        method="POST" id="loginForm" onsubmit="return validateForm();">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <?php if (!empty($darren2->logo_login)): ?>
                                    <img src="<?= base_url('img/' . $darren2->logo_login) ?>" alt="Login Icon"
                                        class="img-fluid mb-3" style="max-width: 300px; height: auto;">
                                <?php endif; ?>

                            </div>
                            <h3 class="ml-3">Log In</h3>
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" id="floatingInput"
                                    placeholder="Username" required>
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword"
                                    placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>

                            <!-- Google reCAPTCHA -->
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <div id="recaptcha-container" class="g-recaptcha"
                                data-sitekey="6LdFhCAqAAAAALvjUzF22OEJLDFAIsg-k7e-aBeH"></div>

                            <!-- Offline CAPTCHA -->
                            <div id="offline-captcha" style="display:none;">
                                <p>Please enter the characters shown below:</p>
                                <img src="<?= base_url('Home/generateCaptcha') ?>" alt="CAPTCHA">
                                <input type="text" name="backup_captcha" class="form-control mt-2"
                                    placeholder="Enter CAPTCHA" required>
                            </div>


                            <br>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <script>
        function validateForm() {
            var response = grecaptcha.getResponse();
            var backupCaptcha = document.querySelector('input[name="backup_captcha"]').value;
            var isOffline = !navigator.onLine;

            if (isOffline) {
                if (backupCaptcha.length === 0) {
                    alert('Please complete the offline CAPTCHA.');
                    return false;
                }
            } else {
                if (response.length === 0) {
                    alert('Please complete the online CAPTCHA.');
                    return false;
                }
            }
            return true;
        }


        // Handle Offline Mode
        window.addEventListener('load', function () {
            if (!navigator.onLine) {
                document.getElementById('recaptcha-container').style.display = 'none';
                document.getElementById('offline-captcha').style.display = 'block';
            }
        });
    </script>
</body>