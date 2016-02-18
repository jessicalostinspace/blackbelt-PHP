<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Welcome</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>	

		<style type="text/css">
		*{
			font-family: sans-serif;

		}
		.user_display{
			
			padding: 10px;
			width: 600px;
		}
		td{
			padding: 5px;
		}
		h1{
			padding: 5px;
		}
		.poke_info{
			border: 1px solid black;
			width: 300px;
			padding: 5px;
			margin: 10px;
		}
		</style>
	</head>
	<body>
		<div class="container">
					<nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <!-- <a class="navbar-brand" href="/">Test App</a> -->
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			     	<ul class="nav navbar-nav">
						<li><a href="/logins/logout">Log off</a></li>
					</ul>
				</div>	

			</nav>


<!-- var_dump($user_data);var_dump($pokes);var_dump($all_users);exit;  -->
		<div><h1>Welcome, <?= $user_data['alias'] ?>!</h1>
		<p><?= $profilePokes[0]['number_pokes'] ?> people poked you!</p></div>

			<div class="poke_info">
				<?php 
				// var_dump($individualPokes);die;
				
				// foreach($individualPokes as $tokes)
				// {	
				// 		$individualPokes[] = uasort($tokes, function($a, $b) {
				// 		    return $b['number_pokes'] <=> $a['number_pokes'];
				// 		});
				// }		
					// foreach($pokes as $poke){

					// 	);
					// }}


				foreach($individualPokes as $pokes)
				{	
					foreach($pokes as $poke){
						if($poke['number_pokes'] > 0){

					?>
					<p><?= $poke['alias'] ?> poked you <?= $poke['number_pokes'] ?> times!</p>

				<?php }
			}
				} ?>


			</div>


			<div class="user_display">
				<p>People you may want to poke:</p>
				<table border="1">
					<thead>
						<tr>
							<td>Name</td>
							<td>Alias</td>
							<td>Email Address</td>
							<td>Poke History</td>
							<td>Action</td>
						</tr>
					</thead>
					<?php
							foreach($all_users as $users)
							{  if($users['id'] != $user_data['id']){
								foreach($pokeHistory[$users['id']] as $history){
								?>
								<tr>
									<td><?= $users['name'] ?></td>
									<td><?= $users['alias'] ?></td>
									<td><?= $users['email'] ?></td>
									<td><?= $history ?> pokes</td>
									<td><a href="/logins/poke/<?= $users['id'] ?>">Poke!</a></td>
								</tr>
							<?php
						}
							} 
							}?>
				</table>
			</div>

		</div>
	</body>
</html>