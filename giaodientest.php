<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>SOWH</title>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<style>
		h3 {
			display: block;
			font-size: 1.17em;
			margin-block-start: 1em;
			margin-block-end: 1em;
			margin-inline-start: 0px;
			margin-inline-end: 0px;
			font-weight: bold;
			unicode-bidi: isolate;
		}
		ul {
			display: block;
			list-style-type: disc;
			margin-block-start: 1em;
			margin-block-end: 1em;
			margin-inline-start: 0px;
			margin-inline-end: 0px;
			padding-inline-start: 0px;
			unicode-bidi: isolate;
		}
		nav {
			height: 200px;
			width: 100%;
			display: flex;
			justify-content: space-between;
			background: url(img/header.png) no-repeat;
			background-position: 50% 30%;
			background-size: cover;
		}
		.img-nav{
			width: 200px; 
			height: 100px;
			margin: 20px;
			padding: 10px;
		}
		.img-nav img{
			width: 200px; 
			height: 100px;
			margin: 20px;
			padding: 10px;
		}
		.content{
			width: 300px; 
			height: 100%;
			display: flex;
			background-color: rgba(255, 255, 255, 0.5);
			flex-direction: column;
		}
		.fa{
			font-size: 100px;
		}
		.content1{
			display: flex;
		}
		.content2{
			display: flex;
		}
		div .content11{
			margin 10;
		}
		.dropdown {
            position: relative;
            display: inline-block;
            margin-left: 50px;
        }
		.dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
            border-radius: 5px;
            overflow: hidden;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
		.dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
	</style>
</head>
<body>
	<header>
		<nav>
			<div class="img-nav">
                <img src="img/logo.png" alt="" />
			</div>
			<div class="content">
				<div class="content1">
					<div class="content11">
						<a  href="giaodiendangnhap.php">
							<i class="fa fa-user" aria-hidden="true"></i>
						</a>
					</div>
					<div class="content12">
						<?php
							if (isset($_SESSION['tk'])) {
								$tk = $_SESSION['tk']; // Lấy tên đăng nhập từ phiên
							echo '<a href="giaodiendangnhap.php" class="right"><h3 style="color: white;">' . $tk . '</h3></a>;';
							}
						?>
					</div>	
				</div>
				<div class="content2">
					<div class="content11">
						<a  href="giaodiendangnhap.php">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</a>
					</div>
					<ul>
						<li class="dropdown">
							<a href="giaodiendangnhap.php" class="right"><h3 style="color: white;">Khác</h3></a>
							<div class="dropdown-content">
								<a href="">Lịch sử </a>
								<a href="#register">Đăng ký </a>
								<a href="giaodiendangnhap.php">Đăng nhập</a>
								<a href="xuli.php">Đăng xuất tài khoản  </a>
							</div>
						</li>
					</ul>
				</div>
			</div>
	</header>
</body>