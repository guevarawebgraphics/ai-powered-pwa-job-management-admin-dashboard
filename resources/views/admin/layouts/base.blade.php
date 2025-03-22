<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>{!! $seo_meta['title'] !!}</title>

    <meta name="description" content="{!! $seo_meta['description'] !!}">
    <meta name="author" content="{!! $seo_meta['author'] !!}">
    <meta name="robots" content="{!! $seo_meta['robots'] !!}">
    <meta name="keywords" content="{!! $seo_meta['keywords'] !!}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{!! $seo_meta['title'] !!}">
    <meta property="og:description" content="{!! $seo_meta['description'] !!}">
    <meta property="og:url" content="{!! url('') !!}">
    <meta property="og:site_name" content="{!! $seo_meta['name'] !!}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    {{--Icons--}}
    <link rel="shortcut icon" href="{{ asset('public/images/icons/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon57.png') }}" sizes="57x57">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon72.png') }}" sizes="72x72">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon114.png') }}" sizes="114x114">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon144.png') }}" sizes="144x144">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon152.png') }}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon180.png') }}" sizes="180x180">

    {{--Stylesheets--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" class="themes" href="{{ asset('public/css/admin.css') }}">

    @if($admin_template['theme'])
        <link id="theme-link" rel="stylesheet" href="{{ asset('public/css/themes/'.$admin_template['theme'].'.css') }}">
    @endif

    @stack('extrastylesheets')
    <script src="{{asset('public/js/modernizr.min.js')}}"></script>

      
    {{-- for admin control overwrite --}}
    <link rel="stylesheet" class="themes" href="{{ asset('public/css/admin-control.css') }}"> 

    <link rel='stylesheet' href="{{asset('public/css/amsify.suggestags.css')}}">

    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
<style>

    .select2-container .select2-selection--single {
        height: 34px;
    }

    /* Chat button styling */
    #chat-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #05677a;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Modal adjustments */
    .chat-modal {
        min-height: 400px;
    }

    /* User list styling */
    .chat-user-list-item {
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .chat-user-list-item:hover {
        background-color: #f1f1f1;
    }

    /* Chat window */
    #chat-window {
        display: none;
    }


    /* Badge for unread messages */
    .chat-badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
        background-color: #dc3545;
        color: #fff;
    }
</style>

        <style>
            .chat-box {
                display: flex;
                flex-direction: column;
                /* padding: 10px; */
                /* max-width: 400px; */
                margin: auto;
            }
            .chat-message {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }
            .chat-avatar {
                width: 35px;
                height: 35px;
                border-radius: 50%;
            }
            .chat-bubble {
                padding: 10px 15px;
                border-radius: 18px;
                max-width: 75%;
                font-size: 14px;
                margin:.5em .5em;
            }
            .chat-sent {
                justify-content: flex-end;
            }
            .chat-received {
                justify-content: flex-start;
            }
            .chat-bubble-sent {
                background-color: #05677a;
                color: white;
                border-bottom-right-radius: 5px;
            }
            .chat-bubble-received {
                background-color: #f1f1f1;
                color: black;
                border-bottom-left-radius: 5px;
            }
            .no-messages, .error-message {
                text-align: center;
                color: gray;
            }

            #send-message {
                margin-top: 1em;
            }
        </style>


    <script src="{{ asset('public/js/bundle.js') }}"></script>

</head>
<body>



{{--Page Wrapper--}}
{{--In the PHP version you can set the following options from inc/config file--}}
{{--Available classes:--}}

