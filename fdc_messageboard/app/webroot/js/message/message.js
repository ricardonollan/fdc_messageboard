$(document).ready(function () {

    $(document).on('click', '.contact_name', function () {
        $('#searchResults').html('');
        display_message($(this).attr('data-id'), 1);
    });

    function display_message(user_id, page) {
        $.ajax({
            url: 'view_message',
            method: 'post',
            data: { user_id: user_id, page: page },
            dataType: 'json',
            success: function (response) {
                if (typeof response['messages'] != null || response['messages'] != '') {
                    if (response['messages'].length >= 10) {
                        $('.seemore_btn').removeClass('d-none').attr('data-user', response['contact']['id']);

                    } else {
                        $('.seemore_btn').addClass('d-none').attr('data-user', '');
                    }
                    let info = `<img src="${base_url}/app/webroot/img/${response['contact']['profile_img']}" alt="Image" class="contact_pic ms-4 d-flex">
                    <h3 class="contact_full_name ms-2">${response['contact']['name']}</h3>`;
                    $('.contact_information').html(info);

                    let chatbox = `<textarea name="" rows="4" class="form-control" cols="50" id="message_box" Placeholder="Message"></textarea>
                    <button class="btn btn-success mt-1" id="reply_btn" data-id="${response['contact']['id']}">Reply Message</button>`
                    $('.text-chatbox').html(chatbox);

                    var message_str = seemore_display(response, user_id);
                    $('#message_area').html(message_str);
                    message_page = 1;
                } else {
                    $('.seemore_btn').AddClass('d-none').attr('data-user', '');
                }
            }
        })
    }

    function seemore_display(response, user_id) {
        var message_str = '';
        $.each(response['messages'], function (index, message) {
            var date = new Date(message['sent_date']);

            var sent_date = date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            });
            if (message['message_from'] == user_id) {

                message_str += `<div class="contact_message d-flex mt-2">
                                    <div class="col-lg-1">
                                        <img src="${base_url}/app/webroot/img/${(response['contact']['profile_img']) != '' ? response['contact']['profile_img'] : 'thumbnail.png'}" alt="Image" class="message_pic">
                                    </div>
                                    <div class="col-lg-10">
                                        <p>${message['content']}</p>
                                        <p class="date_sent_text">${sent_date}</p>
                                    </div>
                                    <div class="col-lg-1 action_div">
                                        <div class="dropstart">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><span class="dropdown-item delete_btn" data-user="${response['contact']['id']}" data-id="${message['id']}">Delete</span></li>
                                                <li><span class="dropdown-item delete_all_btn" data-user="${response['contact']['id']}">Delete All</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>`;
            } else {
                message_str += `<div class="my_message d-flex flex-reverse mt-2">
                                    <div class="col-lg-10 my_msg_content text-end">
                                        <p>${message['content']}</p>
                                        <p class="date_sent_text">${sent_date}</p>
                                    </div>
                                    <div class="col-lg-1 my_avatar text-end">
                                        <img src="${base_url}/app/webroot/img/${(response['my_profile']) != '' ? response['my_profile'] : 'thumbnail.png'}" alt="Image" class="message_pic">
                                    </div>
                                    <div class="col-lg-1 action_div">
                                        <div class="dropstart">
                                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><span class="dropdown-item delete_btn" data-user="${response['contact']['id']}" data-id="${message['id']}">Delete</span></li>
                                                <li><span class="dropdown-item delete_all_btn" data-user="${response['contact']['id']}"">Delete All</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>`;
            }
        });
        return message_str;
    }

    $(document).on('click', '.delete_btn', function () {
        let $deleteButton = $(this);
        let message_id = $deleteButton.attr('data-id');
        let user_id = $deleteButton.attr('data-user');

        async function deletemessage() {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this message?",
                icon: "warning",
                dangerMode: true,
                buttons: true, // Setting buttons to true will show both "Cancel" and "OK" buttons.
            });
            if (willDelete) {
                $.ajax({
                    url: 'delete_message',
                    method: 'post',
                    data: { message_id: message_id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            swal("Successful!", response.message, "success");
                            $deleteButton.closest('.my_message').remove();
                            display_message(user_id, 1);
                        } else {
                            swal("Error!", response.message, response.icon);
                        }
                    }
                })
            }
        }
        deletemessage();
    })

    $(document).on('click', '.delete_all_btn', function () {
        let $deleteButton = $(this);
        let user_id = $deleteButton.attr('data-user');
        async function deleteAllmessage() {
            const willDelete = await swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete all the message on this contact?",
                icon: "warning",
                dangerMode: true,
                buttons: true, // Setting buttons to true will show both "Cancel" and "OK" buttons.
            });
            if (willDelete) {
                $.ajax({
                    url: 'deleteAllmessage',
                    method: 'post',
                    data: { user_id: user_id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                            // $deleteButton.closest('.my_message').remove();
                        } else {
                            swal("Error!", response.message, response.icon);
                        }
                    }
                })
            }
        }
        deleteAllmessage();
    })

    $(document).on('click', '#reply_btn', function () {
        let user_id = $(this).attr('data-id');
        if (user_id == null) {
            return false;
        }
        let message = $('#message_box').val();
        if (message == '') {
            return false;
        }
        $.ajax({
            url: 'sent_message',
            method: 'post',
            data: { user_id: user_id, message: message },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    var date = new Date(response.sent_date);

                    var sent_date = date.toLocaleString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                    });
                    $('#message_area').prepend(`<div class="my_message d-flex flex-reverse mt-2">
                    <div class="col-lg-10 my_msg_content text-end">
                        <p>${response.message}</p>
                        <p class="date_sent_text">${sent_date}</p>
                    </div>
                    <div class="col-lg-1 my_avatar text-end">
                        <img src="${base_url}/app/webroot/img/${(response.my_profile) != '' ? response['my_profile'] : 'thumbnail.png'}" alt="Image" class="message_pic">
                    </div>
                    <div class="col-lg-1 action_div">
                        <div class="dropstart">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><span class="dropdown-item delete_btn" data-user="${user_id}" data-id="${response['message_id']}">Delete</span></li>
                                <li><span class="dropdown-item delete_all_btn" data-user="${user_id}"">Delete All</span></li>
                            </ul>
                        </div>
                    </div>
                </div>`);
                    $('#message_box').val('');
                } else {
                    swal("Error!", response.message, "error");
                }
            }
        })
    });

    var message_page = 1; // Track the current page

    $(document).on('click', '.seemore_btn', function () {
        message_page++;
        let user_id = $(this).attr('data-user');
        $.ajax({
            url: 'view_message',
            method: 'post',
            data: { user_id: user_id, page: message_page },
            dataType: 'json',
            success: function (response) {
                if (typeof response['messages'] != null || response['messages'] != '') {
                    let seemore_text = seemore_display(response, user_id);
                    $('#message_area').append(seemore_text);
                }
            }
        });
    })

    $(document).on('click', '.add_new_message', function () {
        $('#reply_btn').attr('data-id', '');
        $('#message_area').html('');
        $('.seemore_btn').addClass('d-none').attr('data-user', '');
        $('.contact_information').html(`<input type="text" class="form-control" id="search_contact" Placeholder="Search Contact"><div id="searchResults"></div>`);
    })
    let searchTimer;
    const searchDelay = 1000;

    $(document).on('input', '#search_contact', function () {
        let search_user = $(this).val();
        clearTimeout(searchTimer);
        if (search_user.trim() !== '') {
            if (search_user.length <= 2) {
                return false;
            }
            searchTimer = setTimeout(function () {
                performSearch(search_user);
            }, searchDelay);
        }
    });

    function performSearch(searchText) {
        $.ajax({
            url: 'search_contact',
            data: { search: searchText },
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                displaySearchResults(response);
            }
        });
    }

    function displaySearchResults(results) {
        $('#searchResults').html('');
        let contacts = '';
        if (results.length > 0) {
            contacts += `<ul>`;
            $.each(results, function (index, contact) {
                contacts += `<li data-id="${contact.User['id']}" class="list_search">
                                <img src="${base_url}/app/webroot/img/${(contact.User['profile_img']) != '' ? contact.User['profile_img'] : 'thumbnail.png'}" alt="Image" class="contact_pic">
                                <p class="d-flex align-items-center">${contact.User['name']}</p>
                                </li>`;
            })
            contacts += `</ul>`;
        } else {
            contacts += `No Results`;
        }
        $('#searchResults').html(contacts);
        $('#searchResults').css('display', 'block');
    }
    const searchInput = $('#search_contact');
    const resultDiv = $('#searchResults');
    const searchContainer = $('.contact_information ');

    // Function to show the result div when the input field gains focus
    $('#search_contact').on('focus', function () {
        $('#searchResults').css('display', 'block');
    });

    // Function to hide the result div when clicking outside the search container
    $(document).on('mouseup', function (event) {
        const target = $(event.target);
        if (!searchContainer.is(target) && searchContainer.has(target).length === 0) {
            $('#searchResults').css('display', 'none');
            if (searchInput.val() === '') {
                $('#searchResults').html('');
            }
        }
    });
    $(document).on('click', '.list_search', function () {
        let user_id = $(this).attr('data-id');
        let $thiselement = $(this);
        let imageSrc = $(this).find('img.contact_pic').attr('src');
        let name =  $(this).find('p').text().trim();

        let info = `<img src="${imageSrc}" alt="Image" class="contact_pic ms-4 d-flex">
                    <h3 class="contact_full_name ms-2">${name}</h3>`;
        
        $('.contact_information').html(info);

        let chatbox = `<textarea name="" rows="4" class="form-control" cols="50" id="message_box" Placeholder="Message"></textarea>
                    <button class="btn btn-success mt-1" id="reply_btn" data-id="${user_id}">Reply Message</button>`
       
        $('.text-chatbox').html(chatbox);
        display_message(user_id, 1);
    })
});
