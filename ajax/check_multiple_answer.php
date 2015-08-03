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

    //user answer
    $user_answer = \models\Answer::getAnswers(array('id' => $user_answer_id));
    $user_answer_id = $user_answer[key($user_answer)]->getId();

    //question details
    $question_params = array('id' => $user_question_id, 'is_correct' => \models\Question::QUESTION_CORRECT);
    $question = \models\Question::getQuestions($question_params);
    $correct_answer = $question[$user_question_id]->getCorrectAnswer();
    $correct_answer_id = $correct_answer[key($correct_answer)]->getId();
    $correct_answer_title = $correct_answer[key($correct_answer)]->getAuthor();

    if (!empty($question) && !empty($user_answer)) {
        if($correct_answer_id === $user_answer_id){
            $result['state'] = true;
        }
        $result['response_answer'] = $correct_answer_title;
    }
    echo json_encode($result);
}