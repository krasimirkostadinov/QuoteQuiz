<?php

namespace models;

/**
 * Contain all the data needed for Answer
 * For more flexibility see getters
 * @author Krasimir
 */
class Answer {

    private $id;
    private $question_id = 0;
    private $title = '';
    private $author = '';
    private $is_correct = 0;
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
                SELECT a.*
                FROM answers AS a
                WHERE a.id = :id
            ';
            $params = array('id' => $this->id);

            $num_rows = self::$db->prepare($sql, $params)->execute()->getAffectedRows();
            if ($num_rows === 1) {
                $rows = self::$db->fetchAllAssoc();
                $answer = self::createAnswersObjects($rows);
                if (count($answer) === 1) {
                    $k = key($answer);
                    if ($answer[$k] instanceof \models\Answer) {
                        $this->id = $answer[$k]->id;
                        $this->question_id = $answer[$k]->question_id;
                        $this->title = $answer[$k]->title;
                        $this->author = $answer[$k]->author;
                        $this->is_correct = $answer[$k]->is_correct;
                    }
                }
            }
            else {
                throw new \Exception('Answer with ID [' . $id . '] not exist!');
            }
        }
    }

    public static function createAnswersObjects($rows) {
        if (!empty($rows) && is_array($rows)) {
            foreach ($rows as $row) {
                $key = $row['id'];
                $answer[$key] = new \models\Answer();
                $answer[$key]->id = $row['id'];
                $answer[$key]->question_id = $row['question_id'];
                $answer[$key]->title = $row['title'];
                $answer[$key]->author = $row['author'];
                $answer[$key]->is_correct = $row['is_correct'];
            }
            return !empty($answer) ? $answer : null;
        }
        return null;
    }

    /**
     * Get answers from DB by given parameters
     * @param array $params for query of type $key => $value
     * @param bool $return_as_array
     * @return \models\Answer | array
     */
    public static function getAnswers($params = array(), $return_as_array = false) {
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
                $where .= ' AND a.id = :id ';
                $values['id'] = $params['id'];
            }
            if (isset($params['question_id'])) {
                $where .= ' AND a.question_id = :question_id ';
                $values['question_id'] = $params['question_id'];
            }
            if (isset($params['is_correct'])) {
                $where .= ' AND a.is_correct = :is_correct ';
                $values['is_correct'] = $params['is_correct'];
            }

            if (isset($params['order'])) {
                $where .= ' AND qu.order = :order ';
                $values['order'] = $params['order'];
            }
            if (isset($params['order'])) {
                $order = ' ORDER BY ' . $params['order'] . ' ';
            }
            if (isset($params['limit'])) {
                $limit = ' LIMIT ' . $params['limit'] . ' ';
            }
        }

        $query = 'SELECT a.*
                FROM answers AS a
                ' .
                $sql . $where . $order . $limit . '
            ';

        //echo $db->prepare($query, $values)->getSqlInterpolated();

        $db->prepare($query, $values)->execute();
        $rows = $db->fetchAllAssoc();
        if (!$return_as_array) {
            $answers = self::createAnswersObjects($rows);
            return $answers;
        }
        else {
            return $rows;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getQuestion_id() {
        return $this->question_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getIsCorrect() {
        return (int)$this->is_correct;
    }

    public function getAuthor(){
        return $this->author;
    }
}
