<?php

require_once '../config.php';
require_once ROOT_PATH . '/models/Database.php';
require_once ROOT_PATH . '/models/Quiz.php';
require_once ROOT_PATH . '/models/Question.php';
require_once ROOT_PATH . '/models/Answer.php';

if (!empty($_POST['question_type'])) {
    $result['state'] = false;
    $question_type = (int) $_POST['question_type'];
    $params = array('type' => $question_type);

    $quiz = new \models\Quiz(1);
    if (!empty($quiz)) {
        $result['state'] = true;
        $result['data'] = '';

        //Get questions by specific mode
        switch ($question_type) {
            case \models\Question::QUESTION_TYPE_ONE:
                $quiz_by_state = $quiz->getByTypeOne();
                $html_class = 'single-choice';
                break;
            case \models\Question::QUESTION_TYPE_TWO:
                $quiz_by_state = $quiz->getByTypeTwo();
                $html_class = 'multiple-choice';
                break;
            default:
                $quiz_by_state = $quiz;
                $html_class = '';
        }
        $total_questions = count($quiz_by_state);
        
        $result['data'] .= '<div class="user-quiz">
                <p class="title">' . $quiz->getTitle() . '</p>
                <ul>';
                    foreach ($quiz_by_state as $question => $data) {
                        $result['data'] .= '
                            <li class="question ' . $html_class . '" data-id="' . $data->getId() . '">
                            <p>' . $data->getTitle() . '</p>
                                <ul class="answers">';
                                foreach ($data->getAnswers() as $answer => $answer_data) {
                                    $result['data'] .= '<li><input type="radio" name="answer-radio" value="' . $answer_data->getId() . '" class="answers-radio" >' . $answer_data->getTitle() . '</li>';
                                    if ($question_type === \models\Question::QUESTION_TYPE_ONE) {
                                        $result['data'] .= ''
                                                . '<a href="#" class="btn btn-info answer-single-choice" data-id="1">Yes</a>'
                                                . '<a href="#" class="btn btn-danger answer-single-choice" data-id="0">No</a>';
                                    }
                                }
                                $result['data'] .= '
                                </ul>
                            </li>
                            ';
                    }
                    $result['data'] .= '
                </ul>
                <a href="#" class="show-next-question btn btn-primary"> &gt;&gt; Next question</a>
                <p class="total-quotes text-center">Quotes: <span class="current-cocunter">1</span> of <span class="total-cocunter">' . $total_questions . '</span></p>
                </div>';
    }
    echo json_encode($result);
}
