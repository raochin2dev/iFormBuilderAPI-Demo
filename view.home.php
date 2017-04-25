	<!DOCTYPE html>
	<html>
	<head>
		<title>My Demo App</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="form-group row">
				<h1>Register</h1>
				<a target="_blank" href="view.records.php">View All</a>
			</div>	
			<form method="POST" >
				<div class="form-group row">
				  <label for="example-text-input" class="col-2 col-form-label">Name</label>
				  <div class="col-5">
				    <input class="form-control" type="text" value="" name="name" required>
				  </div>
				</div>

				<div class="form-group row">
				  <label for="example-search-input" class="col-1 col-form-label">Gender</label>
				  <div class="col-5">
				    <label class="custom-control custom-radio">
					  <input name="gender" type="radio" class="custom-control-input" value="Male" />
					  <span class="custom-control-indicator"></span>
					  <span class="custom-control-description">Male</span>
					</label>
					<label class="custom-control custom-radio">
					  <input name="gender" type="radio" class="custom-control-input" value="Female" />
					  <span class="custom-control-indicator"></span>
					  <span class="custom-control-description">Female</span>
					</label>
				  </div>
				</div>
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Age</label>
				  <div class="col-5">
				    <input class="form-control" type="number" value="" name="age" required >
				  </div>
				</div>				
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Phone</label>
				  <div class="col-5">
				    <input class="form-control" type="tel" value="" name="phone" required>
				  </div>
				</div>				
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Address</label>
				  <div class="col-5">
				    <textarea class="form-control" rows="5" cols="5" name="address"></textarea>
				  </div>
				</div>				
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Email</label>
				  <div class="col-5">
				    <input class="form-control" type="email" value="" name="email" required autocomplete="off">
				  </div>
				</div>				
				<div class="form-group row">
				  <label for="example-search-input" class="col-2 col-form-label">Password</label>
				  <div class="col-5">
				    <input class="form-control" type="password" value="" name="password" required autocomplete="off">
				  </div>
				</div>				
				<div class="form-group row">
				  <!-- <label for="example-search-input" class="col-2 col-form-label">Is Admin?</label> -->
				  <div class="col-5">
				    <label class="custom-control custom-radio">
					  	<span class="custom-control-description">Today's Date</span>
						<input type="date" name="currdate">				
					  	<span class="custom-control-indicator"></span>
					</label>
				  </div>
				</div>
				<div class="form-group row">
				  <!-- <label for="example-search-input" class="col-2 col-form-label">Is Admin?</label> -->
				  <div class="col-5">
				    <label class="custom-control custom-radio">
					  <input id="radio2" type="checkbox" class="custom-control-input" required>
					  <span class="custom-control-indicator"></span>
					  <span class="custom-control-description">I agree all information is correct</span>
					</label>
				  </div>
				</div>
				<div class="form-group row">
					<input class="btn btn-primary" type="submit" value="Submit">
				</div>
			</form>
		</div>
	</body>

	</html>

