<!DOCTYPE html>
<html>
<head>
	<title>Pokes</title>
</head>
<body>
	<?php
			if($this->session->userdata("User") === NULL)
			{
				$error = "Access denied. You must be signed in!";
				$this->session->set_flashdata("errors", $error);
				redirect("/");
			}
	?>	
	<div id="container">
		<a href="/sessions/logout">Logout</a>
		<div>
			<h1 id="welcome">Welcome, <?= $this->session->User["user_alias"] ?>!</h1>
			<h3 id="poked"><?= $mypokes["mypokes"] ?> people poked you</h3>
		</div>
		<div id="pokeHistory">
<?php
			foreach ($mydistinctpokers as $key => $value) {
?>
				<p><?= $value["alias"] ?> poked you <?= implode("", $value["pokers.id"])?> times</p>
<?php
			}
?>
		</div>
		<div id="pokeTable">
			<h4>People you may want to poke:</h4>
			<table>
				<thead>
					<th>Name</th>
					<th>Alias</th>
					<th>Email Address</th>
					<th>Poke History</th>
					<th>Action</th>
				</thead>
				<tbody>
<?php 
						foreach ($users as $key => $value) {
 ?>
 							<tr>
 								<form action="/pokes/newpoke" method="post">
		 							<input type="hidden" name="userid" value="<?= $value["id"] ?>">
		 							<input type="hidden" name="pokerid" value="<?= $this->session->User["user_id"] ?>">
		 							<td><?= $value["name"] ?></td>
		 							<td><?= $value["alias"] ?></td>
		 							<td><?= $value["email"] ?></td>
		 							<td><?= implode("", $value["numpokes"])?> pokes.</td>
		 							<td>
										<input type="submit" value="Poke!">
		 							</td>
		 						</form>	
 							</tr>
<?php							
						}
?>
				</tbody>	
			</table>
		</div>
	</div>
</body>
</html>