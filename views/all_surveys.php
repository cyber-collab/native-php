<?php include "header.php"; ?>

<div class="container mt-5">
    <h1>List of Surveys</h1>
    <?php if (empty($surveys)): ?>
        <p>No surveys found.</p>
    <?php else: ?>
        <form action="/filter-surveys" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="">All</option>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="form-group">
                <label for="published_date">Published Date:</label>
                <input type="date" id="published_date" name="published_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <?php foreach ($surveys as $survey): ?>
            <div class="mb-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Title:</strong> <?php echo $survey->getTitle(); ?><br>
                        <strong>Status:</strong> <?php echo $survey->getStatus(); ?><br>
                    </li>
                    <?php foreach ($survey->questions as $question): ?>
                        <li class="list-group-item">
                            <strong>Question:</strong> <?php echo $question->question_text; ?><br>
                            <?php if (!empty($question->options)): ?>
                                <form action="/record-vote" method="post">
                                    <input type="hidden" name="question_id" value="<?php echo $question->getId(); ?>">
                                    <ul class="list-group">
                                        <?php foreach ($question->options as $answer): ?>
                                            <li class="list-group-item">
                                                <input type="radio" required name="answer_id" value="<?php echo $answer->getId(); ?>">
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
