<!-- Main Header -->      
<header class="main-header">
	<!-- Logo -->
    <a href="#" class="logo">Control Panel</a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
	    <a href="#" role="button" data-toggle="offcanvas" class="sidebar-toggle">
		    <span aria-hidden="true" class="glyphicon glyphicon-menu-hamburger">
		    <span class="sr-only">Toggle navigation</span>
	    </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
	            <li><a href="#" class="fa">Setting</a></li>
                <li>{{ link_to('session/end', 'Logout', 'class': 'fa') }}</li>
            </ul>
        </div>
    </nav>
</header>
