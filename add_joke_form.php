<!DOCTYPE html>
<html>
<head>
    <title>Add a New Joke</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add a New Joke</h2>
        <form action="add_joke.php" method="post" class="form-horizontal">
            <!-- Joke Question -->
            <div class="form-group">
                <label class="col-sm-2 control-label" for="Joke_question">New Joke</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Joke_question" id="Joke_question" placeholder="Enter the joke question" required>
                </div>
            </div>

            <!-- Joke Answer -->
            <div class="form-group">
                <label class="col-sm-2 control-label" for="Joke_answer">Joke Answer</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="Joke_answer" id="Joke_answer" placeholder="Enter the joke answer" required></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit" class="btn btn-primary">Add Joke</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>



