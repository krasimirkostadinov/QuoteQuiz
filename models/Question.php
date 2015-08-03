<?php

namespace models;

/**
 * Contain all the data needed for Question representing Question >> Answer
 * For more flexibility see getters
 * @author Krasimir
 */
class Question {

    private $id;
    private $quiz_id = 0;
    private $order = 0;
    private $type = 0;
    private $title = '';

    private $answers = array();
    private $correct_answer = array();

    const QUESTION_TYPE_ONE = 1; //single choice Yes/No
    const QUESTION_TYPE_TWO = 2; //multiple choice
    const QUESTION_CORRECT = 1; //flag show is this answer correct

    protected static $db;

    public function __construct($id = null) {
        self::$db = new \models\Database();

        $id = (int) $id;
        if (!empty($id)) {
            $this->init($id);
        }
    }

    public function init($id) {
        $this->id = (int) $id;
        if (!empty($this->id)) {
            $sql = '
                SELECT qu.*
                FROM questions AS qu
                WHERE qu.id = :id
            ';
            $params = array('id' => $this->id);

            $num_rows = self::$db->prepare($sql, $params)->execute()->getAffectedRows();
            if ($num_rows === 1) {
                $rows = self::$db->fetchAllAssoc();
                $question = self::createQuestionsObjects($rows);
                if (count($question) === 1) {
                    $k = key($question);
                    if ($question[$k] instanceof \models\Question) {
                        $this->id = $question[$k]->id;
                        $this->quiz_id = $question[$k]->quiz_id;
                        $this->order = $question[$k]->order;
                        $this->type = $question[$k]->type;
                        $this->title = $question[$k]->title;
                        $this->answers = \models\Answer::getAnswers(array('question_id' => $question[$k]->id));
                    }
                }
            }
            else {
                throw new \Exception('Question with ID [' . $id . '] not exist!');
            }
        }
    }

    /**
     * Create question object
     * @param array $rows
     * @return \models\Question
     */
    public static function createQuestionsObjects($rows) {
        if (!empty($rows) && is_array($rows)) {
            foreach ($rows as $row) {
                $key = $row['id'];
                $question[$key] = new \models\Question();
                $question[$key]->id = $row['id'];
                $question[$key]->quiz_id = $row['quiz_id'];
                $question[$key]->order = $row['order'];
                $question[$key]->type = $row['type'];
                $question[$key]->title = $row['title'];
                $question[$key]->answers = \models\Answer::getAnswers(array('question_id' => $row['id']));
                $question[$key]->correct_answer = \models\Answer::getAnswers(array('question_id' => $row['id'], 'is_correct' => self::QUESTION_CORRECT));
            }
            return !empty($question) ? $question : null;
        }
        return null;
    }

    /**
     * Get questions from DB by given parameters
     * @param array $params for query of type $key => $value
     * @param string $quiz_id=> quiz id
     * @param bool $return_as_array
     * @return \models\Question | array
     */
    public static function getQuestions($params = array(), $return_as_array = false) {
        $db = new \models\Database();

        $sql = $order = $limit = $select_init = ' ';
        $where = ' WHERE 1  ';
        $values = array();

        if (!empty($params) && is_array($params)) {
            if (isset($params['sql'])) {
                $sql .= ' ' . $params['sql'] . ' ';
            }
            if (isset($params['where'])) {
                $where .= ' ' . $params['where'] . ' ';
            }
            if (isset($params['values']) && is_array($params['values'])) {
                foreach ($params['values'] as $k => $v) {
                    $values[$k] = $v;
                }
            }
            if (isset($params['id'])) {
                $where .= ' AND qu.id = :id ';
                $values['id'] = $params['id'];
            }
            if (isset($params['quiz_id'])) {
                $where .= ' AND qu.quiz_id = :quiz_id ';
                $values['quiz_id'] = $params['quiz_id'];
            }
            if (isset($params['type'])) {
                $where .= ' AND qu.type = :type ';
                $values['type'] = $params['type'];
            }
            if (isset($params['order'])) {
                $where .= ' AND qu.order = :order ';
                $values['order'] = $params['order'];
            }
            if (isset($params['title'])) {
                $where .= ' AND qu.title = :title ';
                $values['title'] = $params['title'];
            }

            if (isset($params['order'])) {
                $order = ' ORDER BY ' . $params['order'] . ' ';
            }
            if (isset($params['limit'])) {
                $limit = ' LIMIT ' . $params['limit'] . ' ';
            }
        }

        $query = 'SELECT qu.*
                FROM questions AS qu
                ' .
                $sql . $where . $order . $limit . '
            ';

        //echo $db->prepare($query, $values)->getSqlInterpolated();

        $db->prepare($query, $values)->execute();
        $rows = $db->fetchAllAssoc();
        if (!$return_as_array) {
            $questions = self::createQuestionsObjects($rows);
            return $questions;
        }
        else {
            return $rows;
        }
    }


    public function getId() {
        return $this->id;
    }

    public function getQuiz_id() {
        return $this->quiz_id;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getType() {
        return $this->type;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAnswers(){
        return $this->answers;
    }

    public function getCorrectAnswer(){
        return $this->correct_answer;
    }
}
