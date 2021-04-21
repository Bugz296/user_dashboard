        <div class="container first user-show">
            <h3><?= $user_details['first_name']." ".$user_details['last_name'] ?></h3>
            <table>
                <tbody>
                    <tr>
                        <td class="col-name">Registered at: </td>
                        <td><?= $user_details['created_at'] ?></td>
                    </tr>
                    <tr>
                        <td class="col-name">User ID: </td>
                        <td><?= $user_details['id'] ?></td>
                    </tr>
                    <tr>
                        <td class="col-name">Email Address: </td>
                        <td><?= $user_details['email'] ?></td>
                    </tr>
                    <tr>
                        <td class="col-name">Description: </td>
                        <td><?= $user_details['description'] ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="msg-cont">
                <h4>Leave a message for <?= $user_details['first_name'] ?></h4>
                <form action="/users/message_user" method="post">
                    <input type="hidden" name="action" value="<?= $user_details['id'] ?>">
                    <textarea name="message"></textarea>
                    <input type="submit" value="Post" class="btn btn-success pull-right">
                </form>
            </div>
<?php   if(!$messages){ ?>
            <p class="no-val">No Message Yet!</p>
<?php   }else{
            foreach($messages as $message){
                if($message['time_diff'] > 1440){
                    $time = $message['created_at'];
                }else if($message['time_diff'] < 1440 && $message['time_diff'] > 59){
                    $time = (floor($message['time_diff']/60))." hours ago";
                }else{
                    $time = ($message['time_diff']%60)." mins ago";
                } ?>

                <div class="msg-com-form">
                    <div class="post-container">
                        <p><strong><?= $message['name'] ?></strong> said ...</p>
                        <p class="time pull-right"><?= $time ?></p>
                        <p class="msg-box"><?= $message['message'] ?></p>
                    </div>
<?php               if($comments){
                        foreach($comments as $msg_id => $comment){
                            if($msg_id == $message['messages_id'] && !empty($comment)){
                                foreach($comment as $com){ 
                                    if($com['time_diff'] > 1440){
                                        $time = $com['created_at'];
                                    }else if($com['time_diff'] < 1440 && $com['time_diff'] > 59){
                                        $time = (floor($com['time_diff']/60))." hours ago";
                                    }else{
                                        $time = ($com['time_diff']%60)." mins ago";
                                    } ?>
                                
                    <div class="post-container comment-box">
                        <p><strong><?= $com['name'] ?></strong> said ...</p>
                        <p class="time pull-right"><?= $time ?></p>
                        <p class="msg-box"><?= $com['comment'] ?></p>
                    </div>                                    
<?php                           }
                            }
                        }
                    } ?>
                    <div id="comment-section">
                        <form action="/users/comment_user/<?=  $user_details['id'] ?>" method="post">
                            <input type="hidden" name="messages_id" value="<?= $message['messages_id'] ?>">
                            <textarea name="comment"></textarea></br>
                            <input type="submit" value="Post" class="btn btn-success">
                        </form>
                    </div>
                </div>
<?php       }
        } ?>
		</div>
	</body>
</html>