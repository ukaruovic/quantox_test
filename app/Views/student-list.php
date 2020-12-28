<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Student Board</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</style>
<body>
<div class="container">
    <h2>Student Board</h2>
    <!-- Content here -->
    <div class="row mt-3">
        <div class="col-1"><strong>ID</strong></div>
        <div class="col-3"><strong>Name</strong></div>
        <div class="col-3"><strong>Board</strong></div>
    </div>
    <?php if(count($students)): ?>
        <?php foreach ($students as $student): ?>
            <div class="row mt-3">
                <div class="col-1"><?php echo htmlspecialchars($student->getId()); ?></div>
                <div class="col-3"><?php echo htmlspecialchars($student->getName()); ?></div>
                <div class="col-3"><?php echo htmlspecialchars($student->getBoardType()); ?></div>
                <div class="col-3"><a class="btn btn-primary" href="/?student=<?php echo htmlspecialchars($student->getId()); ?>">Results</a></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>