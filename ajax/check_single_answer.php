<?php

require_once '../config.php';
require_once ROOT_PATH . '/models/Database.php';
require_once ROOT_PATH . '/models/Quiz.php';
require_once ROOT_PATH . '/models/Question.php';
require_once ROOT_PATH . '/models/Answer.php';

if (!empty($_POST['question_id']) && !empty($_POST['user_answer_id'])) {
    $result = array();
    $result['state'] = false;
    $result['response_answer'] = '';

    $user_question_id = (int) $_POST['question_id'];
    $user_answer_id = (int) $_POST['user_answer_id'];
    $user_answer = (int) $_POST['user_answer'];

    //user answer
    $answer_obj = \models\Answer::getAnswers(array('id' => $user_answer_id));
    if (!empty($answer_obj)) {
        if ($answer_obj[key($answer_obj)]->getIsCorrect() === $user_answer) {
            $result['state'] = true;
        }
        $result['response_answer'] = $answer_obj[key($answer_obj)]->getAuthor();
    }

    echo json_encode($result);
}