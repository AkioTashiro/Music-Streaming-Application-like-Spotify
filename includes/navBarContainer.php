<!--Navigation part on the top left side-->

<div id="navBarContainer">
	<nav class="navBar">
		
		<span role="linik" tabindex="0" onclick="openPage('index.php')" class="logo">   <!--when you click the logo, it'll take you back to this page-->
			<img src="assets/images/icons/logo.png">
		</span>

		<div class="group"> <!--where search bar is gonna go  "Search"-->
			<div class="navItem">
				<span role='linik' tabindex='0' onclick='openPage("search.php")' class="navItemLink">
					Search
					<img src="assets/images/icons/search.png" class="icon" alt="Search">
				</span>
			</div>
		</div>

		<div class="group"> <!--where item is gonna go  "Browse, Your Music, Profile"-->
			<div class="navItem">
				<span role="linik" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
			</div>
			<div class="navItem">
				<span role="linik" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
			</div>
			<div class="navItem">
				<span role="linik" tabindex="0" onclick="openPage('setting.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
			</div>
		</div>
		
	</nav>
</div>