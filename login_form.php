<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Login for Jokes</h1>

    <?php
    include "db_connect.php";
    // include "search_all_jokes.php";
    ?>

    <form class="form-horizontal" action="process_login.php" method="post">
        <fieldset>
            <legend>Please login</legend>

            <!-- Username Input -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="username">Username</label>
                <div class="col-md-5">
                    <input id="username" type="text" name="username" placeholder="your name" class="form-control input-md" required="">
                    <p class="help-block">Enter your username</p>
                </div>
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="password">Password</label>
                <div class="col-md-5">
                    <input id="password" type="password" name="password" placeholder="password" class="form-control input-md" required="">
                    <p class="help-block">Enter your password</p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="password">Password</label>
                <div class="col-md-5">
                    <input id="password" type="password" name="password" placeholder="password" class="form-control input-md" required="">
                    <p class="help-block">Enter your password</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <label for="submit" class="col-md-4 control-label"></label>
                <div class="col-md-4">
                    <button id="submit" name="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
        </fieldset>
    </form>

    <?php
    // include "search_keyword.php";
    $mysqli->close();
    ?>
</body>
</html>
