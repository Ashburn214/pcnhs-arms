<?php
  require_once "pathconfig.php";
	echo <<<TN
<!-- top navigation -->
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="$base_url/assets/images/icon-user-default.png" alt="">System Administrator
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="$base_url/help.php" target="_blank">Help</a></li>
						<li><a href="https://goo.gl/forms/Db1YtGkquWuIIEeB3" target="_blank">Report an Issue</a></li>
						<li><a href="$base_url/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>
				
			</ul>
		</li>
	</ul>
</nav>
</div>
</div>
<!-- /top navigation -->
TN;
?>