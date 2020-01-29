<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
</head>
<body>
   
<div class="container">
<div ng-app="">

<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">{{name}}
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
     <fieldset>
    <label for="radio-1">New York</label>
    <input type="radio" name="radio-1" id="radio-1" ng-model="name"value='New York'><br>
    <label for="radio-2">Paris</label>
    <input type="radio" name="radio-1" id="radio-2" ng-model="name"value='Paris'><br>
    <label for="radio-3">London</label>
    <input type="radio" name="radio-1" id="radio-3" ng-model="name" value='London'>
     </fieldset>
    </ul>
  </div>
</div>
</div>
</body>
</html>