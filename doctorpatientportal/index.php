<?php
session_start();
if (isset($_POST['btn_login'])) {
	$useremail = $_POST['useremail'];
	$userpass =  $_POST['userpass'];

	include('includes/conn.php');

	$q1 = "SELECT * FROM doctor where email = '$useremail'";
	$q2 = "SELECT * FROM patient where email = '$useremail'";
	$q3 = "SELECT * FROM admin where email = '$useremail'";

	$r = mysqli_query($con, $q1);
	$rr = mysqli_query($con, $q2);
	$ad = mysqli_query($con, $q3);

	if (mysqli_num_rows($r) > 0) {
		while ($row = mysqli_fetch_assoc($r)) {
			$dbname = $row['name'];
			$dbemail = $row['email'];
			$dbpass = $row['password'];
			$type = $row['type'];
		}
		if ($useremail == $dbemail && $userpass == $dbpass) {
			$_SESSION['useremail'] = $useremail;
			$_SESSION['userpass'] = $userpass;
			if ($_POST['remember'] == 'on') {
				$expire = time() + 86400;
				setcookie('dpp', $_POST['useremail'], $expire);
			}
			header("location:doctor.php");
		} else {
			echo "<script>";
			echo "alert('Wrong Doctor Email or Password')";
			echo "</script>";
		}
	} elseif (mysqli_num_rows($rr) > 0) {
		while ($row = mysqli_fetch_assoc($rr)) {
			$dbid = 	@$row['id'];
			$dbname = $row['name'];
			$dbemail = $row['email'];
			$dbpass = $row['password'];
			$type = $row['type'];
		}
		if ($useremail == $dbemail && $userpass == $dbpass) {
			$_SESSION['useremail'] = $useremail;
			$_SESSION['userpass'] = $userpass;
			$_SESSION['status'] = "Success";
			if ($_POST['remember'] == 'on') {
				$expire = time() + 86400;
				setcookie('dpp', $_POST['useremail'], $expire);
			}
			header("location:patient.php");
		} else {
			echo "<script>";
			echo "alert('Wrong Patient Email or Password')";
			echo "</script>";
		}
	} elseif (mysqli_num_rows($ad) > 0) {
		while ($row = mysqli_fetch_assoc($ad)) {
			$dbname = $row['name'];
			$dbemail = $row['email'];
			$dbpass = $row['password'];
		}
		if ($useremail == $dbemail && $userpass == $dbpass) {
			$_SESSION['useremail'] = $useremail;
			$_SESSION['userpass'] = $userpass;
			$_SESSION['status'] = "Success";
			if ($_POST['remember'] == 'on') {
				$expire = time() + 86400;
				setcookie('dpp', $_POST['useremail'], $expire);
			}
			header("location:adminpanel.php");
		} else {
			echo "<script>";
			echo "alert('Wrong Patient Email or Password')";
			echo "</script>";
		}
	} else {
		echo "<script>";
		echo "alert('Account not exist')";
		echo "</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<noscript>
	<META HTTP-EQUIV="Refresh" CONTENT="0;URL=nojs.html">
</noscript>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Welcome To Doctor Patient Portal</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="theme/home.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style>
	.navbar-inverse .navbar-nav>.open>a,
	.navbar-inverse .navbar-nav>.open>a:focus,
	.navbar-inverse .navbar-nav>.open>a:hover {
		background-color: green;
		border-top-left-radius: 1em;
		border-top-right-radius: 1em;
	}

	.navbar-inverse .navbar-nav>.open>a:hover {
		background-color: red;
		border-top-left-radius: 1em;
		border-top-right-radius: 1em;
		border-bottom-left-radius: 0em;
		border-bottom-right-radius: 0em;
	}

	button.list-group-item {
		cursor: default;
	}

	button.list-group-item:hover {
		background: #059216;
		color: white;
		border-left: 6px solid #F03333;
		transition: 0.5s;
	}

	button.list-group-item>a:hover {
		color: white !important;
	}

	.aa {
		text-decoration: none;
		color: #555;
	}

	.aa:hover {
		text-decoration: none;
		color: white;
	}
</style>

<body>
	<br>
	<?php
	include('includes/conn.php');
	@$eml = $_SESSION['useremail'];
	$qry = "SELECT * FROM doctor where email = '$eml'";
	$qry2 = "SELECT * FROM patient where email = '$eml'";
	$qry3 = "SELECT * FROM admin where email = '$eml'";
	$h = mysqli_query($con, $qry);
	$h2 = mysqli_query($con, $qry2);
	$h3 = mysqli_query($con, $qry3);
	while ($row = mysqli_fetch_assoc($h)) {
		$id = $row['did'];
		$user = $row['name'];
		$type = $row['type'];
		$docid = $row['docid'];
		$age = $row['age'];
		$phone = $row['phone_number'];
		$email = $row['email'];
		$sex = $row['gender'];
	}
	while ($row = mysqli_fetch_assoc($h2)) {
		$user = $row['name'];
		$type = $row['type'];
		$patid = $row['pid'];
		$agep = $row['age'];
		$mob = $row['phone'];
		$sexp = $row['gender'];
		$adrid = $row['adharno'];
		$emailp = $row['email'];
	}
	while ($row = mysqli_fetch_assoc($h3)) {
		$user = $row['name'];
		$type = $row['type'];
	}
	?>


	<?php if (!isset($_SESSION['useremail'])) { ?>

		<div style="padding:25px 100px; border-top-left-radius:0.5em; border-top-right-radius:0.5em;" class="mainmenu container nav navbar-inverse" data-spy="affix" data-offset-top="100">
			<button type="button" style="background:#005173; border-color:#005173;" class="navbar-toggle" data-toggle="collapse" data-target="#coo">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand"><img width="85px" height="85px" style="margin-top:-38%;" title="Doctor Patient Portal" class="logomain" src="img/logo.png" /></a>
			<div class="collapse navbar-collapse" id="coo">


				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
					<li><a href="about.php"><span class="glyphicon glyphicon-info-sign"></span> Sobre</a></li>
					<li><a href="contact.php"><span class="glyphicon glyphicon-earphone"></span> Contato</a></li>
					<li><a href="help.php"><span class="glyphicon glyphicon-question-sign"></span> Ajuda</a></li>
					<li class="a"><a data-toggle="modal" data-target="#login" href="#"><span class="glyphicon glyphicon-user"></span> Login</a></li>
					<li class="ar"><a data-toggle="modal" data-target="#register" href="#"><span class="glyphicon glyphicon-registration-mark"></span> Registrar</a></li>
				</ul>
			</div>

		</div><?php } else {
				?>
		<div style="padding:25px 100px; border-top-left-radius:0.5em; border-top-right-radius:0.5em;" class="mainmenu container nav navbar-inverse" data-spy="affix" data-offset-top="100">
			<button style="border:0px;" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#co">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand"><img width="85px" height="85px" style="margin-top:-38%;" title="Doctor Patient Portal" class="logomain" src="img/logo.png" /></a>

			<div id="co" class="collapse navbar-collapse">
				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
					<li><a href="about.php"><span class="glyphicon glyphicon-info-sign"></span> Sobre</a></li>
					<li><a href="contact.php"><span class="glyphicon glyphicon-earphone"></span> Contato</a></li>
					<li><a href="help.php"><span class="glyphicon glyphicon-question-sign"></span> Ajuda</a></li>
					<?php if ($type == "doc") { ?>
						<li class="a"><a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Olá <?php echo $user ?>
								<span class="caret"></span></a>
							<ul style="float:left; margin-left:-35%;" class="dropdown-menu">
								<li><a data-toggle="modal" href="#profiletab"><span class="glyphicon glyphicon-eye-open"></span> Seu Perfil</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="doctor.php"><span class="glyphicon glyphicon-th-list"></span> Seu Painel</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
							</ul>


						</li>
					<?php } ?>
					<?php if ($type == "pat") { ?>
						<li class="a"><a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Olá <?php echo $user ?>
								<span class="caret"></span></a>
							<ul style="float:left; margin-left:-35%;" class="dropdown-menu">
								<li><a href="doclist.php"><span class="glyphicon glyphicon-list-alt"></span> Lista rápida de médicos</a></li>
								<li role="separator" class="divider"></li>
								<li><a data-toggle="modal" href="#profiletab2"><span class="glyphicon glyphicon-eye-open"></span> Seu Perfil</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="patient.php"><span class="glyphicon glyphicon-th-list"></span> Seu Painel</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
							</ul>


						</li>
					<?php } ?>
					<?php if ($type == "admin") { ?>
						<li class="a"><a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Olá <?php echo $user ?>
								<span class="caret"></span></a>
							<ul style="float:left; margin-left:-35%;" class="dropdown-menu">
								<li><a href="adminpanel.php"><span class="glyphicon glyphicon-th-list"></span> Seu Painel</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
							</ul>


						</li>
					<?php } ?>
			</div>
			</ul>

		</div>

	<?php } ?>
	<div class="container">
		<h2 style="position:absolute;"><a class="nome_portal" href="#ab" data-toggle="collapse">Bem Vindo ao Portal do Medico</h2></a>
		<div style="position:absolute; margin-top:15%;" class="collapse" id="ab">
			<div style="width:100%; margin-top:-13%;" class="row">
				<div class="col-md-6">
					<div style="text-align:justify; opacity:0.8" class="well">
						<p style="font-size: 15px;"><b style="font-size: 25px;">P</b>ortais de atendimento são ferramentas on-line seguras e convenientes que ajudam você a gerenciar e monitorar a saúde de você e de sua família e de quem quer que seja, 24 horas por dia, 7 dias por semana.
							Use-o para agendar compromissos, acessar seu histórico de compromissos. Você pode até agendar compromissos antecipados para os próximos 5 dias.
							É seguro, fácil de usar e uma ótima maneira de controlar sua saúde sempre que precisar.
							VEJA SEUS REGISTROS DE SAÚDE ON-LINE COM SEGURANÇA COM SEU PORTAL DO PACIENTE.
							A maneira fácil de manter-se atualizado com suas informações de saúde.</p>
					</div>
				</div>
				<div class="col-md-6">
					<img style="margin-left:10%;float:left; margin-top:-5%;opacity:0.8;" width="250px" src="img/logo.png" />
				</div>
			</div>
		</div>
		<img style="margin-top:0;" class="dppbanner" src="img/220356.jpg" />
		<div style="margin-left:-1.3%; width:102.7%; float:left; border-radius:0em;" class="jb jumbotron">
			<p>&nbsp;</p>
			<div style="margin-top:-7%;" class="row">
				<div class="col-md-4">
					<div style="margin-left:-12%; width:115%; float:left; background-color: #72dd7e; border: #72dd7e;" class="panel panel-primary">
						<div class="panel-heading" style="background-color: #059216; border: #72dd7e;"><span class="glyphicon glyphicon-cloud"></span> Serviços</div>
						<div class="panel-body">
							<div style="font-family:calibri;" class="list-group">
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-cloud"></span>&nbsp;&nbsp;
									<a class="aa" href="doclist.php">Obtenha uma lista rápida de médicos</a></button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-cloud"></span>&nbsp;&nbsp;Faça compromissos rapidamente</button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-cloud"></span>&nbsp;&nbsp;
									<a class="aa" href="doclist.php">Apenas Médico Verificado Ela</a></button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-cloud"></span>&nbsp;&nbsp;Todos os tipos de médico disponíveis</button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-cloud"></span>&nbsp;&nbsp;Sistema de mensagens entre médico e paciente</button>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div style="margin-left:-2%; width:110%; float:left; background-color: #72dd7e; border: #72dd7e;" class="panel panel-primary">
						<div class="panel-heading" style="background-color: #059216; border: #72dd7e;"><span class="glyphicon glyphicon-ok-sign"></span> Beneficios</div>
						<div class="panel-body">
							<div style="font-family:calibri;" class="list-group">
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Sem necessidade de esperar na fila</button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Gerenciar compromisso em seu próprio painel</button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Sistema de mensagens pessoais</button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Preencha o formulário de consulta</button>
								<button type="button" class="list-group-item"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;Gerencie seu perfil e muito mais...</button>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div style="margin-left:3%; width:110%; float:left; background-color: #72dd7e; border: #72dd7e;" class="panel panel-primary">
						<div class="panel-heading" style="background-color: #059216; border: #72dd7e;"><span class="glyphicon glyphicon-comment"></span> Depoimentos</div>
						<div class="panel-body">
							<?php
							$q = "SELECT feed, pid FROM feedback ORDER BY RAND() LIMIT 1";
							$rr = mysqli_query($con, $q);

							if ($rr && mysqli_num_rows($rr) > 0) {
								$res = mysqli_fetch_array($rr);
								if ($res) {
									$p = $res['feed'];
									$d = $res['pid'];
								} else {
									$p = 0;
								}
							} else {
								$rr = 0;
							}
							$res = "";
							if ($res == "") {
								echo "Nenhum feedback dado ainda";
							} elseif ($p && $d != "") {
								$qq = "select * from patient where pid='$d' ";


								$rq = mysqli_query($con, $qq);

								while ($row = mysqli_fetch_array($rq)) {
									$na = $row['name'];
									$adr = $row['adharno'];
								}

								$dir = "patient/" . $adr . "/img/";
								$open = opendir($dir);

								while (($files = readdir($open)) != FALSE) {
									if ($files != "." && $files != ".." && $files != "Thumbs.db") {
										echo "<div style='font-family:calibri' class='well'><img id='hello' style='margin-top:2%; border-radius:6em;' width='50' height='50'  src='$dir/$files'> Given By <b>$na</b>";
									}
								}

								echo "<br><br>$p</div>";
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div style="font-family:calibri; font-size:14px; text-align:center;" id="static">
				<?php
				include('includes/conn.php');
				$q = "SELECT COUNT(*) as cnt FROM doctor WHERE status='success'";
				$r = mysqli_query($con, $q);
				$res = mysqli_fetch_array($r);
				$doc = $res['cnt'];

				$q1 = "SELECT COUNT(*) as cnt FROM patient";
				$r1 = mysqli_query($con, $q1);
				$res2 = mysqli_fetch_array($r1);
				$pat = $res2['cnt'];

				$q3 = "SELECT COUNT(*) as cnt FROM appointments";
				$r2 = mysqli_query($con, $q3);
				$res = mysqli_fetch_array($r2);
				$pen = $res['cnt'];
				?>
				<b>Médicos Verificado <span class="badge"><?php echo $doc; ?></span> |&nbsp; Pacientes cadastrados <span class="badge"><?php echo $pat; ?></span> |&nbsp; Agendamentos marcados <span class="badge"><?php echo $pen; ?></span> |</b>
			</div>
		</div>
		<div style="width:102.5%; margin-left:-1.2%;margin-top:-5%;" class="container footer">
			<center>&copy; 2023 | Todos os direitos reservados | By <a style="color:white; cursor:pointer; target=" _blank" href=#>Juan</a> |
				<a style="color:white;" href="sitemap.php">Portal do Medico</a>
			</center>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		});
	</script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>

	<!--Profile tab start-->
	<div class="modal fade" id="profiletab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div style="width:35%; border-radius:0em;" class="modal-dialog" role="document">
			<div class="modal-content">
				<div style="background:#005173; height:35px; color:white;" class="modal-header">
					<button style="margin-top:-1.5%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color:white;" aria-hidden="true">&times;</span></button>
					<h5 style="font-family:calibri; margin-top:-1.5%;" class="modal-title" id="myModalLabel"><b><?php echo "#$id $user"; ?></b></h5>
				</div>
				<div style="border-bottom-left-radius:0px;" class="modal-body">

					<div class="row">

						<div class="col-md-4">
							<?php
							$dir = "doctor/" . $docid . "/img/";
							$open = opendir($dir);

							while (($files = readdir($open)) != FALSE) {
								if ($files != "." && $files != ".." && $files != "Thumbs.db") {
									echo "<img id='hello' style='float:left; margin-left:15%; border-radius:6em;' width='100' height='100' title='$user' src='$dir/$files'>";
								}
							}
							?>
							<p align="center" style="font-family:calibri;">&nbsp;&nbsp;&nbsp;</p>
							<p align="center" style="font-family:calibri; margin-top:-18%;"><?php echo "&nbsp;&nbsp;&nbsp;<b>ID : $docid</b>"; ?></p>
						</div>
						<div class="col-md-4">
							<img src="img/line.png" />
						</div>

						<div class="col-md-4">
							<div style="font-family:calibri; float:left;margin-left:-70%;">
								<label>Nome </label>&nbsp;&nbsp; : <?php echo $user; ?><br>
								<label>Email </label>&nbsp;&nbsp; : <?php echo $email; ?><br>
								<label>Telefone </label>&nbsp;: <?php echo "+91-$phone"; ?><br>
								<label>Gênero </label>&nbsp;:&nbsp;<?php echo $sex; ?><br>
								<label>Idade </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;<?php echo $age; ?><br>

							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
	<!--profile tab end-->

	<!--patient Profile tab start-->
	<div class="modal fade" id="profiletab2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div style="width:35%; border-radius:0em;" class="modal-dialog" role="document">
			<div class="modal-content">
				<div style="background:#005173; height:35px; color:white;" class="modal-header">
					<button style="margin-top:-1.5%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color:white;" aria-hidden="true">&times;</span></button>
					<h5 style="font-family:calibri; margin-top:-1.5%;" class="modal-title" id="myModalLabel"><b><?php echo "#$patid $user"; ?></b></h5>
				</div>
				<div style="border-bottom-left-radius:0px;" class="modal-body">

					<div class="row">

						<div class="col-md-4">
							<?php
							$dir = "patient/" . $adrid . "/img/";
							$open = opendir($dir);

							while (($files = readdir($open)) != FALSE) {
								if ($files != "." && $files != ".." && $files != "Thumbs.db") {
									echo "<img id='hello' style='float:left; margin-left:15%; border-radius:6em;' width='100' height='100' title='$user' src='$dir/$files'>";
								}
							}
							?>
							<p align="center" style="font-family:calibri;">&nbsp;&nbsp;&nbsp;</p>
							<p align="center" style="font-family:calibri; margin-top:-18%;"><?php echo "&nbsp;&nbsp;&nbsp;<b>A. ID : $adrid</b>"; ?></p>
						</div>
						<div class="col-md-4">
							<img src="img/line.png" />
						</div>

						<div class="col-md-4">
							<div style="font-family:calibri; float:left;margin-left:-70%;">
								<label>Name </label>&nbsp;&nbsp; : <?php echo $user; ?><br>
								<label>Email </label>&nbsp;&nbsp; : <?php echo $emailp; ?><br>
								<label>Telefone </label>&nbsp;: <?php echo "+91-$mob"; ?><br>
								<label>Gênero </label>&nbsp;:&nbsp;<?php echo $sexp; ?><br>
								<label>Idade </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;<?php echo $agep; ?><br>

							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
	<!--patint profile tab end-->

	<!--Login Form-->
	<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div style="background:#005173; color:white;" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color:white;" aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Login no Portal</h4>
				</div>
				<div class="modal-body">
					<br>
					<form action="" name="lfrom" method="POST">
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" class="form-control" required name="useremail" placeholder="Enter your email" aria-describedby="sizing-addon2">
						</div><br>
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" required class="form-control" name="userpass" placeholder="Enter your password" aria-describedby="sizing-addon2">
						</div>
						<div class="modal-footer">
							<center><input type="submit" value="Login" name="btn_login" class="btn btn-success"></center>
						</div>
						<center><a style="font-family:calibri;" href="forgetpass.php">Esqueceu a senha?</a></center>
						<center><input type="checkbox" name="remember" /> lembrar me? </center>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--Login form end-->

	<!--Register Form-->
	<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div style="background:#005173; color:white;" class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="color:white;" aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel2"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Registro no Portal</h4>
				</div>
				<div class="modal-body">

					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#patient" aria-controls="patient" role="tab" data-toggle="tab">
								<span class="glyphicon glyphicon-user"></span> Paciente</a></li>
						<li role="presentation"><a href="#doctor" aria-controls="doctor" role="tab" data-toggle="tab">
								<span class="glyphicon glyphicon-education"></span> Doutor</a></li>
					</ul>
					<div class="tab-content">
						<!--Patient Registration-->
						<div role="tabpanel" class="tab-pane fade in active" id="patient">
							<br>
							<form method="POST" action="dp.php" ENCTYPE="multipart/form-data" action="" id="form1">
								<input type="text" name="pname" class="form-control" onkeyup="letters(this)" required placeholder="Enter your name"><br>
								<input type="email" name="pemail" class="form-control" required placeholder="Enter your email"><br>
								<input type="number" name="p_age" class="form-control" required placeholder="Enter your age"><br>
								<input type="password" name="p_password" class="form-control" required placeholder="Enter your password"><br>
								<input type="text" name="adridpt" class="form-control" required placeholder="Enter your Aadhar ID"><br>
								<input type="text" name="paddress" class="form-control" required placeholder="Enter your address"><br>

								<label>Gênero : </label>
								<input type="radio" value="Male" name="pgender" required> Masculino
								<input type="radio" value="Female" name="pgender" required> Feminino <br></br>
								<div class="input-group form-group ">
									<span class="input-group-addon">+55</span>
									<input type="number" name="p_phone" class="form-control" id="user" maxlength="10" placeholder="Enter your contact no." required>
								</div>
								<label>Sua foto</label>
								<input type="file" class="form-control" required name="pupload" /><br>
								<label data-toggle="tooltip" data-placement="right" title="Choose and remember answer carefully at the time of forget password it will be use">Select Security Question*</label>
								<br>
								<select name="sques" style="padding:5px">
									<option>Escolha uma pergunta de segurança</option>
									<option value="Whats the place where your mother born?">Qual é o lugar onde sua mãe nasceu?</option>
									<option value="What is your first vehice no.?">Qual é o seu primeiro veículo?</option>
									<option value="What is your first pet name?">Qual é o seu primeiro nome de animal de estimação?</option>
									<option value="What is your childood friend name?">Qual é o nome do seu melhor amigo?</option>
								</select>
								<br><br>
								<label>Sua resposta</label>
								<input type="text" class="form-control" placeholder="Enter your answer" required name="answer" /><br>
								<center><input type="submit" value="Register" name="btn_pat" class="btn btn-danger">
									<input type="button" value="Reset" onclick="rset()" class="btn btn-warning">
								</center>
							</form>

						</div>
						<!--Doctor Registration-->
						<div role="tabpanel" class="tab-pane fade" id="doctor">
							<br>
							<form ENCTYPE="multipart/form-data" method="POST" action="dp.php" id="form2">
								<input type="text" name="name" class="form-control" onkeyup="letters(this)" required placeholder="Enter your name"><br>
								<input type="email" name="email" class="form-control" required placeholder="Enter your email"><br>
								<input type="number" name="age" class="form-control" required placeholder="Enter your age"><br>
								<input type="password" name="password" class="form-control" required placeholder="Enter your password"><br>
								<input type="text" name="address" class="form-control" required placeholder="Enter your address"><br>
								<label>Gênero : </label>
								<input type="radio" value="Male" name="gender" required> Masculino
								<input type="radio" value="Female" name="gender" required> Feminino <br></br>
								<input type="text" name="docid" class="form-control" required placeholder="Enter your Doctor ID"><br>
								<input type="text" name="adrid" class="form-control" required placeholder="Enter your Aadhar ID"><br>
								<label>Especialista em: </label>
								<select style="color:solid #ccc; border-radius:0.2em; padding:5px;" name="doccat">
									<option>Escolha</option>
									<option value="Denitst">Dentista</option>
									<option value="Cardiologist">Cardiologista</option>
									<option value="Allergist">Alergista</option>
									<option value="Physcit">Psicologo</option>
									<option value="Gynoclogist">Ginecologista</option>
								</select><sup style="color:red;"> *Requerido</sup><br></br>
								<div class="input-group form-group ">
									<span class="input-group-addon">+55</span>
									<input type="number" name="phone" class="form-control" id="user" maxlength="10" placeholder="Enter your contact no." required>
								</div>
								<label data-toggle="tooltip" data-placement="right" title="PDF File Supported Only">Upload seu ID*</label>
								<input type="file" class="form-control" name="file" required /><br>
								<label>Sua foto</label>
								<input type="file" class="form-control" required name="newpic" /><br>
								<label data-toggle="tooltip" data-placement="right" title="Choose and remember answer carefully at the time of forget password it will be use">Select Security Question*</label>
								<br>
								<select name="psques" style="padding:5px">
									<option value="Choose a security question">Escolha uma pergunta de segurança</option>
									<option value="Whats the place where your mother born?">Qual é o lugar onde sua mãe nasceu?</option>
									<option value="What is your first vehice no.?">Qual ​​é o número do seu primeiro veículo</option>
									<option value="What is your first pet name?">Qual é o seu primeiro nome de animal de estimação?</option>
									<option value="What is your childood friend name?">Qual é o nome do seu melhor amigo?</option>
								</select>
								<br><br>
								<label>Sua resposta</label>
								<input type="text" class="form-control" placeholder="Enter your answer" required name="answer" /><br>
								<center><input type="submit" value="Register" name="btn_doc" class="btn btn-danger">
									<input type="button" value="Reset" onclick="rrset()" class="btn btn-warning">
								</center>
							</form>

						</div>
					</div>
				</div>





			</div>
		</div>
	</div>

	<script>
		function rset() {
			document.getElementById("form1").reset();
		}

		function rrset() {
			document.getElementById("form2").reset();
		}

		function letters(input) {
			var regex = /[^ a-z]/gi;
			input.value = input.value.replace(regex, "");
		}
	</script>


</body>

</html>