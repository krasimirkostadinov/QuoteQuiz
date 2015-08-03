<?php

namespace models;

/**
 * Contain all the data needed for Quiz representing structure Quiz >> Question >> Answer
 * For more flexibility see getters
 * @author Krasimir
 */
class Quiz {

    private $id;
    private $title = 0;
    private $questions = array();
    private $by_type_one = array();
    private $by_type_two = array();
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
                SELECT qz.*
                FROM quiz AS qz
                WHERE qz.id = :id
            ';

            $params = array('id' => $this->id);

            $num_rows = self::$db->prepare($sql, $params)->execute()->getAffectedRows();
            if ($num_rows === 1) {
                $rows = self::$db->fetchAllAssoc();
                $quiz = self::createQuizObjects($rows);
                if (count($quiz) === 1) {
                    $k = key($quiz);
                    if ($quiz[$k] instanceof \models\Quiz) {
                        $this->id = $quiz[$k]->id;
                        $this->title = $quiz[$k]->title;
                        $this->questions = \models\Question::getQuestions(array('quiz_id' => $quiz[$k]->id));
                        $this->by_type_one = \models\Question::getQuestions(array('quiz_id' => $quiz[$k]->id, 'type' => \models\Question::QUESTION_TYPE_ONE));
                        $this->by_type_two = \models\Question::getQuestions(array('quiz_id' => $quiz[$k]->id, 'type' => \models\Question::QUESTION_TYPE_TWO));
                    }
                }
            }
            else {
                throw new \Exception('Quiz with ID [' . $id . '] not exist!');
            }
        }
    }

    public static function createQuizObjects($rows) {
        if (!empty($rows) && is_array($rows)) {
            foreach ($rows as $row) {
                $key = $row['id'];
                $quiz[$key] = new \models\Quiz();
                $quiz[$key]->id = $row['id'];
                $quiz[$key]->title = $row['title'];
                $quiz[$key]->questions = \models\Question::getQuestions(array('quiz_id' => $row['id']));
                $quiz[$key]->by_type_one = \models\Question::getQuestions(array('quiz_id' => $row['id'], 'type' => \models\Question::QUESTION_TYPE_ONE));
                $quiz[$key]->by_type_two = \models\Question::getQuestions(array('quiz_id' => $row['id'], 'type' => \models\Question::QUESTION_TYPE_TWO));
            }
            return !empty($quiz) ? $quiz : null;
        }
        return null;
    }

    /**
     * Get quiz from DB by given parameters
     * @param array $params for query of type $key => $value
     * @param string $quiz_id=> quiz id
     * @param bool $return_as_array
     * @return \models\Quiz | array
     */
    public static function getQuiz($params = array(), $return_as_array = false) {
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
                $where .= ' AND qz.id = :id ';
                $values['id'] = $params['id'];
            }
            if (isset($params['type'])) {
                $where .= ' AND qu.type = :type ';
                $values['type'] = $params['type'];
            }
            if (isset($params['is_correct'])) {
                $where .= ' AND a.is_correct = :is_correct ';
                $values['is_correct'] = $params['is_correct'];
            }

            if (isset($params['order'])) {
                $order = ' ORDER BY ' . $params['order'] . ' ';
            }
            if (isset($params['limit'])) {
                $limit = ' LIMIT ' . $params['limit'] . ' ';
            }
        }

        $query = '
                SELECT qz.*
                FROM quiz AS qz
                ' .
                $sql . $where . $order . $limit . '
            ';

        //echo $db->prepare($query, $values)->getSqlInterpolated();

        $db->prepare($query, $values)->execute();
        $rows = $db->fetchAllAssoc();
        //echo '<pre>'; print_r($rows); echo '</pre>';
        if (!$return_as_array) {
            $quizes = self::createQuizObjects($rows);
            return $quizes;
        }
        else {
            return $rows;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getQuestions() {
        return $this->questions;
    }

    public function getByTypeOne(){
        return $this->by_type_one;
    }

    public function getByTypeTwo(){
        return $this->by_type_two;
    }

}
