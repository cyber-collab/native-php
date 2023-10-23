<?php include "header.php"; ?>

<div class="container">
    <div class="jumbotron mt-5">
        <h1 class="display-4">Home page!</h1>
        <p class="lead">Please select the following options:</p>
        <?php if (empty($user)): ?>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="register" class="btn btn-primary"> Register </a>
                <a href="login" class="btn btn-primary"> Log in </a>
                <a href="all-surveys" class="btn btn-primary"> Surveys </a>

            </li>
        </ul>
        <?php else: ?>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="profile" class="btn btn-primary"> Your profile </a>
                    <a href="logout" class="btn btn-primary"> Logout </a>
                    <a href="all-surveys" class="btn btn-primary"> Surveys </a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php
include "footer.php";
?>
