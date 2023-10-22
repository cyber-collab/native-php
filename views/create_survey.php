<?php include "header.php"; ?>
<div class="container mt-5">
    <h1>Create Survey</h1>
    <form action="/survey/new" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary add-question">Add Question</button>
        </div>
        <div id="questionsContainer"></div>
        <button type="submit" class="btn btn-success">Create Survey</button>
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
                '<input type="text" name="answer_text[]" class="form-control">' +
                '<div class="mt-2">' +
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
                '<input type="text" name="answer_text[]" class="form-control">' +
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
<?php include "footer.php"; ?>
