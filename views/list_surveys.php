<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Surveys</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>List of Surveys</h1>
    <?php if (empty($surveys)): ?>
        <p>No surveys found.</p>
    <?php else: ?>
        <?php foreach ($surveys as $survey): ?>
            <div class="mb-4">
                <ul class="list-group">
                    <?php foreach ($survey->questions as $question): ?>
                        <li class="list-group-item">
                            <strong>Title:</strong> <?php echo $survey->getTitle(); ?><br>
                            <strong>Status:</strong> <?php echo $survey->getStatus(); ?><br>
                        </li>
                        <li class="list-group-item">
                            <strong>Question:</strong> <?php echo $question->question_text; ?><br>
                            <?php if (!empty($question->options)): ?>
                                <form action="/record_vote" method="post">
                                    <input type="hidden" name="question_id" value="<?php echo $question->getId(); ?>">
                                    <ul class="list-group">
                                        <?php foreach ($question->options as $answer): ?>
                                            <li class="list-group-item">
                                                <input type="radio" name="answer_id" value="<?php echo $answer->getId(); ?>">
                                                <label class="form-check-label"> <?php echo $answer->answer_text ?>
                                                    - Numbers votes <?php echo $answer->getVotes()?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <button type="submit" class="btn btn-primary mb-3 mt-3">Vote</button>
                                </form>
                            <?php else: ?>
                                <p>No answers found for this question.</p>
                            <?php endif; ?>
                            <a href="/survey/edit/<?php echo $survey->getId(); ?>" class="btn btn-primary">Edit</a>
                            <a href="/survey/delete/<?php echo $survey->getId(); ?>" class="btn btn-primary">Delete</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
