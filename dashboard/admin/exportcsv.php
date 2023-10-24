<?php
// Mengimpor library Simple HTML DOM
include('/home/hana/lampstack-8.1.11-0/apache2/htdocs/test/perpustakaan/simple_html_dom.php');

// Ambil data dari sumber data
$data = file_get_contents('https://library.brin.go.id/oai2.php?verb=ListRecords&metadataPrefix=oai_dc');

// Buat objek HTML dari data yang diambil
$html = str_get_html($data);

// Inisialisasi data yang akan di-export ke CSV
$dataToExport = array();

// Ambil data Date untuk filter dengan slider range
$dates = $html->find('dc:date');
$years = array();
foreach ($dates as $date) {
    $year = intval(substr($date->innertext, 0, 4));
    $years[] = $year;
}

// Menghilangkan duplikat tahun
$years = array_unique($years);

// Mengekstrak tahun-tahun unik
sort($years);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pengecekan data yang dipilih oleh pengguna
    if (isset($_POST['export'])) {
        $selectedColumns = $_POST['export'];

        // Filter data berdasarkan tahun yang dipilih dengan slider range
        $startYear = isset($_POST['startYear']) ? intval($_POST['startYear']) : min($years);
        $endYear = isset($_POST['endYear']) ? intval($_POST['endYear']) : max($years);

        // Output ke file CSV
        header('Content-Type: text/csv');
        header("Content-disposition: attachment; filename=\"exported_data.csv\"");

        // Membuka output CSV
        $output = fopen("php://output", "w");

        // Tambahkan header berdasarkan pilihan pengguna
        $header = array();
        foreach ($selectedColumns as $column) {
            if ($column == 'title') {
                $header[] = 'Judul';
            } elseif ($column == 'creator') {
                $header[] = 'Pencipta';
            } elseif ($column == 'publisher') {
                $header[] = 'Penerbit';
            } elseif ($column == 'date') {
                $header[] = 'Tanggal';
            } elseif ($column == 'language') {
                $header[] = 'Bahasa';
            } elseif ($column == 'type') {
                $header[] = 'Tipe Sumber';
            } elseif ($column == 'format') {
                $header[] = 'Format';
            } elseif ($column == 'coverage') {
                $header[] = 'Cakupan';
            }
        }

        // Tulis header ke file CSV
        fputcsv($output, $header);

        // Menambahkan data yang sesuai dengan pilihan pengguna dan filter tahun
        foreach ($html->find('oai_dc:dc') as $t) {
            $dataRow = array();

            // Ambil data sesuai dengan pilihan pengguna
            foreach ($selectedColumns as $column) {
                if ($column == 'title') {
                    $dataRow[] = addslashes($t->find('dc:title', 0)->innertext);
                } elseif ($column == 'creator') {
                    $creator_values = $t->find('dc:creator');
                    $creators = array();
                    foreach ($creator_values as $creator) {
                        $creators[] = addslashes($creator->innertext);
                    }
                    $dataRow[] = implode(', ', $creators);
                } elseif ($column == 'publisher') {
                    $dataRow[] = addslashes($t->find('dc:publisher', 0)->innertext);
                } elseif ($column == 'date') {
                    $dataRow[] = addslashes($t->find('dc:date', 0)->innertext);
                } elseif ($column == 'language') {
                    $dataRow[] = addslashes($t->find('dc:language', 0)->innertext);
                } elseif ($column == 'type') {
                    $dataRow[] = addslashes($t->find('dc:type', 0)->innertext);
                } elseif ($column == 'format') {
                    $dataRow[] = addslashes($t->find('dc:format', 0)->innertext);
                } elseif ($column == 'coverage') {
                    $dataRow[] = addslashes($t->find('dc:coverage', 0)->innertext);
                }
            }

            $date = intval(substr($t->find('dc:date', 0)->innertext, 0, 4));

            if ($date >= $startYear && $date <= $endYear) {
                fputcsv($output, $dataRow);
            }
        }

        fclose($output);
        exit;
    }
}
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
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                            width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success"
                                            width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                            </path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="localhost:8080/test/perpustakaan/admin/logout.php"
                                        class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                            width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
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
                            <li><a href="page-chat.html">Chat<span class="badge badge-xs badge-danger">New</span></a>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Project<span
                                        class="badge badge-xs badge-danger">New</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="project-list.html">Project List</a></li>
                                    <li><a href="project-card.html">Project Card</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">User<span
                                        class="badge badge-xs badge-danger">New</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="user-list-datatable.html">User List</a></li>
                                    <li><a href="user-list-column.html">User Card</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Contact<span
                                        class="badge badge-xs badge-danger">New</span></a>
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
                </ul>
                <!-- <div class="copyright">
					<p><strong>Zenix Crypto Admin Dashboard</strong> © 2021 All Rights Reserved</p>
					<p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
				</div> -->
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
                <!-- Add Project -->
                <div class="modal fade" id="addProjectSidebar">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Create Project</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label class="text-black font-w500">Project Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-black font-w500">Deadline</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="text-black font-w500">Client Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary">CREATE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row page-titles mx-0">

                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Components</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form step</h4>
                            </div>
                            <div class="card-body">
                                <h2>Pilih kolom yang ingin Anda export:</h2>
                                <form method="post">
                                    <input type="checkbox" name="export[]" value="title"> Judul
                                    <input type="checkbox" name="export[]" value="creator"> Pencipta
                                    <input type="checkbox" name="export[]" value="publisher"> Penerbit
                                    <input type="checkbox" name="export[]" value="date"> Tanggal
                                    <input type="checkbox" name="export[]" value="language"> Bahasa
                                    <input type="checkbox" name="export[]" value="type"> Tipe Sumber
                                    <input type="checkbox" name="export[]" value="format"> Format
                                    <input type="checkbox" name="export[]" value="coverage"> Cakupan
                                    <!-- Tambahkan pilihan lain sesuai kebutuhan -->

                                    <h2>Pilih tahun:</h2>
                                    <label for="startYear">Mulai Tahun:</label>
                                    <input type="number" name="startYear" id="startYear" min="<?= min($years) ?>"
                                        max="<?= max($years) ?>">
                                    <br>
                                    <label for="endYear">Akhir Tahun:</label>
                                    <input type="number" name="endYear" id="endYear" min="<?= min($years) ?>"
                                        max="<?= max($years) ?>">
                                    <br>

                                    <input type="submit" value="Export Data">
                                </form>
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