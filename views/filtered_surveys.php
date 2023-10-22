<?php include "header.php"; ?>
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
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include "footer.php"; ?>
