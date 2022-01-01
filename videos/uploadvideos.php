<!DOCTYPE html>
<html>
<head>
	<title>Video Upload</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PATHSHALA</a>
	  	<ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
	        <a class="nav-link" href="javascript:history.go(-1)" title="Return to previous page">BACK TO CLASS<span class="sr-only">(current)</span></a>
	      </li>
  		</ul>
	</nav>
</head>
<body>
<?php
    $current_class_code = htmlspecialchars($_GET["code"]);
?>
<div class="container" >

<div class="col-9">
<br>
<br>
<br>
<h2>Upload Lecture</h2>
<br>
<form action="video_submit.php?code=<?php echo $current_class_code ?>" method="post" enctype="multipart/form-data">

<div class="form-group">
<label for="title">Lecture Description</label>
<input class="form-control" type="text" name="description" placeholder="Lecture Description" required>
</div>


<div class="form-group">
<label for="title">Select File</label>
<input class="form-control" type="file" name="sub_emp" id="sub_emp" placeholder="Upload File" required>
</div>

<br>
<button type="submit" class="btn btn-primary mb-2">Submit</button>


  <!--<input type="text" id="title" name="title"><br>
  <span class="error">* </span>
  <label for="desc">Description:</label><br>
  <input type="desc" id="desc" name="desc"><br>
  <label for="marks">Total Marks:</label><br>
  <input type="number" id="marks" name="marks"><br>
  <label for="due">Due Date:</label><br>
  <input type="date" id="due" name="due"><br><br>
  <button type="button" class="btn btn-success">Create Assignment</button> -->
</form>
</div>
</div>

</body>
</html>
