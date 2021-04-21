<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$msg = $this->session->tempdata('msg');
	$id = $this->session->userdata('id');
	$first_name = $this->session->userdata('first_name');
	$last_name = $this->session->userdata('last_name');
	if(!$msg){
		$msg[0] = "";
		$msg[1] = "";
	} ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= $title ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Jeffrey Carl">

		<link href="../../user_guide/_bootstrap/bootstrap.css" rel="stylesheet">
		<link href="../../user_guide/_bootstrap/bootstrap-responsive.css" rel="stylesheet">
		<link href="../../user_guide/_css/style.css" rel="stylesheet">
	</head>

	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
<?php			if($id){ ?>
					<a href="" class="brand" >Test App</a>
					<ul class="nav">
						<li><a href="/dashboard">Dashboard</a></li>
						<li><a href="/users/edit"><?= $first_name." ".$last_name ?></a></li>
					</ul>
					<a href="/users/signout_user" class="btn pull-right">Sign out</a>
<?php			}else{ ?>
					<a href="" class="brand" >Test App</a>
					<ul class="nav">
						<li class="active"><a href="<?= base_url() ?>">Home</a></li>
					</ul>
					<a href="/users/signin" class="btn pull-right">Sign in</a>
<?php			} ?>
				</div>
			</div>
		</div>
		<div class="container msg">
			<div class="<?= $msg[0] ?>">
				<strong><?= $msg[1] ?></strong>
			</div>
		</div>
