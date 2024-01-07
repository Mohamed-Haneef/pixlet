<?php $userName = Session::get("username"); ?>

<div class="container">
	<div class="row">
		<div class="row d-flex justify-content-center my-5">
			<img src="src/img/pixlet_logo.png" alt="" class="rounded-circle main-logo">
		</div>
		<div class="row d-flex my-5">
			<?php
        if($userName != null) { ?>
			<h1 class="text-info">Welcome, <?php echo $userName?>
			</h1>
			<p class="inline-text">It's been a while.. Share your recent beautiful memories with us.</p>
			<a href="" class="btn blue-bg">Upload photo</a>
			<?php
        } else { ?>
			<h1 class="text-info">Hello, User </h1><br>
			<p class="inline-text">If you are new here, Kindly signup. If you are already a member, Please Login</p>
			<?php }
        ?>


		</div>

	</div>


</div>