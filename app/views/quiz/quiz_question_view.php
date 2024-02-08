<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Question du quiz</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/quiz_question.css">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="quiz-card card text-center">
                <div class="card-header">
                    Question <?php echo ($currentQuestionIndex + 1); ?> sur <?php echo count($questions); ?>
                </div>
                <div class="card-body">
                    <h2 class="quiz-question"><?php echo htmlspecialchars($currentQuestion['question_text']); ?></h2>
                    <form action="index.php?page=handleQuestionSubmission" method="post" class="quiz-options">
                        <?php foreach ($options as $option): ?>
                            <div class="quiz-option" onclick="selectOption(this)">
                                <?php echo htmlspecialchars($option['option_text']); ?>
                                <input type="radio" name="answer" value="<?php echo $option['option_id']; ?>" hidden required>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" class="btn btn-submit mt-4">Valider</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function selectOption(element) {
        document.querySelectorAll('.quiz-option').forEach(function(option) {
            option.classList.remove('selected');
        });
        element.classList.add('selected');
        let radio = element.querySelector('input[type=radio]');
        radio.checked = true;
    }
</script>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




