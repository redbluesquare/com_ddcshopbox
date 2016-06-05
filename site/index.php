<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link href="assets/css/template.css" rel="stylesheet" type="text/css" />
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
<script src="assets/js/script.js"></script>

</head>
<body data-ng-app="">
	
		<div class="row header-homepage" style="height:300px;">
			<div class="container">
		
			
				<input class="mypostcode col-xs-push-2 col-xs-8" type="text" name="mypostcode" data-ng-model="mypostcode" />
				<input class="mypostcodebtn" type="submit" value="Let's Go >" />
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="header-foot">
				<div class="container">
					<p>{{mypostcode}}</p>
				</div>
				
			</div>
		</div>
		<div class="row">
			<div class="body-main container">
				<p>{{mypostcode}}</p>
			</div>
		</div>
		
		



</body>
</html>