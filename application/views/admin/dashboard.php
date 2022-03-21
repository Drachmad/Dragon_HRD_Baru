<br>

<body>
	<div class="container-fluid">
		<br>
		<div class="alert alert-success" role="alert">
			<i class="fas fa-tachometer-alt"></i> Dashboard
		</div>
		<div class="alert alert-success" role="alert">
			<h4 class="alert-heading">Selamat Datang</h4>
			<p>Selamat Datang <strong><?php echo $na_dev; ?> </strong> di Sistem Informasi kami</p>
			<p> Anda login sebagai <strong><?php echo $level; ?> </strong> </p>
			<p> Dragon <strong><?php echo $dr; ?> </strong> </p>
			<p> Status Admin <?php if ($pt == 0) echo '<strong> CV ' . $cv . ' </strong>';
								if ($pt == 1) echo '<strong> PT </strong>' ?> </p>
			<p>periode <?php echo $periode; ?> </p>
			<p>fase <strong> <?php echo $fase; ?> </strong> </p>
			<hr>
			<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal">
				<i class="fas fa-cogs"></i> -
			</button>
		</div>
	</div>
	<br><br><br><br><br><br><br><br><br><br>

	<body>