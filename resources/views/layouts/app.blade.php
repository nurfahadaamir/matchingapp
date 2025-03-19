<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Suka Sama Suka </title>
    
</head>
<body>
<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

    <nav class="site-nav">
    <div class="container">
        <div class="site-navigation">
            <a href="{{ url('/') }}" class="logo m-0">Suka Sama Suka <span class="text-primary">.</span></a>

            <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/') }}">Terma dan Syarat</a></li>
                <li><a href="{{ url('/') }}">Hubungi Kami</a></li>

                @guest
                    <li><a href="{{ url('/login') }}" class="btn btn-primary">Login</a></li>
                @else
                    <!-- Match Dropdown Menu -->
                    <li class="has-children">
                        <a href="#">Match</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('available.matches') }}">Find Match</a></li>
                            <li><a href="{{ route('match.requests') }}">Match Requests</a></li>
                        </ul>
                    </li>

                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <button class="btn btn-primary btn-block dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

            <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
                <span></span>
            </a>
        </div>
    </div>
</nav>


    
    <div class="container-fluid mt-4">
    @yield('content')
   </div>



    <div class="site-footer">
		<div class="inner first">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-4">
						<div class="widget">
							<h3 class="heading">Tentang Suka Sama Suka</h3>
							<p>Aplikasi pertukaran penempatan kakitangan kementerian kesihatan</p>
						</div>
						<div class="widget">
							<ul class="list-unstyled social">
								<li><a href="#"><span class="icon-twitter"></span></a></li>
								<li><a href="#"><span class="icon-instagram"></span></a></li>
								<li><a href="#"><span class="icon-facebook"></span></a></li>
								<li><a href="#"><span class="icon-linkedin"></span></a></li>
								<li><a href="#"><span class="icon-dribbble"></span></a></li>
								<li><a href="#"><span class="icon-pinterest"></span></a></li>
								<li><a href="#"><span class="icon-apple"></span></a></li>
								<li><a href="#"><span class="icon-google"></span></a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-lg-2 pl-lg-5">
						<div class="widget">
							<h3 class="heading">Halaman</h3>
							<ul class="links list-unstyled">
								<li><a href="#">Halamana Utama</a></li>
								<li><a href="#">Terma dan Syarat</a></li>
								<li><a href="#">Hubungi kami</a></li>
								<li><a href="#">Profil</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-lg-2">
						<div class="widget">
							<h3 class="heading">Bahagian Terlibat</h3>
							<ul class="links list-unstyled">
								<li><a href="#">Bahagian Sumber Manusia</a></li>
								<li><a href="#">Bahagian Pengurusan Maklumat</a></li>
								<li><a href="#">Bahagian Kesihatan Digital</a></li>
								<li><a href="#">Health Performance Unit</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-lg-4">
						<div class="widget">
							<h3 class="heading">Hubungi</h3>
							<ul class="list-unstyled quick-info links">
								<li class="email"><a href="#">helpdesk@moh.gov.my</a></li>
								<li class="phone"><a href="#">+03 8000 8000</a></li>
								<li class="address"><a href="#">Kompleks E, Blok E1, E3, E6, E7 & E10, Pusat Pentadbiran Kerajaan Persekutuan, 62590, 
									62000 Putrajaya, Wilayah Persekutuan Putrajaya</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>



		<div class="inner dark">
			<div class="container">
				<div class="row text-center">
					<div class="col-md-8 mb-3 mb-md-0 mx-auto">
						<p>Hakcipta Terpelihara &copy;<script>document.write(new Date().getFullYear());</script> - Kementerian Kesihatan Malaysia
						</p>
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<div id="overlayer"></div>
	<div class="loader">
		<div class="spinner-border" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>
</div>
	<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('js/typed.js') }}"></script>

<script>
    $(function() {
        var slides = $('.slides'),
        images = slides.find('img');

        images.each(function(i) {
            $(this).attr('data-id', i + 1);
        });

        var typed = new Typed('.typed-words', {
            strings: ["Suka"],
            typeSpeed: 80,
            backSpeed: 80,
            backDelay: 4000,
            startDelay: 1000,
            loop: true,
            showCursor: true,
            preStringTyped: (arrayPos, self) => {
                arrayPos++;
                console.log(arrayPos);
                $('.slides img').removeClass('active');
                $('.slides img[data-id="'+arrayPos+'"]').addClass('active');
            }
        });
    });
</script>

<script src="{{ asset('js/custom.js') }}"></script>

@yield('scripts')

</div>
</body>
</html>
