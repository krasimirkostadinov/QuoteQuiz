<?php
require_once './config.php';
require_once ROOT_PATH . '/views/header.php';
require_once ROOT_PATH . '/models/Database.php';
require_once ROOT_PATH . '/models/Quiz.php';
require_once ROOT_PATH . '/models/Question.php';
require_once ROOT_PATH . '/models/Answer.php';
$quiz = \models\Quiz::getQuiz();
?>
<div class="container-fluid main-container">
    <div class="row clearfix">
        <div class="container">
            <h1>Welcome to our quiz system</h1>
            <div class="row clearfix" role="tabpanel">
                <ul class="nav nav-tabs animals-tab" role="tablist">
                    <li role="presentation" class="active"><a href="#tab-one" id="tab-to-one" aria-controls="tab-two" role="tab" data-toggle="tab" aria-expanded="true">Quiz preview</a></li>
                    <li role="presentation"><a href="#tab-two" id="tab-to-two" aria-controls="tab-two" role="tab" data-toggle="tab">Choose mode</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-one" role="tabpanel" class="tab-pane fade in active" aria-labelledby="tab-to-one">
                        <?php
                        require_once ROOT_PATH . '/views/quiz_preview.php';
                        ?>
                    </div>
                    <div id="tab-two" role="tabpanel" class="tab-pane fade " aria-labelledby="tab-to-two">
                        <?php
                        require_once ROOT_PATH . '/views/choose_mode.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once ROOT_PATH . '/views/footer.php';
?>



