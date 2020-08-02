<!-- Main Header -->
<header class="main-header">

	<!-- Logo -->
	<a href="{{ route('admin.admin') }}" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>A</b>LT</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Admin</b> ABC IDF (V2)</span>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="{{ route('logout') }}">Déconnexion&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-log-out"></i></a>
				</li>
			</ul>
		</div>
	</nav>
</header>