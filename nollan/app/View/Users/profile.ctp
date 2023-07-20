<h1 class="text-center mt-4"><b>User Profile</b></h1>
<div class="container-fluid" id="view_profile_container">
    <?php foreach ($users as $user) :
        if ($user['User']['id'] == $_SESSION['user_id']) { ?>
            <div class="row mt-5">
                <div class="col-lg-6">
                <?php if ($user['User']['profile_img'] != null) { ?>
                            <img src="<?= FULL_BASE_URL . '/nollan/app/webroot/img/' . $user['User']['profile_img']; ?>" alt="Image" class="view_profile">
                        <?php } else { ?>
                            <img src="<?= FULL_BASE_URL . '/nollan/app/webroot/img/thumbnail.png' ?>" alt="Image" class="view_profile">
                        <?php } ?>
                </div>
                <div class="col-lg-5 mt-5 ms-3">
                    <label class="profile_label"><h3><?= $user['User']['name'] ?></h3></label>
                    <label class="profile_label"><b>Gender:</b> <?= (($user['User']['gender']) != 0 ? ($user['User']['gender'] == 1 ? 'Male':'Female'):'N/A'); ?></label>
                    <label class="profile_label"><b>Birthdate:</b> <?= ($user['User']['birthdate']) != null ? $user['User']['birthdate']: 'N/A'; ?></label>
                    <label class="profile_label"><b>Joined:</b> <?= date('F d, Y H:i a', strtotime($user['User']['joined_date'])) ?></label>
                    <label class="profile_label"><b>Last Login:</b> <?= date('F d, Y H:i a', strtotime($user['User']['last_login'])) ?></label>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <label class="profile_label"><b>Hubby:</b></label>
                    <label><?= ($user['User']['hubby']) != null ? $user['User']['hubby']: 'N/A'; ?></label>
                </div>
            </div>
        <?php } ?>
    <?php endforeach; ?>
</div>
<?php unset($user); ?>