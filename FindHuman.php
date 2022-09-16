<?php


class FindHuman extends Database
{
    /**
     * @var array|null
     */
    private ?array $id = [];

    /**
     * @var array|null
     */
    private ?array $params = [];

    /**
     * @var string|null
     */
    private ?string $operator;

    public function __construct(array $params, string $operator = null)
    {
        $this->connection();

        if (!class_exists('HumanDb')) {
            die('Первый класс не существует!');
        }

        $sql = "SELECT * FROM ledi.human WHERE ";
        $where = '';
        foreach ($params as $key => $param) {
            switch ($key) {
                case 'lastname':
                case 'birthday':
                    if (($operator == '>' || $operator == '<' || $operator == '!=')) {
                        $where .= "AND $key $operator '$param' ";
                        break;
                    } elseif (isset($operator)) {
                        die('Некорректный оператор!');
                    }
                case 'sex':
                case 'city':
                case 'firstname':
                    $where .= "AND $key = '$param' ";
                    break;
            }
        }

        if ($where === '') {
            die('Массив пуст или не корректные данные!');
        }

        $sql .= substr_replace($where, '', 0, 4);
        $result = $this->pdo->query($sql);
        while ($row = $result->fetch()) {
            $this->id[] = $row['id'];
        }
    }

}