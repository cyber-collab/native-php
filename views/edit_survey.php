<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Survey</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Survey</h1>
    <form action="/survey/update/<?php echo $survey->getId(); ?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?php echo $survey->getTitle(); ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control">
                <option value="draft" <?php if ($survey->getStatus() == 'draft') echo 'selected'; ?>>Draft</option>
                <option value="published" <?php if ($survey->getStatus() == 'published') echo 'selected'; ?>>Published</option>
            </select>
        </div>

        <?php foreach ($survey->getQuestions() as $question): ?>
            <div class="form-group question-group">
                <div class="mb-3"></div>
                <label for="question_<?php echo $question->getId(); ?>">Question Text:</label>
                <input type="text" name="question_text[<?php echo $question->getId(); ?>]" class="form-control" value="<?php echo $question->question_text; ?>">

                <div class="form-group answers-group ml-3">
                    <label for="answer_text">Answer Text:</label>
                    <?php foreach ($question->getAnswers() as $answer): ?>
                        <div class="mb-3">
                            <input type="text" name="answer_text[<?php echo $question->getId(); ?>][<?php echo $answer->getId(); ?>]" class="form-control" value="<?php echo $answer->answer_text; ?>">
                            <button type="button" class="btn btn-danger remove-answer">Remove Answer</button>
                        </div>
                    <?php endforeach; ?>
                    <button type="button" class="btn btn-primary add-answer">Add Answer</button>
                </div>

                <button type="button" class="btn btn-danger remove-question ml-2">Remove Question</button>
            </div>
        <?php endforeach; ?>

        <button type="button" class="btn btn-primary add-question">Add Question</button>
        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.add-question', function() {
            const questionsContainer = $('#questionsContainer');
            const newQuestionGroup = $(
                '<div class="form-group question-group">' +
                '<div class="mb-3"></div>' +
                '<label for="question_text">Question Text:</label>' +
                '<input type="text" name="question_text[]" class="form-control">' +
                '<div class="form-group answers-group ml-3">' +
                '<label for="answer_text">Answer Text:</label>' +
                '<input type="text" name="answer_text[new][]" class="form-control">' +  // Updated name attribute
                '<button type="button" class="btn btn-danger remove-answer">Remove Answer</button>' +
                '</div>' +
                '<div class="mt-2">' +
                '<button type="button" class="btn btn-primary add-answer">Add Answer</button>' +
                '<button type="button" class="btn btn-danger remove-question ml-2">Remove Question</button>' +
                '</div>' +
                '</div>'
            );
            questionsContainer.append(newQuestionGroup);
        });

        $(document).on('click', '.add-answer', function() {
            const answersGroup = $(this).closest('.question-group').find('.answers-group');
            const newAnswerInput = $(
                '<div class="mb-3"></div>' +
                '<input type="text" name="answer_text[new][]" class="form-control">' +  // Updated name attribute
                '<button type="button" class="btn btn-danger remove-answer">Remove Answer</button>'
            );
            answersGroup.append(newAnswerInput);
        });

        $(document).on('click', '.remove-answer', function() {
            $(this).closest('.answers-group').find('input').last().remove();
            $(this).remove();
        });

        $(document).on('click', '.remove-question', function() {
            $(this).closest('.question-group').remove();
        });
    });
</script>
</body>
</html>
