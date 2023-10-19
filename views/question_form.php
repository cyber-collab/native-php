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

    <div id="answers-container">
    </div>
    <button type="button" onclick="addAnswer()">Добавить ответ</button>
    <input type="submit" value="Create">
</form>
<script>
    function addAnswer() {
        let container = document.getElementById("answers-container");
        let input = document.createElement("input");
        input.type = "text";
        input.name = "answers[]";
        input.required = true;
        container.appendChild(input);
    }
</script>

</body>
</html>
