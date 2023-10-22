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
        <div id="questionsContainer">
        </div>
        <button type="button" class="btn btn-primary add-question">Add Question</button>
        <button type="submit" class="btn btn-success">Create Survey</button>
    </form>
</div>
<?php include "footer.php"; ?>
<script>
    $(document).ready(function() {
        let questionCounter = 0;

        $(document).on('click', '.add-question', function() {
            const questionsContainer = $('#questionsContainer');
            const newQuestionGroup = $(
                `<div class="form-group question-group" data-question="${questionCounter}">` +
                `<label for="question_text_${questionCounter}">Question Text:</label>` +
                `<input type="text" name="question_text[${questionCounter}]" class="form-control" id="question_text_${questionCounter}" required>` +
                `<div class="form-group answers-group ml-3" id="answers_group_${questionCounter}">` +
                `<label for="answer_text_${questionCounter}">Answer Text:</label>` +
                `<input type="text" name="answer_text[${questionCounter}][]" class="form-control" id="answer_text_${questionCounter}" required>` +
                `<button type="button" class="btn btn-primary add-answer" data-question="${questionCounter}">Add Answer</button>` +
                `<button type="button" class="btn btn-danger remove-answer">Remove Answer</button>` +
                `</div>` +
                `<button type="button" class="btn btn-danger remove-question ml-2">Remove Question</button>` +
                `</div>`
            );
            questionsContainer.append(newQuestionGroup);
            questionCounter++;
        });

        $(document).on('click', '.add-answer', function() {
            const questionIndex = $(this).data('question');
            const answersGroup = $(`#answers_group_${questionIndex}`);
            const newAnswerInput = $(
                `<div class="form-group answers-group ml-3">` +
                `<label for="answer_text_${questionIndex}">Answer Text:</label>` +
                `<input type="text" name="answer_text[${questionIndex}][]" class="form-control" id="answer_text_${questionIndex}" required>` +
                `<button type="button" class="btn btn-primary add-answer" data-question="${questionIndex}">Add Answer</button>` +
                `<button type="button" class="btn btn-danger remove-answer">Remove Answer</button>` +
                `</div>`
            );
            answersGroup.append(newAnswerInput);
        });

        $(document).on('click', '.remove-answer', function() {
            $(this).closest('.answers-group').remove();
        });

        $(document).on('click', '.remove-question', function() {
            $(this).closest('.question-group').remove();
        });
    });
</script>
