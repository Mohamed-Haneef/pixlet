<?php $userName = Session::get("username"); ?>

<div class="container">
    <div class="row">
        <?php
        if($userName != null) { ?>
        <h1 class="text-info">Hello, <?php echo $userName?> </h1>
        <?php
        } else { ?>
        <h1 class="text-info">Hello, User </h1><br>
        <p class="text-white">If you are new here, Kindly signup. If you are already a member, Please Login</p>
        <?php }
        ?>
    </div>
    <div class="row d-flex justify-content-center">
        <img src="src/img/pixlet_logo.png" alt="" class="w-25 main-logo">
    </div>

</div>