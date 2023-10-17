<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
</head>
<body>
<h1>Create Survey</h1>
<form action="/survey/new" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="question_text">Question Text:</label>
    <input type="text" id="question_text" name="question_text"><br><br>

    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
    </select>
    <br>
    <br>
    <input type="submit" value="Create Survey">
</form>
</body>
</html>
