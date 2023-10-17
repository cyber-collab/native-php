<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
</head>
<body>
<h1>Create Question</h1>
<form action="/question/create" method="post">
    <input type="hidden" name="survey_id" value="<?= $surveyId ?>">
    <label for="question_text">Question Text:</label>
    <input type="text" id="question_text" name="question_text" required><br><br>
    <input type="submit" value="Create">
</form>
</body>
</html>
