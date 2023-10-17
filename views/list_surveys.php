<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Surveys</title>
</head>
<body>
<h1>List of Surveys</h1>
<?php dump($surveys) ?>
<?php if (empty($surveys)): ?>
    <p>No surveys found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($surveys as $survey): ?>
            <li>
                <strong>Title:</strong> <?php echo $survey->getTitle(); ?><br>
                <strong>Status:</strong> <?php echo $survey->getStatus(); ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>
