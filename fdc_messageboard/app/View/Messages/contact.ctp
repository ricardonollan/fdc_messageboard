<div class="container-fluid mt-5" id="contact_list">
    <div class="row">
        <div class="col-lg-3">
            <div class="name-list mb-4">
                <button class="btn btn-primary form-control add_new_message">New Message</button>
                <ul class="mt-4">
                    <?php if($messages != null){
                        foreach ($messages as $key => $contact) { ?>
                            <li class="contact_name" data-id="<?= $contact['Users']['id']; ?>">
                                <?php if ($contact['Users']['profile_img'] != null) { ?>
                                    <img src="<?= FULL_BASE_URL . '/fdc_messageboard/app/webroot/img/' . $contact['Users']['profile_img']; ?>" alt="Image" class="contact_pic">
                                <?php } else { ?>
                                    <img src="<?= FULL_BASE_URL . '/fdc_messageboard/app/webroot/img/thumbnail.png' ?>" alt="Image" class="contact_pic">
                                <?php } ?>
                                <img src="" alt="">
                                <b><?= $contact['Users']['name']; ?></b>
                            </li>
                    <?php }
                    } else { ?>
                        <li class=""><b>No Contact(s)</b></li>
                    <?php } ?>
                    
                        
                </ul>
            </div>
        </div>
        <div class="col-lg-9 message-display">
            <div class="col-lg-12 d-flex align-items-center" id="contact_details">
                <div class="contact_information d-flex">
                
                </div>
            </div>
            <br>
            <div class="col-lg-12 text-chatbox">
            
            </div>
            <div class="col-lg-12 mt-5" id="message_area">
                <!-- <div class="col-11 message_content_div">
                
                </div>
                <div class="col-1 action_div">

                </div> -->
            </div>
            <div class="col-lg-12 d-flex align-items-center justify-content-center" id="seemore_div">
                <b class="text-primary seemore_btn d-none">See More</b>
            </div>
        </div>
    </div>
</div>