<?php

class Reward
{
    private int $requiredLevel;
    private string $rewardType;
    private string $content;

    /**
     * @param int $requiredLevel
     * @param string $rewardType
     * @param string $content
     */
    public function __construct(int $requiredLevel, string $rewardType, string $content)
    {
        $this->requiredLevel = $requiredLevel;
        $this->rewardType = $rewardType;
        $this->content = $content;
    }

    public function getRequiredLevel(): int
    {
        return $this->requiredLevel;
    }

    public function setRequiredLevel(int $requiredLevel): void
    {
        $this->requiredLevel = $requiredLevel;
    }

    public function getRewardType(): string
    {
        return $this->rewardType;
    }

    public function setRewardType(string $rewardType): void
    {
        $this->rewardType = $rewardType;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }


}