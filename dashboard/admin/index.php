<?php
// Sertakan file konfigurasi koneksi ke database
include('../backend/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Zenix - Crypto Admin Dashboard">
	<meta property="og:title" content="Zenix - Crypto Admin Dashboard">
	<meta property="og:description" content="Zenix - Crypto Admin Dashboard">
	<meta property="og:image" content="https://zenix.dexignzone.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	<title>BRIN </title>
	<!-- Favicon icon -->

	<link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
	<link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<script src="https://d3js.org/d3.v6.min.js"></script>
	<script src="https://d3js.org/d3.v7.min.js"></script>
	<script src="https://unpkg.com/d3-simple-slider"></script>



	<style>
		path:hover {
			cursor: pointer;
		}

		/* buat line diagram */
		rect {
			pointer-events: all;
			fill-opacity: 0;
			stroke-opacity: 0;
			z-index: 1;
		}

		.tooltip {
			padding: 5px;
			background-color: rgb(11, 40, 65);
			color: white;
			border: 0px solid white;
			border-radius: 0px;
			display: none;
			opacity: .75;
			font-size: 14px;
		}

		.tooltip-line {
			stroke-opacity: 0.5;
		}

		/* buat horizontal diagram */
		.bubble-chart {
			font-family: Arial, sans-serif;
		}

		.bubble-chart .axis text {
			font-size: 12px;
		}

		.bubble-chart .axis path,
		.bubble-chart .axis line {
			fill: none;
			shape-rendering: crispEdges;
			stroke: #000;
		}

		.bubble-chart .grid-line line {
			stroke: #ccc;
		}
	</style>
</head>

<body>


	<!--**********************************
        Main wrapper start
    ***********************************-->
	<div id="main-wrapper">

		<!--**********************************
            Nav header start
        ***********************************-->
		<div class="nav-header">
			<a href="index.php" class="brand-logo">
				<img src="../images/brin.png" alt="" width="120px" style="margin-left: 47px;">
			</a>

			<div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>

		</div>
		<!--**********************************
            Nav header end
        ***********************************-->


		<!--**********************************
            Header start
        ***********************************-->
		<div class="header">
			<div class="header-content">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-between">
						<div class="header-left">
							<div class="input-group search-area right d-lg-inline-flex d-none">
								<input type="text" class="form-control" placeholder="Find something here...">
								<div class="input-group-append">
									<span class="input-group-text">
										<a href="javascript:void(0)">
											<i class="flaticon-381-search-2"></i>
										</a>
									</span>
								</div>
							</div>
						</div>
						<ul class="navbar-nav header-right main-notification">
							<li class="nav-item dropdown notification_dropdown">
								<a class="nav-link bell dz-theme-mode" href="#">
									<i id="icon-light" class="fa fa-sun-o"></i>
									<i id="icon-dark" class="fa fa-moon-o"></i>
								</a>
							</li>
							<li class="nav-item dropdown notification_dropdown">
								<a class="nav-link bell dz-fullscreen" href="#">
									<svg id="icon-full" viewbox="0 0 24 24" width="20" height="20" stroke="currentColor"
										stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
										class="css-i6dzq1">
										<path
											d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"
											style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path>
									</svg>
									<svg id="icon-minimize" width="20" height="20" viewbox="0 0 24 24" fill="none"
										stroke="currentColor" stroke-width="2" stroke-linecap="round"
										stroke-linejoin="round" class="feather feather-minimize">
										<path
											d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"
											style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path>
									</svg>
								</a>
							</li>
							<li class="nav-item dropdown notification_dropdown">
								<a class="nav-link bell bell-link" href="javascript:void(0)">
									<svg width="24" height="24" viewbox="0 0 28 28" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M22.4605 3.84888H5.31688C4.64748 3.84961 4.00571 4.11586 3.53237 4.58919C3.05903 5.06253 2.79279 5.7043 2.79205 6.3737V18.1562C2.79279 18.8256 3.05903 19.4674 3.53237 19.9407C4.00571 20.4141 4.64748 20.6803 5.31688 20.6811C5.54005 20.6812 5.75404 20.7699 5.91184 20.9277C6.06964 21.0855 6.15836 21.2995 6.15849 21.5227V23.3168C6.15849 23.6215 6.24118 23.9204 6.39774 24.1818C6.5543 24.4431 6.77886 24.6571 7.04747 24.8009C7.31608 24.9446 7.61867 25.0128 7.92298 24.9981C8.22729 24.9834 8.52189 24.8863 8.77539 24.7173L14.6173 20.8224C14.7554 20.7299 14.918 20.6807 15.0842 20.6811H19.187C19.7383 20.68 20.2743 20.4994 20.7137 20.1664C21.1531 19.8335 21.4721 19.3664 21.6222 18.8359L24.8966 7.05011C24.9999 6.67481 25.0152 6.28074 24.9414 5.89856C24.8675 5.51637 24.7064 5.15639 24.4707 4.84663C24.235 4.53687 23.931 4.28568 23.5823 4.11263C23.2336 3.93957 22.8497 3.84931 22.4605 3.84888ZM23.2733 6.60304L20.0006 18.3847C19.95 18.5614 19.8432 18.7168 19.6964 18.8275C19.5496 18.9381 19.3708 18.9979 19.187 18.9978H15.0842C14.5856 18.9972 14.0981 19.1448 13.6837 19.4219L7.84171 23.3168V21.5227C7.84097 20.8533 7.57473 20.2115 7.10139 19.7382C6.62805 19.2648 5.98628 18.9986 5.31688 18.9978C5.09371 18.9977 4.87972 18.909 4.72192 18.7512C4.56412 18.5934 4.4754 18.3794 4.47527 18.1562V6.3737C4.4754 6.15054 4.56412 5.93655 4.72192 5.77874C4.87972 5.62094 5.09371 5.53223 5.31688 5.5321H22.4605C22.5905 5.53243 22.7188 5.56277 22.8353 5.62076C22.9517 5.67875 23.0532 5.76283 23.1318 5.86646C23.2105 5.97008 23.2642 6.09045 23.2887 6.21821C23.3132 6.34597 23.308 6.47766 23.2733 6.60304Z"
											fill="#EB8153"></path>
										<path d="M7.84173 11.4233H12.0498C12.273 11.4233 12.4871 11.3347 12.6449 11.1768C12.8027 11.019 12.8914 10.8049 12.8914 10.5817C12.8914 10.3585 12.8027 10.1444 12.6449 9.98661C12.4871 9.82878 12.273 9.74011 12.0498 9.74011H7.84173C7.61852 9.74011 7.40446 9.82878 7.24662 9.98661C7.08879 10.1444 7.00012 10.3585 7.00012 10.5817C7.00012 10.
										8049 7.08879 11.019 7.24662 11.1768C7.40446 11.3347 7.61852 11.4233 7.84173 11.4233Z" fill="#EB8153"></path>
										<path
											d="M15.4162 13.1066H7.84173C7.61852 13.1066 7.40446 13.1952 7.24662 13.3531C7.08879 13.5109 7.00012 13.725 7.00012 13.9482C7.00012 14.1714 7.08879 14.3855 7.24662 14.5433C7.40446 14.7011 7.61852 14.7898 7.84173 14.7898H15.4162C15.6394 14.7898 15.8535 14.7011 16.0113 14.5433C16.1692 14.3855 16.2578 14.1714 16.2578 13.9482C16.2578 13.725 16.1692 13.5109 16.0113 13.3531C15.8535 13.1952 15.6394 13.1066 15.4162 13.1066Z"
											fill="#EB8153"></path>
									</svg>
								</a>
							</li>
							<li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="../images/profile/pic1.jpg" width="20" alt="">
									<div class="header-info">
										<span>admin</span>
										<small>Super admin</small>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="app-profile.html" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="localhost:8080/test/perpustakaan/admin/logout.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
						</ul>
					</div>
				</nav>
				<br>
			</div>
		</div>
		<!--**********************************
            Header end ti-comment-alt
        ***********************************-->

		<!--**********************************
            Sidebar start
        ***********************************-->
		<div class="deznav">
            <div class="deznav-scroll">
				<!-- <div class="main-profile">
					<div class="image-bx">
						<img src="images/Untitled-1.jpg" alt="">
						<a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i></a>
					</div>
					<h5 class="name"><span class="font-w400">Hello,</span> Marquez</h5>
					<p class="email"><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="95f8f4e7e4e0f0efefefefd5f8f4fcf9bbf6faf8">[email&#160;protected]</a></p>
				</div> -->
				<ul class="metismenu" id="menu">
					<li class="nav-label first">Main Menu</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-144-layout"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                        <ul aria-expanded="false">
							<li><a href="index.html">Dashboard Light</a></li>
							<li><a href="index-2.html">Dashboard Dark</a></li>
							<li><a href="my-wallets.html">Wallet</a></li>
							<li><a href="tranasactions.html">Transactions</a></li>
							<li><a href="coin-details.html">Coin Details</a></li>
							<li><a href="portofolio.html">Portofolio</a></li>
							<li><a href="market-capital.html">Market Capital</a></li>
						</ul>

                    </li>
					<li class="nav-label">Apps</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
						<i class="flaticon-077-menu-1"></i>
							<span class="nav-text">Apps</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="app-profile.html">Profile</a></li>
							<li><a href="post-details.html">Post Details</a></li>
							<li><a href="page-chat.html">Chat<span class="badge badge-xs badge-danger">New</span></a></li>
							<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Project<span class="badge badge-xs badge-danger">New</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="project-list.html">Project List</a></li>
                                    <li><a href="project-card.html">Project Card</a></li>
                                </ul>
                            </li>
							<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">User<span class="badge badge-xs badge-danger">New</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="user-list-datatable.html">User List</a></li>
                                    <li><a href="user-list-column.html">User Card</a></li>
                                </ul>
                            </li>
							<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Contact<span class="badge badge-xs badge-danger">New</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="contact-list.html">Contact List</a></li>
                                    <li><a href="contact-card.html">Contact Card</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Email</a>
                                <ul aria-expanded="false">
                                    <li><a href="email-compose.html">Compose</a></li>
                                    <li><a href="email-inbox.html">Inbox</a></li>
                                    <li><a href="email-read.html">Read</a></li>
                                </ul>
                            </li>
                            <li><a href="app-calender.html">Calendar</a></li>
							<li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Shop</a>
                                <ul aria-expanded="false">
                                    <li><a href="ecom-product-grid.html">Product Grid</a></li>
									<li><a href="ecom-product-list.html">Product List</a></li>
									<li><a href="ecom-product-detail.html">Product Details</a></li>
									<li><a href="ecom-product-order.html">Order</a></li>
									<li><a href="ecom-checkout.html">Checkout</a></li>
									<li><a href="ecom-invoice.html">Invoice</a></li>
									<li><a href="ecom-customers.html">Customers</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
					
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-061-puzzle"></i>
							<span class="nav-text">Charts</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="chart-flot.html">Flot</a></li>
                            <li><a href="chart-morris.html">Morris</a></li>
                            <li><a href="chart-chartjs.html">Chartjs</a></li>
                            <li><a href="chart-chartist.html">Chartist</a></li>
                            <li><a href="chart-sparkline.html">Sparkline</a></li>
                            <li><a href="chart-peity.html">Peity</a></li>
                        </ul>
                    </li>
					<li class="nav-label">components</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-003-diamond"></i>
							<span class="nav-text">Bootstrap</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="ui-accordion.html">Accordion</a></li>
                            <li><a href="ui-alert.html">Alert</a></li>
                            <li><a href="ui-badge.html">Badge</a></li>
                            <li><a href="ui-button.html">Button</a></li>
                            <li><a href="ui-modal.html">Modal</a></li>
                            <li><a href="ui-button-group.html">Button Group</a></li>
                            <li><a href="ui-list-group.html">List Group</a></li>
                            <li><a href="ui-media-object.html">Media Object</a></li>
                            <li><a href="ui-card.html">Cards</a></li>
                            <li><a href="ui-carousel.html">Carousel</a></li>
                            <li><a href="ui-dropdown.html">Dropdown</a></li>
                            <li><a href="ui-popover.html">Popover</a></li>
                            <li><a href="ui-progressbar.html">Progressbar</a></li>
                            <li><a href="ui-tab.html">Tab</a></li>
                            <li><a href="ui-typography.html">Typography</a></li>
                            <li><a href="ui-pagination.html">Pagination</a></li>
                            <li><a href="ui-grid.html">Grid</a></li>

                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-053-heart"></i>
							<span class="nav-text">Plugins</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="uc-select2.html">Select 2</a></li>
                            <li><a href="uc-nestable.html">Nestedable</a></li>
                            <li><a href="uc-noui-slider.html">Noui Slider</a></li>
                            <li><a href="uc-sweetalert.html">Sweet Alert</a></li>
                            <li><a href="uc-toastr.html">Toastr</a></li>
                            <li><a href="map-jqvmap.html">Jqv Map</a></li>
							<li><a href="uc-lightgallery.html">Light Gallery</a></li>
                        </ul>
                    </li>
                    <li><a href="widget-basic.html" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-settings-2"></i>
							<span class="nav-text">Widget</span>
						</a>
					</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-044-file"></i>
							<span class="nav-text">Forms</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="form-element.html">Form Elements</a></li>
                            <li><a href="form-wizard.html">Wizard</a></li>
                            <li><a href="form-editor-summernote.html">Summernote</a></li>
                            <li><a href="form-pickers.html">Pickers</a></li>
                            <li><a href="form-validation-jquery.html">Jquery Validate</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-network"></i>
							<span class="nav-text">Table</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
                            <li><a href="table-datatable-basic.html">Datatable</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-049-copy"></i>
							<span class="nav-text">Pages</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="page-register.html">Register</a></li>
                            <li><a href="page-login.html">Login</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                                <ul aria-expanded="false">
                                    <li><a href="page-error-400.html">Error 400</a></li>
                                    <li><a href="page-error-403.html">Error 403</a></li>
                                    <li><a href="page-error-404.html">Error 404</a></li>
                                    <li><a href="page-error-500.html">Error 500</a></li>
                                    <li><a href="page-error-503.html">Error 503</a></li>
                                </ul>
                            </li>
                            <li><a href="page-lock-screen.html">Lock Screen</a></li>
                        </ul>
                    </li>
                </ul>
				<div class="copyright">
					<p><strong>Zenix Crypto Admin Dashboard</strong> © 2021 All Rights Reserved</p>
					<p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
				</div>
			</div>
        </div>
		<!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
		<div class="content-body">
			<div class="container-fluid">
				<div class="form-head d-flex flex-wrap align-items-center">
					<h3 class="font-w600 title mb-2 mr-auto ">Dashboard</h3>
				</div>
				<div class="row">
					<div class="col-xl-3 col-sm-6 m-t35">
						<div class="card card-coin">
							<div class="card-body text-center">
								<svg class="mb-3 currency-icon" width="80" height="80" viewbox="0 0 80 80" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<circle cx="40" cy="40" r="40" fill="white"></circle>
									<path
										d="M40.725 0.00669178C18.6241 -0.393325 0.406678 17.1907 0.00666126 39.275C-0.393355 61.3592 17.1907 79.5933 39.2749 79.9933C61.3592 80.3933 79.5933 62.8093 79.9933 40.7084C80.3933 18.6241 62.8092 0.390041 40.725 0.00669178ZM39.4083 72.493C21.4909 72.1597 7.17362 57.3257 7.50697 39.4083C7.82365 21.4909 22.6576 7.17365 40.575 7.49033C58.5091 7.82368 72.8096 22.6576 72.493 40.575C72.1763 58.4924 57.3257 72.8097 39.4083 72.493Z"
										fill="#00ADA3"></path>
									<path
										d="M40.5283 10.8305C24.4443 10.5471 11.1271 23.3976 10.8438 39.4816C10.5438 55.549 23.3943 68.8662 39.4783 69.1662C55.5623 69.4495 68.8795 56.599 69.1628 40.5317C69.4462 24.4477 56.6123 11.1305 40.5283 10.8305ZM40.0033 19.1441L49.272 35.6798L40.8133 30.973C40.3083 30.693 39.6966 30.693 39.1916 30.973L30.7329 35.6798L40.0033 19.1441ZM40.0033 60.8509L30.7329 44.3152L39.1916 49.022C39.4433 49.162 39.7233 49.232 40.0016 49.232C40.28 49.232 40.56 49.162 40.8117 49.022L49.2703 44.3152L40.0033 60.8509ZM40.0033 45.6569L29.8296 39.9967L40.0033 34.3364L50.1754 39.9967L40.0033 45.6569Z"
										fill="#00ADA3"></path>
								</svg>
								<h2 class="text-black mb-2 font-w600">
									<?php
										$sql    ="SELECT * FROM biblio";
										$query    =mysqli_query($conn, $sql);
										$data    =array();
										while(($row    =mysqli_fetch_array($query)) != null){
											$data[] =$row;
										}
										$count    =count($data);
										echo " $count";
									?>
								</h2>
								<p class="mb-0 fs-14">

									<span class="text-success mr-1"></span>Total buku
								</p>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 m-t35">
						<div class="card card-coin">
							<div class="card-body text-center">
								<svg class="mb-3 currency-icon" width="80" height="80" viewbox="0 0 80 80" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<circle cx="40" cy="40" r="40" fill="white"></circle>
									<path
										d="M40 0C17.9083 0 0 17.9083 0 40C0 62.0917 17.9083 80 40 80C62.0917 80 80 62.0917 80 40C80 17.9083 62.0917 0 40 0ZM40 72.5C22.0783 72.5 7.5 57.92 7.5 40C7.5 22.08 22.0783 7.5 40 7.5C57.9217 7.5 72.5 22.0783 72.5 40C72.5 57.9217 57.92 72.5 40 72.5Z"
										fill="#FFAB2D"></path>
									<path
										d="M42.065 41.2983H36.8133V49.1H42.065C43.125 49.1 44.1083 48.67 44.7983 47.9483C45.52 47.2566 45.95 46.275 45.95 45.1833C45.9517 43.0483 44.2 41.2983 42.065 41.2983Z"
										fill="#FFAB2D"></path>
									<path
										d="M40 10.8333C23.9167 10.8333 10.8333 23.9166 10.8333 40C10.8333 56.0833 23.9167 69.1666 40 69.1666C56.0833 69.1666 69.1667 56.0816 69.1667 40C69.1667 23.9183 56.0817 10.8333 40 10.8333ZM45.935 53.5066H42.495V58.9133H38.8867V53.5066H36.905V58.9133H33.28V53.5066H26.9067V50.1133H30.4233V29.7799H26.9067V26.3866H33.28V21.0883H36.905V26.3866H38.8867V21.0883H42.495V26.3866H45.6283C47.3783 26.3866 48.9917 27.1083 50.1433 28.26C51.295 29.4116 52.0167 31.025 52.0167 32.775C52.0167 36.2 49.3133 38.995 45.935 39.1483C49.8967 39.1483 53.0917 42.3733 53.0917 46.335C53.0917 50.2816 49.8983 53.5066 45.935 53.5066Z"
										fill="#FFAB2D"></path>
									<path
										d="M44.385 36.5066C45.015 35.8766 45.3983 35.0316 45.3983 34.08C45.3983 32.1916 43.8633 30.655 41.9733 30.655H36.8133V37.52H41.9733C42.91 37.52 43.77 37.12 44.385 36.5066Z"
										fill="#FFAB2D"></path>
								</svg>
								<h2 class="text-black mb-2 font-w600">
									<?php
										$sql    ="SELECT * FROM member";
										$query    =mysqli_query($conn, $sql);
										$data    =array();
										while(($row    =mysqli_fetch_array($query)) != null){
											$data[] =$row;
										}
										$count    =count($data);
										echo " $count";
									?>
								</h2>
								<p class="mb-0 fs-13">
									<span class="text-success mr-1"></span> Total Member
								</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 m-t35">
						<div class="card card-coin">
							<div class="card-body text-center">
								<svg class="mb-3 currency-icon" width="80" height="80" viewbox="0 0 80 80" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<circle cx="40" cy="40" r="40" fill="white"></circle>
									<path
										d="M40.725 0.00669178C18.6241 -0.393325 0.406678 17.1907 0.00666126 39.275C-0.393355 61.3592 17.1907 79.5933 39.2749 79.9933C61.3592 80.3933 79.5933 62.8093 79.9933 40.7084C80.3933 18.6241 62.8092 0.390041 40.725 0.00669178ZM39.4083 72.493C21.4909 72.1597 7.17362 57.3257 7.50697 39.4083C7.82365 21.4909 22.6576 7.17365 40.575 7.49033C58.5091 7.82368 72.8096 22.6576 72.493 40.575C72.1763 58.4924 57.3257 72.8097 39.4083 72.493Z"
										fill="#374C98"></path>
									<path
										d="M40.5283 10.8305C24.4443 10.5471 11.1271 23.3976 10.8438 39.4816C10.5438 55.549 23.3943 68.8662 39.4783 69.1662C55.5623 69.4495 68.8795 56.599 69.1628 40.5317C69.4462 24.4477 56.6123 11.1305 40.5283 10.8305ZM52.5455 56.9324H26.0111L29.2612 38.9483L25.4944 39.7317V36.6649L29.8279 35.7482L32.6447 20.2809H43.2284L40.8283 33.4481L44.5285 32.6647V35.7315L40.2616 36.6149L37.7949 50.2154H54.5122L52.5455 56.9324Z"
										fill="#374C98"></path>
								</svg>
								<h2 class="text-black mb-2 font-w600">
									<?php
										$sql    ="SELECT * FROM user";
										$query    =mysqli_query($conn, $sql);
										$data    =array();
										while(($row    =mysqli_fetch_array($query)) != null){
											$data[] =$row;
										}
										$count    =count($data);
										echo " $count";
									?>
								</h2>
								<p class="mb-0 fs-14">
									<span class="text-danger mr-1"></span>Total Admin
								</p>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 m-t35">
						<div class="card card-coin">
							<div class="card-body text-center">
								<svg class="mb-3 currency-icon" width="80" height="80" viewbox="0 0 80 80" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<circle cx="40" cy="40" r="40" fill="white"></circle>
									<path
										d="M40.725 0.00669178C18.6241 -0.393325 0.406708 17.1907 0.00669178 39.275C-0.393325 61.3592 17.1907 79.5933 39.275 79.9933C61.3592 80.3933 79.5933 62.8093 79.9933 40.7084C80.3933 18.6241 62.8093 0.390041 40.725 0.00669178ZM39.4083 72.493C21.4909 72.1597 7.17365 57.3257 7.507 39.4083C7.82368 21.4909 22.6576 7.17365 40.575 7.49033C58.5091 7.82368 72.8097 22.6576 72.493 40.575C72.1763 58.4924 57.3257 72.8097 39.4083 72.493Z"
										fill="#FF782C"></path>
									<path
										d="M40.525 10.8238C24.441 10.5405 11.1238 23.391 10.8405 39.475C10.7455 44.5352 11.9605 49.3204 14.1639 53.5139H23.3326V24.8027C23.3326 23.0476 25.7177 22.4893 26.4928 24.0643L40 51.4171L53.5072 24.066C54.2822 22.4893 56.6674 23.0476 56.6674 24.8027V53.5139H65.8077C67.8578 49.6171 69.0779 45.2169 69.1595 40.525C69.4429 24.441 56.609 11.1238 40.525 10.8238Z"
										fill="#FF782C"></path>
									<path
										d="M53.3339 55.1806V31.943L41.4934 55.919C40.9334 57.0574 39.065 57.0574 38.5049 55.919L26.6661 31.943V55.1806C26.6661 56.1007 25.9211 56.8474 24.9994 56.8474H16.2474C21.4326 64.1327 29.8629 68.9795 39.475 69.1595C49.4704 69.3362 58.3908 64.436 63.786 56.8474H55.0006C54.0789 56.8474 53.3339 56.1007 53.3339 55.1806Z"
										fill="#FF782C"></path>
								</svg>
								<h2 class="text-black mb-2 font-w600">
									<?php
										$sql    ="SELECT * FROM item";
										$query    =mysqli_query($conn, $sql);
										$data    =array();
										while(($row    =mysqli_fetch_array($query)) != null){
											$data[] =$row;
										}
										$count    =count($data);
										echo " $count";
									?>
								</h2>
								<p class="mb-0 fs-14">
									<span class="text-success mr-1"></span>Total Item
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xl-6 col-xxl-12">
						<div class="row">
							<div class="col-xl-12 mt-2">
								<div class="card">
									<div class="tltp">

									</div>
									<div class="card-body">
										<div id="horizontal-chart-container"></div>
										<div id="pie-chart"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 col-xxl-12">
						<div class="row">
							<div class="col-xl-12 mt-2">
								<div class="card">
									<div class="tltp">

									</div>
									<div class="card-header d-sm-flex d-block pb-0 border-0">
										<div>
											<h4 class="fs-20 text-black">grafik biblio</h4>
											<p class="mb-0 fs-12">Lorem ipsum dolor sit amet, consectetur</p>
										</div>

										<!-- import sql -->
										<button type="button" class="btn btn-primary mb-2" data-toggle="modal"
											data-target="#basicModal">Import sql
										</button>
										<div class="modal fade" id="basicModal">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Modal title</h5>
														<button type="button" class="close"
															data-dismiss="modal"><span>&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form action="../backend/importsql.php" method="post"
															enctype="multipart/form-data">
															<label for="file">Pilih file SQL:</label>
															<input type="file" name="file" id="file" accept=".sql"><br>
															<input type="submit" name="submit" value="Import"
																class="btn btn-primary onclick=" importSQLFile()">
														</form>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger light"
															data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>


										<!-- import excel -->
										<button type="button" class="btn btn-primary mb-2" data-toggle="modal"
											data-target="#basicModal1">Import excel
										</button>
										<div class="modal fade" id="basicModal1">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Modal title</h5>
														<button type="button" class="close"
															data-dismiss="modal"><span>&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form
															action="http://localhost:8080/test/perpustakaan/admin/modules/bibliography/Aimportexcel.php"
															method="POST" enctype="multipart/form-data">
															<input type="file" name="excel_file" accept=".xls, .xlsx"
																class="ml-3 mt-2">
															<input type="submit" name="submit" value="Import"
																class="btn btn-primary">
														</form>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-danger light"
															data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>



										<div class="d-flex flex-row">
											<a href="http://localhost:8080/test/perpustakaan/admin/modules/bibliography/Apisql.php"
												class="btn btn-primary mb-2" role="button" aria-pressed="true">Export
												biblio</a>
										</div>

									</div>
									<div class="card-body">
										<div id="chart-container"></div>
										<div id="slider-range"></div>
										<div class="row" style="padding: 10px;">
											<div>
												<div class="dc-data-count dc-chart">All records selected. Please click
													on the graph to apply filters.
												</div>
											</div>
											<table class="table table-hover dc-data-table dc-chart">
												<thead>
													<tr>
														<th class="dc-table-head">Id</th>
														<th class="dc-table-head">Judul</th>
														<th class="dc-table-head">Publish year</th>
														<th class="dc-table-head">Halaman</th>
														<th class="dc-table-head">Bahasa</th>
													</tr>
												</thead>
												<tbody id="data-table-body">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!--**********************************
            Content body end
        ***********************************-->

		<!--**********************************
            Footer start
        ***********************************-->
		<div class="footer">
			<div class="copyright">
				<!-- <p>Copyright © Designed &amp; Developed by <a href="../index.php" target="_blank">DexignZone</a> 2021 -->
				</p>
			</div>
		</div>
		<!--**********************************
            Footer end
        ***********************************-->


	</div>
	<!--**********************************
        Main wrapper end
    ***********************************-->

	<!--**********************************
        Scripts
    ***********************************-->



	<!-- script untuk horizontal -->
	<script>
		let horizontalChart = null; // Menyimpan referensi ke horizontal chart

		// Fetch data from the backend
		fetch('../backend/piebiblio.php')
			.then(response => response.json())
			.then(data => {
				const pieChart = createPieChart(data);
				createHorizontalChart(data);

				// Event listener for pie chart
				pieChart.on('click', (event, d) => {
					// Filter data for the selected publisher_id
					const filteredData = data.filter(item => item.publisher_id === d.data.publisher_id);
					updateHorizontalChart(filteredData);
				});
			})
			.catch(error => console.error(error));

		function createPieChart(data) {
			// Definisi lebar dan tinggi SVG
			const width = 200;
			const height = 200;

			// Mengelompokkan data berdasarkan publisher_id
			const groupedData = d3.group(data, d => d.publisher_id);

			// Menghitung total count untuk setiap publisher_id
			const combinedData = Array.from(groupedData, ([publisher_id, subData]) => ({
				publisher_id,
				count: d3.sum(subData, d => d.count)
			}));

			// Buat SVG di dalam elemen dengan id "pie-chart"
			const svg = d3.select("#pie-chart")
				.append("svg")
				.attr("width", width)
				.attr("height", height)
				.append("g")
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

			// Definisikan skala warna
			const color = d3.scaleOrdinal(d3.schemeCategory10);

			// Buat pie chart
			const pie = d3.pie().value(d => d.count);

			const arc = d3.arc()
				.innerRadius(0)
				.outerRadius(80);

			const path = svg.selectAll("path")
				.data(pie(combinedData))
				.enter()
				.append("path")
				.attr("d", arc)
				.attr("fill", d => color(d.data.publisher_id));

			// Tambahkan label dengan nama dan persentase di dalam pie chart
            const label = svg.selectAll("text")
                .data(pie(combinedData))
                .enter()
                .append("text")
                .attr("transform", d => {
                    const pos = arc.centroid(d);
                    const x = pos[0] * 0.85;
                    const y = pos[1] * 0.85;
                    return "translate(" + x + "," + y + ")";
                })
                .attr("dy", "0.35em")
                .text(d => {
                    const percentage = ((d.data.count / d3.sum(combinedData, d => d.count)) * 100);
                    return d.data.publisher_id + " (" + percentage.toFixed(0) + "%)";
                })
                .style("text-anchor", "middle");

            return path; // Mengembalikan referensi ke pie chart
		}

		function createHorizontalChart(data) {
			const width = 990;
			const height = 250;
			const margin = {
				top: 10,
				right: 10,
				bottom: 30,
				left: 40
			};
			const svg = d3.select('#horizontal-chart-container').append('svg')
				.attr('width', width)
				.attr('height', height)
				.append('g')
				.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

			// Buat horizontal chart dengan data yang diberikan
			const x = d3.scaleLinear()
				.domain([0, d3.max(data, d => d.count)])
				.range([0, width - margin.left - margin.right]);

			const y = d3.scaleBand()
				.domain(data.map(d => d.publish_year))
				.range([0, height - margin.top - margin.bottom])
				.padding(0.1);

			svg.append('g')
				.attr('class', 'axis x')
				.attr('transform', 'translate(0,' + (height - margin.top - margin.bottom) + ')')
				.call(d3.axisBottom(x));

			svg.append('g')
				.attr('class', 'axis y')
				.call(d3.axisLeft(y));

			svg.append('g')
				.selectAll('line')
				.data(y.domain())
				.enter().append('line')
				.attr('class', 'grid-line horizontal')
				.attr('x1', 0)
				.attr('x2', width - margin.left - margin.right)
				.attr('y1', d => y(d) + y.bandwidth() / 2)
				.attr('y2', d => y(d) + y.bandwidth() / 2);

			const bubbles = svg.selectAll('.bubble')
				.data(data)
				.enter().append('g')
				.attr('class', 'bubble')
				.attr('transform', d => 'translate(0,' + x(d.publish_year) + ')');
			// .attr('transform', d => 'translate(' + (width / 2) + ',' + y(d.publish_year) + ')');


			bubbles.append('circle')
				.attr('class', 'bubble')
				.attr('fill', '#ffffbf')
				.attr('r', 40)
				.attr('opacity', 1);

			bubbles.append('text')
				.attr('text-anchor', 'middle')
				.attr('dy', '.3em')
				.attr('opacity', 1)
				.text(d => d.title);

			bubbles.append('title')
				.text(d => d.title + '\nYear: ' + d.publish_year + '\nCount: ' + d.count);

			return svg; // Mengembalikan referensi ke horizontal chart
		}

		function updateHorizontalChart(data) {
			// Hapus horizontal chart yang ada sebelumnya
			d3.select('#horizontal-chart-container').selectAll('svg').remove();

			// Buat kembali horizontal chart dengan data yang telah difilter
			const width = 990;
			const height = 250;
			const margin = {
				top: 10,
				right: 10,
				bottom: 30,
				left: 40
			};
			const svg = d3.select('#horizontal-chart-container').append('svg')
				.attr('width', width)
				.attr('height', height)
				.append('g')
				.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

			const x = d3.scaleLinear()
				.domain([0, d3.max(data, d => d.count)])
				.range([0, width - margin.left - margin.right]);

			const y = d3.scaleBand()
				.domain(data.map(d => d.publish_year))
				.range([0, height - margin.top - margin.bottom])
				.padding(0.1);

			const centerX = (width - margin.left - margin.right) / 2; // Posisi tengah horizontal chart

			svg.append('g')
				.attr('class', 'axis x')
				.attr('transform', 'translate(0,' + (height - margin.top - margin.bottom) + ')')
				.call(d3.axisBottom(x));

			svg.append('g')
				.attr('class', 'axis y')
				.call(d3.axisLeft(y));

			svg.append('g')
				.selectAll('line')
				.data(y.domain())
				.enter().append('line')
				.attr('class', 'grid-line horizontal')
				.attr('x1', 0)
				.attr('x2', width - margin.left - margin.right)
				.attr('y1', d => y(d) + y.bandwidth() / 2)
				.attr('y2', d => y(d) + y.bandwidth() / 2);

			const bubbles = svg.selectAll('.bubble')
				.data(data)
				.enter().append('g')
				.attr('class', 'bubble')
				.attr('transform', d => 'translate(' + centerX + ',' + (y(d.publish_year) + (y.bandwidth() / 2)) +
					')'); // Posisi tengah-tengah

			bubbles.append('circle')
				.attr('class', 'bubble')
				.attr('fill', '#ffffbf')
				.attr('r', 40) // Ukuran bulatan
				.attr('opacity', 1);

			bubbles.append('text')
				.attr('text-anchor', 'middle')
				.attr('dy', '.3em')
				.attr('opacity', 1)
				.text(d => d.title);

			bubbles.append('title')
				.text(d => d.title + '\nYear: ' + d.publish_year + '\nCount: ' + d.count);

		}
	</script>

	<!-- script untuk linechart biblio -->
	<script>
		// Set dimensions and margins for the chart
		const margin = {
			top: 70,
			right: 60,
			bottom: 50,
			left: 50
		};
		const width = 1000 - margin.left - margin.right;
		const height = 500 - margin.top - margin.bottom;

		// Set up the x and y scales
		const x = d3.scaleTime()
			.range([0, width]);

		const y = d3.scaleLinear()
			.range([height, 0]);

		// Create the SVG element and append it to the chart container
		const svg = d3.select("#chart-container")
			.append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
			.append("g")
			.attr("transform", `translate(${margin.left},${margin.top})`);

		// create tooltip div
		const tooltip = d3.select("body")
			.append("div")
			.attr("class", "tooltip");

		// Create a second tooltip div for raw date
		const tooltipRawDate = d3.select("body")
			.append("div")
			.attr("class", "tooltip");

		// Create our gradient  
		const gradient = svg.append("defs")
			.append("linearGradient")
			.attr("id", "gradient")
			.attr("x1", "0%")
			.attr("x2", "0%")
			.attr("y1", "0%")
			.attr("y2", "100%")
			.attr("spreadMethod", "pad");

		gradient.append("stop")
			.attr("offset", "0%")
			.attr("stop-color", "#1f77b4")
			.attr("stop-opacity", 1);

		gradient.append("stop")
			.attr("offset", "100%")
			.attr("stop-color", "#1f77b4")
			.attr("stop-opacity", 0);

		// create a listening rectangle
		const listeningRect = svg.append("rect")
			.attr("width", width)
			.attr("height", height);

		let data; // Menyimpan data dari database

		// menampilkan data tabel dari database
		fetch('../backend/grafik.php')
			.then(response => response.json())
			.then(data => {
				const dataDetails = data.details;
				const tableBody = document.getElementById('data-table-body');

				// Hapus semua baris yang ada di dalam tabel
				while (tableBody.firstChild) {
					tableBody.removeChild(tableBody.firstChild);
				}

				// Loop melalui dataDetails dan tambahkan setiap entri ke dalam tabel
				dataDetails.forEach(entry => {
					const row = document.createElement('tr');
					row.innerHTML = `
        <td>${entry.biblio_id}</td>
        <td>${entry.title}</td>
        <td>${entry.publish_year}</td>
        <td>${entry.collation}</td>
        <td>${entry.language_id}</td>
      `;
					tableBody.appendChild(row);
				});
			})
			.catch(error => {
				console.error('Error:', error);
			});

		// Load and process the data
		d3.json("../backend/grafik.php").then(jsonData => {
			// Simpan data ke variabel global
			data = jsonData.publish_year;

			// Parse the Date and convert the Close to a number
			data.forEach(d => {
				d.publish_year = new Date(d.publish_year);
				d.total = +d.total;
			});

			// Set the domains for the x and y scales
			x.domain(d3.extent(data, d => d.publish_year));
			y.domain([0, d3.max(data, d => d.total)]);

			svg.append("g")
				.attr("class", "x-axis")
				.attr("transform", `translate(0,${height})`)
				.style("font-size", "14px")
				.call(d3.axisBottom(x)
					.tickFormat(d3.timeFormat("%Y")))
				.selectAll(".tick line")
				.style("stroke-opacity", 1);

			svg.selectAll(".tick text")
				.attr("fill", "#777");

			// Add the y-axis
			svg.append("g")
				.attr("class", "y-axis")
				.attr("transform", `translate(${width},0)`)
				.style("font-size", "14px")
				.call(d3.axisRight(y)
					.ticks(10)
					.tickFormat(d3.format("d")))
				.selectAll(".tick text")
				.style("fill", "#777");

			// Set up the line generator
			const line = d3.line()
				.x(d => x(d.publish_year))
				.y(d => y(d.total));

			// Create an area generator
			const area = d3.area()
				.x(d => x(d.publish_year))
				.y0(height)
				.y1(d => y(d.total));

			// Add the area path
			svg.append("path")
				.datum(data)
				.attr("class", "area")
				.attr("d", area)
				.style("fill", "url(#gradient)")
				.style("opacity", .5);

			// Add the line path
			const path = svg.append("path")
				.datum(data)
				.attr("class", "line")
				.attr("fill", "none")
				.attr("stroke", "#1f77b4")
				.attr("stroke-width", 1)
				.attr("d", line);

			// Add a circle element
			const circle = svg.append("circle")
				.attr("r", 0)
				.attr("fill", "red")
				.style("stroke", "white")
				.attr("opacity", 0.7)
				.style("pointer-events", "none");

			// Add red lines extending from the circle to the date and value
			const tooltipLineX = svg.append("line")
				.attr("class", "tooltip-line")
				.attr("id", "tooltip-line-x")
				.attr("stroke", "red")
				.attr("stroke-width", 1)
				.attr("stroke-dasharray", "2,2");

			const tooltipLineY = svg.append("line")
				.attr("class", "tooltip-line")
				.attr("id", "tooltip-line-y")
				.attr("stroke", "red")
				.attr("stroke-width", 1)
				.attr("stroke-dasharray", "2,2");

			// create the mouse move function
			listeningRect.on("mousemove", function (event) {
				const [xCoord] = d3.pointer(event, this);
				const bisectDate = d3.bisector(d => d.publish_year).left;
				const x0 = x.invert(xCoord);
				const i = bisectDate(data, x0, 1);
				const d0 = data[i - 1];
				const d1 = data[i];
				const d = x0 - d0.publish_year > d1.publish_year - x0 ? d1 : d0;
				const xPos = x(d.publish_year);
				const yPos = y(d.total);

				// Update the circle position
				circle.attr("cx", xPos).attr("cy", yPos);

				// Add transition for the circle radius
				circle.transition()
					.duration(50)
					.attr("r", 5);

				// Update the position of the red lines
				tooltipLineX.style("display", "block").attr("x1", xPos).attr("x2", xPos).attr("y1", 0)
					.attr("y2", height);
				tooltipLineY.style("display", "block").attr("y1", yPos).attr("y2", yPos).attr("x1", 0)
					.attr("x2", width);

				// add in our tooltip
				tooltip
					.style("display", "block")
					.style("left", `${width + 90}px`)
					.style("top", `${yPos + 68}px`)
					.html(`${d.total !== undefined ? d.total : 'N/A'}`);

				tooltipRawDate
					.style("display", "block")
					.style("left", `${xPos + 60}px`)
					.style("top", `${height + 53}px`)
					.html(
						`${d.publish_year !== undefined ? d.publish_year.toISOString().slice(0, 10) : 'N/A'}`
					);
			});

			// listening rectangle mouse leave function
			listeningRect.on("mouseleave", function () {
				circle.transition().duration(50).attr("r", 0);
				tooltip.style("display", "none");
				tooltipRawDate.style("display", "none");
				tooltipLineX.attr("x1", 0).attr("x2", 0);
				tooltipLineY.attr("y1", 0).attr("y2", 0);
				tooltipLineX.style("display", "none");
				tooltipLineY.style("display", "none");
			});

			// Define the slider
			const sliderRange = d3
				.sliderBottom()
				.min(d3.min(data, d => d.publish_year))
				.max(d3.max(data, d => d.publish_year))
				.width(300)
				.tickFormat(d3.timeFormat('%Y-%m-%d'))
				.ticks(3)
				.default([d3.min(data, d => d.publish_year), d3.max(data, d => d.publish_year)])
				.fill('#1f77b4');

			// Add the slider to the DOM
			const gRange = d3
				.select('#slider-range')
				.append('svg')
				.attr('width', 1000)
				.attr('height', 100)
				.append('g')
				.attr('transform', 'translate(90,30)');

			gRange.call(sliderRange);

			// Filter data based on the initial slider values
			const initialFilteredData = data.filter(d => d.publish_year >= sliderRange.value()[0] && d
				.publish_year <= sliderRange.value()[1]);


			// Handle slider change event
			sliderRange.on('onchange', val => {
				// Filter data based on slider values
				const filteredData = data.filter(d => d.publish_year >= val[0] && d.publish_year <= val[1]);

				// Update domain for x-axis with selected years
				x.domain([val[0], val[1]]);

				// Update the chart with the filtered data
				svg.select(".line")
					.datum(filteredData)
					.attr("d", line);

				svg.select(".area")
					.datum(filteredData)
					.attr("d", area);

				// Update the y-axis domain based on the filtered data
				y.domain([0, d3.max(filteredData, d => d.total)]);

				// Update x-axis with the new domain
				svg.select(".x-axis")
					.transition()
					.duration(300)
					.call(d3.axisBottom(x)
						.tickFormat(d3.timeFormat("%Y")));

				// Update y-axis with the new domain
				svg.select(".y-axis")
					.transition()
					.duration(300)
					.call(d3.axisRight(y)
						.ticks(10)
						.tickFormat(d => {
							if (d <= 0) return "";
							return d3.format("d")(d);
						}));

				// Update the table data when the slider changes
				const tableRows = document.querySelectorAll('#data-table-body tr');
				tableRows.forEach(row => {
					const publishYear = new Date(row.querySelector('td:nth-child(3)').textContent);
					if (publishYear >= val[0] && publishYear <= val[1]) {
						row.style.display = "table-row"; // Show rows within the selected range
					} else {
						row.style.display = "none"; // Hide rows outside the selected range
					}
				});
			});
		});
	</script>
	


	<!-- Required vendors -->
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
	<script src="../vendor/global/global.min.js"></script>
	<script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

	<script src="../js/dashboard/dashboard-1.js"></script>

	<script src="../vendor/owl-carousel/owl.carousel.js"></script>
	<script src="../js/custom.min.js"></script>
	<script src="../js/deznav-init.js"></script>
	<script src="../js/demo.js"></script>
	<script src="../js/styleSwitcher.js"></script>

</body>

</html>