{{--'page-loading'      enables page preloader--}}
<div id="page-wrapper"{!! ($admin_template['page_preloader']) ? ' class="page-loading"' : '' !!}>
    {{--Preloader--}}
    {{--Preloader functionality (initialized in js/app.js) - pageLoading()--}}
    {{--Used only if page preloader is enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version)--}}
    <div class="preloader themed-background">
        <h1 class="push-top-bottom text-light text-center"><strong>{!! $admin_template['name'] !!}</strong></h1>
        <div class="inner">
            <h3 class="text-light visible-lt-ie10"><strong>Loading..</strong></h3>
            <div class="preloader-spinner hidden-lt-ie10"></div>
        </div>
    </div>

    {{--Page Container--}}
    {{--In the PHP version you can set the following options from inc/config file--}}
    {{--Available #page-container classes:--}}

    {{--'' (None)                                       for a full main and alternative sidebar hidden by default (> 991px)--}}

    {{--'sidebar-visible-lg'                            for a full main sidebar visible by default (> 991px)--}}
    {{--'sidebar-partial'                               for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)--}}
    {{--'sidebar-partial sidebar-visible-lg'            for a partial main sidebar which opens on mouse hover, visible by default (> 991px)--}}
    {{--'sidebar-mini sidebar-visible-lg-mini'          for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)--}}
    {{--'sidebar-mini sidebar-visible-lg'               for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)--}}

    {{--'sidebar-alt-visible-lg'                        for a full alternative sidebar visible by default (> 991px)--}}
    {{--'sidebar-alt-partial'                           for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)--}}
    {{--'sidebar-alt-partial sidebar-alt-visible-lg'    for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)--}}

    {{--'sidebar-partial sidebar-alt-partial'           for both sidebars partial which open on mouse hover, hidden by default (> 991px)--}}

    {{--'sidebar-no-animations'                         add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!--}}

    {{--'style-alt'                                     for an alternative main style (without it: the default style)--}}
    {{--'footer-fixed'                                  for a fixed footer (without it: a static footer)--}}

    {{--'disable-menu-autoscroll'                       add this to disable the main menu auto scrolling when opening a submenu--}}

    {{--'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar--}}
    {{--'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar--}}

    {{--'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links--}}
    <?php
    $page_classes = '';

    if ($admin_template['header'] == 'navbar-fixed-top') :
        $page_classes = 'header-fixed-top';
    elseif ($admin_template['header'] == 'navbar-fixed-bottom') :
        $page_classes = 'header-fixed-bottom';
    endif;

    if ($admin_template['sidebar']) :
        $page_classes .= (($page_classes == '') ? '' : ' ') . $admin_template['sidebar'];
    endif;

    if ($admin_template['main_style'] == 'style-alt') :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'style-alt';
    endif;

    if ($admin_template['footer'] == 'footer-fixed') :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'footer-fixed';
    endif;

    if (!$admin_template['menu_scroll']) :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'disable-menu-autoscroll';
    endif;

    if ($admin_template['cookies'] === 'enable-cookies') :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'enable-cookies';
    endif;
    ?>
    <div id="page-container"{!! ($page_classes)? ' class="' . $page_classes . '"' : '' !!}>
        @include('admin.layouts.sections.sidebar')
        <div id="main-container">
            {{--In the PHP version you can set the following options from inc/config file--}}

            {{--Available header.navbar classes:--}}
            {{--'navbar-default'            for the default light header--}}
            {{--'navbar-inverse'            for an alternative dark header--}}
            {{--'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())--}}
            {{--'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added--}}
            {{--'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))--}}
            {{--'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added--}}
            @include('admin.layouts.sections.header')
            <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="page-content" id="page-content">
                @yield('content')
            </div>
            @include('admin.layouts.sections.footer')
        </div>
    </div>
</div>
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>
@include('admin.layouts.sections.modals')
<script>
    var sBaseURI = '{{ url('/') }}';
    var sAdminBaseURI = '{{ url('admin') }}';
    var oPageSections = null;
    var sSettingType = null;
</script>
<script type="text/javascript" src="{{ asset('public/js/admin.js') }}"></script>


<script src='{{asset('public/js/jquery.amsify.suggestags.js')}}'></script>


@stack('extrascripts')
@if (session()->has('flash_message'))
    <script>
        swal({
            title: "{!! session('flash_message.title') !!}",
            text: "{!! session('flash_message.message') !!}",
            type: "{!! session('flash_message.type') !!}",
            html: true,
            allowEscapeKey: true,
            allowOutsideClick: true,
//            confirmButtonColor: "#DD6B55",
        }, function () {

        });
    </script>
@endif


 <script>
    $('.decimal').keypress(function(evt){
        return (/^[0-9]*\.?[0-9]*$/).test($(this).val()+evt.key);
    });
</script>




!-- Chat Button -->
<button id="chat-button">
    💬
</button>
<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Chat Support</h5>
            </div>
            <div class="modal-body chat-modal">
                <!-- User List -->
                <div id="user-list">
                    <h6>Select a user to chat</h6>
                    <div id="users-container">
                        <p>Loading users...</p>
                    </div>
                </div>

                <!-- Chat Window -->
                <div id="chat-window" style="display: none;">
                    <button class="btn btn-sm btn-secondary mb-2" id="back-to-users">← Back</button>
                    <h6 id="chat-user-name"></h6>
                    <div class="chat-box border p-3" style="height: 300px; overflow-y: auto;"></div>

                    <div>
                        <textarea class="form-control mt-2" id="chat-input" placeholder="Type a message..."></textarea>
                        <button class="btn btn-primary mt-5" id="send-message">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


$(document).ready(function() {
        let selectedUserId = null;
        let myId = "{{ auth()->user()->id }}";
        var default_user_thumbnail = "{{ url('public/images/user-thumbnail.jpg') }}";

        // Open chat modal and load users
        $('#chat-button').click(function() {
            $('#chatModal').modal('show');
            loadUsers();
        });

        // Load users dynamically
        function loadUsers() {
            $.ajax({
                url: "{{ url('api/chat-listing', auth()->user()->id) }}",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let usersHtml = "";
                    if (response.data.length > 0) {
                        response.data.forEach(user => {
                            let profilePhoto = user.profile_photo && user.profile_photo.trim() !== "" 
                                ? user.profile_photo 
                                : default_user_thumbnail;

                            let unreadBadge = user.unread_chat_count_to_me > 0 
                                ? `<span class="chat-badge bg-danger ms-2">${user.unread_chat_count_to_me}</span>` 
                                : "";
                            
                            usersHtml += `
                                <div class="chat-user-list-item d-flex align-items-center p-2 border-bottom"
                                    data-id="${user.id}" data-name="${user.name}" data-image="${profilePhoto}">
                                    <img src="${profilePhoto}" class="rounded-circle me-2" width="35" height="35">
                                    <span>${user.name} (${user.email})</span>
                                    ${unreadBadge}
                                </div>`;
                        });
                    } else {
                        usersHtml = "<p>No users found.</p>";
                    }
                    $("#users-container").html(usersHtml);
                },
                error: function() {
                    $("#users-container").html("<p>Error loading users.</p>");
                }
            });
        }

        // Show chat window and load messages when a user is clicked
        $(document).on("click", ".chat-user-list-item", function() {
            selectedUserId = $(this).data("id");
            let userName = $(this).data("name");
            let userImage = $(this).data("image") && $(this).data("image").trim() !== "" 
                ? $(this).data("image") 
                : default_user_thumbnail; // Use default if image is missing

            $("#chat-user-name").text("Chat with " + userName);
            $("#user-list").hide();
            $("#chat-window").show();

            loadChat(selectedUserId, userName, userImage);
        });

        // Load chat messages
        function loadChat(userId, userName, userImage) {
            $.ajax({
                url: `{{ url('/') }}/api/chats/${myId}/${userId}`,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let chatHtml = "";
                    if (response.data.length) {
                        response.data.forEach(chat => {
                            let isMe = chat.from_user_id == myId;
                            let userProfileImg = isMe 
                                ? (`{{ auth()->user()->profile_photo }}` || default_user_thumbnail) 
                                : userImage;

                            chatHtml += `<div class="chat-message ${isMe ? 'chat-sent' : 'chat-received'}">
                                            ${isMe ? '' : `<img src="${userProfileImg}" class="chat-avatar">`}
                                            <div class="chat-bubble ${isMe ? 'chat-bubble-sent' : 'chat-bubble-received'}">
                                                <small>${chat.message}</small>
                                            </div>
                                            ${isMe ? `<img src="${userProfileImg}" class="chat-avatar">` : ''}
                                        </div>`;
                        });
                    } else {
                        chatHtml = "<p class='no-messages'>No messages yet.</p>";
                    }
                    $(".chat-box").html(chatHtml);
                    scrollToBottom();
                },
                error: function() {
                    $(".chat-box").html("<p class='error-message'>Error loading messages.</p>");
                }
            });
        }

        // Auto-scroll chat to latest message
        function scrollToBottom() {
            $(".chat-box").animate({ scrollTop: $(".chat-box")[0].scrollHeight }, 500);
        }

        // Send message
        $("#send-message").click(function() {

            var api_pwa_url = "{{ config('app.frontend_url') }}/api/chat/store";
            let message = $("#chat-input").val().trim();
            if (message === "" || selectedUserId === null) return;

            $.ajax({
                url: api_pwa_url,
                method: "POST",
                data: {
                    from_user_id: myId,
                    to_user_id: selectedUserId,
                    role_id: 0,
                    message: message,
                },
                success: function() {
                    let userProfileImg = `{{ auth()->user()->profile_photo }}` || default_user_thumbnail;
                    
                    $(".chat-box").append(`<div class="chat-message chat-sent">
                                            
                                            <div class="chat-bubble chat-bubble-sent">
                                                <small>${message}</small>
                                            </div>
                                            <img src="${userProfileImg}" class="chat-avatar">
                                        </div>
                    `);
                    $("#chat-input").val(""); // Clear input
                    scrollToBottom();
                },
                error: function() {
                    alert("Error sending message. Please try again.");
                }
            });
        });

        // Back to user list
        $('#back-to-users').click(function() {
            $('#chat-window').hide();
            $('#user-list').show();
        });
    });


</script>

<script>
    
    Echo.channel('chat_sent')
        .listen('ChatSent', (event) => { // ✅ ADD THE DOT BEFORE EVENT NAME
            console.log(event);
    });


</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>
</html>