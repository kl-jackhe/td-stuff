<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Page Not Found - FLATY Admin</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<!--base css styles-->
		<link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css?v=3.3.7">
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
		<link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.min.css?v=4.7.0">
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
		<!--page specific css styles-->
		<!--flaty css styles-->
		<link href="/assets/admin/css/flaty.css" rel="stylesheet">
		<link href="/assets/admin/css/flaty-responsive.css" rel="stylesheet">
	</head>
	<body class="error-page">
		<!-- BEGIN Main Content -->
		<div class="error-wrapper">
			<h4>Page Not Found<span>404</span></h4>
			<p>噢噢！對不起, 該頁面找不到<br/>請確認網址是否輸入錯誤？</p>
			<br/>
			<form action="#" method="post" class="hide">
				<div class="form-group">
					<div class="input-group">
						<input type="text" placeholder="Search a site ..." class="form-control" />
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</div>
			</form>
			<hr/>
			<p class="clearfix">
				<a href="javascript:history.back()" class="pull-left">← 回到上一頁</a>
				<a href="/admin" class="pull-right">回到導覽列</a>
			</p>
		</div>
		<!-- END Main Content -->
		<!--basic scripts-->
		<script src="/node_modules/jquery/dist/jquery.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
		<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
	</body>
</html>