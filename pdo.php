<?php
$pdo = new PDO('sqlite:database.db', null, null, [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);



die();
class Student
{
    private int $id;
    private string $name;


    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }



    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


}

class StudentRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getById(int $studentId): ?Student
    {
        $statement = $this->pdo->prepare('SELECT * FROM `students` WHERE `id` = ?');
        $statement->execute([$studentId]);
        return $statement->fetchObject(Student::class) ?: null;
    }

    public function getAll(): array
    {
        $result = [];
        $statement = $this->pdo->query('SELECT * FROM `students`');
        while ($statement && $student = $statement->fetchObject(Student::class)) {
            $result[] = $student;
        }
        return $result;
    }

    public function insert(Student $student): bool
    {
        $statement = $this->pdo->prepare('INSERT INTO `students` (`name`) VALUES (?)');
        return $statement->execute([$student->getName()]);
    }
}




$repository = new StudentRepository($pdo);
$student = $repository->getById(1);

print_r($student);
