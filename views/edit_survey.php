<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Survey</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" id="questionsContainer">
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
                            <input type="text"  name="answer_text[<?php echo $question->getId(); ?>][<?php echo $answer->getId(); ?>]" class="form-control answer-text" value="<?php echo $answer->answer_text; ?>">
                            <button type="button" class="btn btn-danger remove-answer mt-2">Remove Answer</button>
                        </div>
                    <?php endforeach; ?>
                    <button type="button" class="btn btn-primary add-answer">Add Answer</button>
                </div>

                <button type="button" class="btn btn-danger remove-question ml-2">Remove Question</button>
            </div>
        <?php endforeach; ?>

        <div class="form-group mt-4">
            <button type="button" class="btn btn-primary add-question mr-2">Add Question</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        function generateUniqueId() {
            return 'new_' + Date.now();
        }

        $(document).on('click', '.add-question', function() {
            const questionsContainer = $('#questionsContainer');
            const newQuestionId = generateUniqueId();
            const newAnswerId = generateUniqueId();

            const newQuestionGroup = $(
                '<div class="form-group question-group">' +
                '<div class="mb-3"></div>' +
                '<label for="question_text">Question Text:</label>' +
                `<input type="text" name="question_text[${newQuestionId}]" class="form-control">` +
                '<div class="form-group answers-group ml-3">' +
                '<label for="answer_text">Answer Text:</label>' +
                `<input type="text" name="answer_text[${newQuestionId}][${newAnswerId}]" class="form-control">` +
                '<button type="button" class="btn btn-danger remove-answer">Remove Answer</button>' +
                '<input type="hidden" name="deleted_answers[]" value="">' +
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
            const newAnswerId = generateUniqueId();

            const newAnswerInput = $(
                '<div class="mb-3">' +
                `<input type="text" name="answer_text[<?php echo $question->getId()?>][${newAnswerId}]" class="form-control">` +
                '<button type="button" class="btn btn-danger remove-answer mt-2">Remove Answer</button>' +
                '</div>'
            );

            const addAnswerButton = $(this).closest('.question-group').find('.add-answer');
            addAnswerButton.before(newAnswerInput);
        });

        $(document).on('click', '.remove-question', function() {
            $(this).closest('.question-group').remove();
        });

        $(document).on('click', '.remove-answer', function() {
            const answerText = $(this).siblings('.answer-text');
            const nameAttribute = answerText.attr('name');

            if (nameAttribute == null) {
                $(this).closest('.mb-3').remove();
            } else {
                const match = nameAttribute.match(/\[(\d+)\]\[(\d+)\]/);

                if (match) {
                    const answerId = match[2];
                    const deletedAnswersInput = $('<input type="hidden" name="deleted_answers[]">');
                    deletedAnswersInput.val(answerId);

                    $(this).closest('.mb-3').replaceWith(deletedAnswersInput);
                }
            }
        });
    });
</script>
</body>
</html>
