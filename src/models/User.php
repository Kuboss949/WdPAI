<?php



class User implements JsonSerializable
{

    private int $id;
    private string $login;
    private string $email;
    private string $password;
    private string $salt;
    private int $level;
    private string $exp;
    private int $height;
    private float $weight;
    private float $weightLoss;
    private string $activity;
    private string $role;
    private string $image;

    /**
     * @param string $login
     * @param string $email
     * @param string $password
     * @param int $height
     * @param float $weight
     * @param float $weightLoss
     * @param ActivityEnum $activity
     */
    public function __construct(
        int $id,
        string $login,
        string $email,
        string $password,
        string $salt,
        int $level = 1,
        int $exp = 0,
        string $image = "knight",
        string $role = "user",
        int $height = 0,
        float $weight = 0.0,
        float $weightLoss = 0.0,
        string $activity = "zero"
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->level = $level;
        $this->height = $height;
        $this->weight = $weight;
        $this->weightLoss = $weightLoss;
        $this->activity = $activity;
        $this->role = $role;
        $this->image = $image;
        $this->exp = $exp;
    }
    public function getExp(): string
    {
        return $this->exp;
    }
    public function setExp(string $exp): void
    {
        $this->exp = $exp;
    }


    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function getWeightLoss(): float
    {
        return $this->weightLoss;
    }

    public function setWeightLoss(float $weightLoss): void
    {
        $this->weightLoss = $weightLoss;
    }

    public function getActivity(): int
    {
        return $this->activity;
    }

    public function setActivity(ActivityEnum $activity): void
    {
        $this->activity = $activity;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'password' => $this->password,
            'salt' => $this->salt,
            'level' => $this->level,
            'exp' => $this->exp,
            'height' => $this->height,
            'weight' => $this->weight,
            'weightLoss' => $this->weightLoss,
            'activity' => $this->activity,
            'role' => $this->role,
            'image' => $this->image,
        ];
    }
}