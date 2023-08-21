<?php
    /*
    *Load naviagation partial with logged in sudo session
    */

    $id = $_SESSION['id'];
    $ret="SELECT * FROM  iL_sudo  WHERE id = ? "; 
    $stmt= $mysqli->prepare($ret) ;
    $stmt->bind_param('i', $id);
    $stmt->execute() ;//ok
    $res=$stmt->get_result();
    while($row=$res->fetch_object())
    {
        //set automatically logged in user default image if they have not updated their pics
        if($row->profile_pic == '')
        {
            $profile_picture = "
                <img src='assets/img/avatars/user_icon.png' class='md-user-image' alt='User Image'>
            ";
        }
        else
        {
            $profile_picture = "<img src='assets/img/avatars/sudo/$row->profile_pic' class='md-user-image' alt='User Image'>
            ";
        }

    //Implementation Of Messanges and Notifications

    /*
        Messanges Counter
    */  

    $result ="SELECT count(*) FROM  iL_receivedMails  WHERE sm_receiverName = 'System Admin' ";
    $stmt = $mysqli->prepare($result);
    $stmt->execute();
    $stmt->bind_result($msg_cnt);
    $stmt->fetch();
    $stmt->close();


    /*
        Notifications Counter
    */  
    $id = $_SESSION['id'];
    $result ="SELECT count(*) FROM iL_notifications WHERE user_id = ? ";//get the number of notifications for logged in user
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($notifications_cnt);
    $stmt->fetch();
    $stmt->close();
    
    //total messanges and notifications
    $total_alerts = $msg_cnt + $notifications_cnt;
?>

    <header id="header_main">
            <div class="header_main_content">
                <nav class="uk-navbar">
                                    
                    <!-- main sidebar switch -->
                    <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                        <span class="sSwitchIcon"></span>
                    </a>
                                    
                    <div class="uk-navbar-flip">
                        <ul class="uk-navbar-nav user_actions">
                            <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">fullscreen</i></a></li>
                       
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_image">
                                    <?php echo $profile_picture;?>
                                </a>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav js-uk-prevent">
                                        <li><a href="pages_sudo_profile.php">My profile</a></li>
                                        <li><a href="pages_sudo_settings.php">Settings</a></li>
                                        <li><a href="pages_sudo_logout.php">Log Out</a></li>

                                    </ul>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </nav>
            </div>
    </header>

<?php }?>