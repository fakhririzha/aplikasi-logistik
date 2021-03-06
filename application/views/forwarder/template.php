<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $judul; ?> - PesanTruk</title>
	<!-- Meta -->
	<?php
	echo meta('description', 'Website tracking PT. Haluan Indah Transporindo');
	echo meta('keywoards', 'kirim barang, tracking, pelayaran, pengiriman');
	echo meta('Content-type', 'text/html; charset=utf-8', 'equiv');
	echo meta('viewport', 'width=device-width, initial-scale=1.0');
	?>
	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mystyle.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/flick/jquery-ui-1.9.2.custom.css">
	<style type="text/css">
		.content {
			padding-top: 40px;
			padding-bottom: 20px;
		}

		.spacer-large {
			height: 100px;
		}

		.icon-chevron-right {
			opacity: .25;
		}

		.icon-home {
			opacity: .25;
		}

		.icon-off {
			opacity: .5;
		}

		.form-signin {
			max-width: 300px;
			padding: 19px 29px 29px;
			margin: 0 auto 20px;
			background-color: #fff;
			border: 1px solid #e5e5e5;
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			-webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
			-moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
			box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
		}

		.form-signin .form-signin-heading,
		.form-signin .checkbox {
			margin-bottom: 10px;
		}

		.form-signin input[type="text"],
		.form-signin input[type="password"] {
			font-size: 16px;
			height: auto;
			margin-bottom: 15px;
			padding: 7px 9px;
		}

		.spacer {
			height: 25px;
		}

		.left-foot {
			color: rgb(0, 123, 215);
			font-size: 10pt;
			text-align: center;
		}
	</style>
</head>

<body>
	<!-- Navbar -->
	<div class="navbar navbar-fixed-top navbar-inverse">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="#">Dashboard Forwarder</a>
				<div class="nav-collapse collapse">
					<ul class="nav pull-right">
						<li><a href="<?php echo base_url(); ?>index.php/forwarder/logout">
								<i class="icon-off icon-white"></i>&nbsp;Keluar</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Navbar -->

	<!-- Header -->
	<div class="spacer">
		<!-- comment header
		<a href="#">
			<img src="<?php echo base_url(); ?>assets/img/head2.jpg" alt="PT. Haluan Indah Transporindo">
		</a>
		-->
	</div>

	<!-- Content -->
	<div class="container content">
		<div class="row">
			<div class="span3">
				<!--Sidebar content-->
				<div class="well" style="padding: 8px 0;">
					<ul class="nav nav-list">
						<!-- kategori baru -->
						<li class="<?php if ($this->uri->segment(2) == '') echo $aktif; ?>">
							<a href="<?php echo base_url(); ?>index.php/forwarder/">Beranda
								<i class="icon-home pull-right"></i></a>
						</li>
						<!-- kategori baru -->
						<li class="nav-header">Manajemen Data</li>
						<!-- <li class="<?php if ($this->uri->segment(2) == 'daftar_kiriman') echo $aktif; ?>">
							<a href="<?php echo base_url(); ?>index.php/forwarder/daftar_kiriman">Request Kiriman
							<i class="icon-chevron-right pull-right"></i></a>
						</li> -->
						<li class="<?php if ($this->uri->segment(2) == 'atur_tataletak_armada') echo $aktif; ?>">
							<a href="<?php echo base_url(); ?>index.php/forwarder/atur_tataletak_armada">Atur Tataletak Armada
								<i class="icon-chevron-right pull-right"></i></a>
						</li>
						<li class="<?php if ($this->uri->segment(2) == 'list_kiriman') echo $aktif; ?>">
							<a href="<?php echo base_url(); ?>index.php/forwarder/list_kiriman">List Kiriman
								<i class="icon-chevron-right pull-right"></i></a>
						</li>
						<li class="nav-header">Armada</li>
						<li class="<?php if ($this->uri->segment(2) == 'kelola_armada') echo $aktif; ?>">
							<a href="<?php echo base_url(); ?>index.php/forwarder/kelola_armada">Kelola Armada
								<i class="icon-chevron-right pull-right"></i></a>
						</li>
					</ul>
				</div>
				<div class="left-foot">
					<strong>PesanTruk</strong><br>
					Sumatera Utara, Indonesia<br>
					<abbr title="Phone">CS :</abbr> (123) 456-7890<br>
					&nbsp;<br>
					&copy; <?php echo date("Y"); ?>&nbsp;
					<a href="https://www.usu.ac.id">Teknik Sipil - Universitas Sumatera Utara</a>
				</div>
			</div>
			<div class="span9">
				<!--Body content-->
				<?php $this->load->view($konten); ?>
			</div>
		</div>
	</div>

	<!-- JavaScript -->
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.8.3.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/myscript.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/mine.js"></script>
	<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
</body>

</html>