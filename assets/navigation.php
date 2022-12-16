<section class='navigation'>
	<a href='/zealaf/index.php' class='navLink'>Home</a>
	<a href='/zealaf/public/schedule/index.php' class='navLink'>Schedule</a>
	<a href='/zealaf/public/merch/index.php' class='navLink'>Store</a>
<?php if(isset($_SESSION['hash'])){ ?>
	<a href='/zealaf/public/myUser/' class='navLink'>Profile</a>
	<a href='/zealaf/assets/logout.php' class='navLink'>Logout</a>
<?php } ?>
</section>
