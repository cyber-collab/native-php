<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="jumbotron mt-5">
        <h1 class="display-4">Home page!</h1>
        <p class="lead">Please select the following options:</p>
        <?php if (empty($user)): ?>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="register" class="btn btn-primary"> Register </a>
                <a href="login" class="btn btn-primary"> Log in </a>
            </li>
        </ul>
        <?php else: ?>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="profile" class="btn btn-primary"> Your profile </a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
