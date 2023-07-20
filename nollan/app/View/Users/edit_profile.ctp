<div class="container-fluid" id="edit_profile_container">
    <section class="validation-errors text-center mt-5">
        <div class="alert customized-alert text-white" role="alert">
            <?php if ($this->Form->isFieldError('User.name') || $this->Form->isFieldError('User.email') || $this->Form->isFieldError('User.password')) : ?>
                <?php echo $this->Form->error('User.name'); ?>
                <?php echo $this->Form->error('User.email'); ?>
                <?php echo $this->Form->error('User.password'); ?>
            <?php endif; ?>
        </div>
        <!-- <div class="alert customized-alert text-white" role="alert">
        </div> -->
    </section>
    <?php
    if (isset($user) && $user) { ?>
        <form action="#" method="POST" id="edit_form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile_img_div col-12 text-center" id="image-preview">
                        <?php if ($user['User']['profile_img'] != null) { ?>
                            <img src="<?= FULL_BASE_URL . '/nollan/app/webroot/img/' . $user['User']['profile_img']; ?>" alt="Image" class="profile_img">
                        <?php } else { ?>
                            <img src="<?= FULL_BASE_URL . '/nollan/app/webroot/img/thumbnail.png' ?>" alt="Image" class="profile_img">
                        <?php } ?>

                    </div>
                    <div class="col-12 text-center mt-3">
                        <input type="file" name="data[User][profile]" id="image-upload" placeholder="Upload Profile" class="btn btn-success">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 align-items-center d-flex">
                    <div class="col-auto">
                        <label class="profile_label"><b>Name:</b></label>
                    </div>
                    <div class="col">
                        <input type="text" id="name" name="data[User][name]" class="form-control edit_input" value="<?= $user['User']['name'] ?>">
                    </div>
                </div>
                <div class="col-lg-12 align-items-center d-flex">
                    <div class="col-auto">
                        <label class="profile_label"><b>Email:</b> </label>
                    </div>
                    <div class="col">
                        <input type="text" name="data[User][email]" id="email" class="form-control edit_input" value="<?= ($user['User']['email']) != null ? $user['User']['email'] : ''; ?>">
                    </div>
                </div>
                <div class="col-lg-12 align-items-center d-flex">
                    <div class="col-auto">
                        <label class="profile_label"><b>Gender:</b></label>
                    </div>
                    <div class="col">
                        <select name="data[User][gender]" id="" class="form-control edit_input">
                            <option value="0" <?= (($user['User']['gender']) == 0 ? 'Selected' : ''); ?> hidden>N/A</option>
                            <option value="1" <?= (($user['User']['gender']) == 1 ? 'Selected' : ''); ?>>Male</option>
                            <option value="2" <?= (($user['User']['gender']) == 2 ? 'Selected' : ''); ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 align-items-center d-flex">
                    <div class="col-auto">
                        <label class="profile_label"><b>Birthdate:</b> </label>
                    </div>
                    <div class="col">
                        <input type="text" name="data[User][birthdate]" id="datepicker" class="form-control edit_input" value="<?= ($user['User']['birthdate']) != null ? date('m/d/Y', strtotime($user['User']['birthdate'])) : ''; ?>">
                    </div>
                </div>
                <div class="col-lg-12">
                    <label class="profile_label"><b>Hubby:</b></label>
                    <textarea name="data[User][hubby]" id="" class="form-control" cols="30" rows="10"><?= ($user['User']['hubby']) != null ? $user['User']['hubby'] : 'N/A'; ?></textarea>
                </div>
                <div class="col-lg-12 text-center mt-4">
                    <button type="submit" class="btn btn-warning update_btn">Update</button>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
<?php unset($user); ?>