<?php
require_once(__DIR__.'/gateKeeper.php');

$showInstructorContent = gateCheck(array('3','4','5'));
if($showInstructorContent){ ?>
<section class='proNavigation'>
<a href='/zealaf/protected/user/index.php' class='proNavLink'>Users</a>
<a href='/zealaf/protected/schedule/index.php' class='proNavLink'>Schedules</a>
<?php }
$showManagmentContent = gateCheck(array('4','5'));
if($showManagmentContent){ ?>
<a href='/zealaf/protected/event/index.php' class='proNavLink'>Events</a>
<a href='/zealaf/protected/achievement/index.php' class='proNavLink'>Achievements</a>
<a href='/zealaf/protected/location/index.php' class='proNavLink'>Locations</a>
<a href='/zealaf/protected/space/index.php' class='proNavLink'>Spaces</a>
<a href='/zealaf/protected/merch/index.php' class='proNavLink'>Store</a>
<?php } ?>
</section>
