<section class="myform-area">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="form-area register-form">
                <div class="form-content">
                    <h1 class="text-center m-4"><b>Registration</b></h1>
                    <section class="validation-errors">
                        <?php if ($this->Form->isFieldError('User.name') || $this->Form->isFieldError('User.email') || $this->Form->isFieldError('User.password')) : ?>
                            <div class="alert alert-danger customized-alert" role="alert">
                                    <?php echo $this->Form->error('User.name'); ?>
                                    <?php echo $this->Form->error('User.email'); ?>
                                    <?php echo $this->Form->error('User.password'); ?>
                            </div>
                        <?php endif; ?>
                    </section>
                    <form action="/fdc_messageboard/users/register" class="ps-5 pe-5" id="UserRegisterForm" method="post" accept-charset="utf-8">
                        <label for="name">Name</label>
                        <input name="data[User][name]" class="form-control" type="text" value="" id="name">
                        <label for="UserEmail">Email</label>
                        <input name="data[User][email]" class="form-control" maxlength="100" type="email" id="UserEmail">
                        <label for="UserPassword">Password</label>
                        <input name="data[User][password]" class="form-control" type="password" id="UserPassword">
                        <label for="UserConfirmPassword">Confirm Password</label>
                        <input name="data[User][confirm_password]" class="form-control form-error" type="password" id="UserConfirmPassword">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success col-6 text-center">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
