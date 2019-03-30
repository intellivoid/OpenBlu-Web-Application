<!DOCTYPE html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <title>Create Intellivoid Account</title>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100">
                    <div class="content-wrapper full-page-wrapper auth-pages option-2">
                        <div class="card col-lg-4">
                            <div class="card-body px-5 py-5">
                                <div class="wrapper w-100">
                                    <h3 class="card-title text-left mb-3">Register</h3>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control p_input">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control p_input">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control p_input">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn">Create Account</button>
                                    </div>
                                    <p class="sign-up text-center">Already have an Account?<a href="#"> Sign Up</a></p>
                                    <p class="terms">By creating an account you are accepting our<a href="#"> Terms & Conditions</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                </div>
                <!-- row ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <?PHP \DynamicalWeb\HTML::importSection('js_scripts'); ?>
    </body>
</html>