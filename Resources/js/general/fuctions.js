function logout () {
	$.ajax({
	  url: "Controllers/logout.php"
	});
	window.location.href = "index.php";
}