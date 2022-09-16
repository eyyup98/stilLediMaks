<?php

class HumanDb extends Database
{
    /**
     * @var array|null
     */
    private ?array $id = [];
    /**
     * @var string|null
     */
    private ?string $firstname;
    /**
     * @var string|null
     */
    private ?string $lastname;
    /**
     * @var string|null
     */
    private ?string $birthday;
    /**
     * @var int|null
     */
    private ?int $sex;
    /**
     * @var string|null
     */
    private ?string $city;

    /**
     * HumanDb constructor.
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $birthday
     * @param int|null $sex
     * @param string|null $city
     */
    public function __construct(
        string $firstname = null,
        string $lastname = null,
        string $birthday = null,
        int $sex = null,
        string $city = null
    )
    {
        $this->connection();

        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->sex = $sex;
        $this->city = $city;

        if (isset($this->firstname, $this->lastname, $this->birthday, $this->sex, $this->city)) {
            if (!$this->validateDate($this->birthday)) {
                die('Фотмат даты рождения не верен! Формат должен быть в виде: \'Y-m-d\'.');
            }
            $this->saveHuman($this->firstname, $this->lastname, $this->birthday, $this->sex, $this->city);
        } elseif (isset($this->firstname)) {
            die('Необходимо задать все параметры для создания человека в БД!');
        } /*else {
            $result = $this->pdo->query("SELECT * FROM ledi.human; ");
            while ($row = $result->fetch()) {
                $this->id[] = $row['id'];
            }
        }*/
    }

    public function saveHuman(string $firstname, string $lastname, string $birthday, int $sex, string $city): void
    {
        $this->pdo->exec(
            "INSERT INTO ledi.human (firstname, lastname, birthday, sex, city)
                        VALUES ('$firstname', '$lastname', '$birthday', $sex, '$city'); "
        );
    }

    public function deleteHuman($id): void
    {
        $this->pdo->exec(
            "DELETE FROM ledi.human WHERE id = $id; "
        );
    }

    protected function validateDate(string $date, string $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function convertAge(string $date): ?int
    {
        try {
            $birthDay = new DateTime($date);
            $today = new DateTime('00:00:00');
            $diff = $today->diff($birthDay);
            return $diff->y;
        } catch (Exception $e) {
            die('Ошибка ввода даты. ' . $e->getMessage());
        }
    }

    public static function convertSex(int $sex): ?string
    {
        if ($sex === 0) {
            return 'жен';
        } elseif ($sex === 1) {
            return 'муж';
        } else {
            die('Не правильно введён параметр пола!');
        }
    }

    public function formatHuman(
    ): object {
        return (object) array(
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'age' => self::convertAge($this->birthday),
            'sex' => self::convertSex($this->sex),
            'city' => $this->city,
        );
    }
}