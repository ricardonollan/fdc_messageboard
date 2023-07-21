<section class="myform-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="form-area login-form">
                    <div class="form-content login_form">
                        <h1 class="text-center mt-4"><b>Login</b></h1>
                        <section class="validation-errors text-center">
                            <div class="alert customized-alert" role="alert">
                            </div>
                        </section>
                        <form action="#" class="ps-5 pe-5" id="UserLoginForm" method="post" accept-charset="utf-8">
                            <label for="UserEmail">Email</label>
                            <input name="data[User][email]" class="form-control required" maxlength="100" type="email" id="UserEmail">
                            <label for="UserPassword">Password</label>
                            <input name="data[User][password]" class="form-control required" type="password" id="UserPassword">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-success col-12" type="submit">Login</button>
                                    </div>
                                    <div class="col">
                                        <a href="/fdc_messageboard/users/register" class="btn btn-primary col-12">Register</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>