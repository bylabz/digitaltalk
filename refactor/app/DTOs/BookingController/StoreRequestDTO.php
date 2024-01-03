<?php

namespace App\DTOs\BookingController;
use App\DTOs\AbstractDTO;

class StoreRequestDTO extends AbstractDTO
{
    protected int $fromLanguageId;

    protected string $immediate;

    protected string $dueDate;

    protected string $dueTime;

    protected string $customerPhoneType;

    protected string $duration;

    protected string $customerPhysicalType;

    protected array $jobFor;

    protected string $byAdmin;

    public function __construct($validate)
    {
        $this->setFromLanguageId($validate['from_language_id']);
        $this->setImmediate($validate['immediate']);
        $this->setDueDate($validate['due_date']);
        $this->setDueTime($validate['due_time']);
        $this->setCustomerPhoneType($validate['customer_phone_type']);
        $this->setDuration($validate['duration']);
        $this->setCustomerPhysicalType($validate['customer_physical_type']);
        $this->setJobFor($validate['job_for']);
        $this->setByAdmin($validate['by_admin']);
    }

    /**
     * @return integer
     */
    public function getFromLanguageId(): int
    {
        return $this->fromLanguageId;
    }

    /**
     * @param integer $fromLanguageId
     * @return void
     */
    public function setFromLanguageId(int $fromLanguageId): void
    {
        $this->fromLanguageId = $fromLanguageId;
    }

    /**
     * @return string
     */
    public function getImmediate(): string
    {
        return $this->immediate;
    }

    /**
     * @param string $immediate
     * @return void
     */
    public function setImmediate(string $immediate): void
    {
        $this->immediate = $immediate;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @param string $dueDate
     * @return void
     */
    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getDueTime(): string
    {
        return $this->dueTime;
    }

    /**
     * @param string $dueTime
     * @return void
     */
    public function setDueTime(string $dueTime): void
    {
        $this->dueTime = $dueTime;
    }

    /**
     * @return string
     */
    public function getCustomerPhoneType(): string
    {
        return $this->customerPhoneType;
    }

    /**
     * @param string $customerPhoneType
     * @return void
     */
    public function setCustomerPhoneType(string $customerPhoneType): void
    {
        $this->customerPhoneType = $customerPhoneType;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     * @return void
     */
    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getCustomerPhysicalType(): string
    {
        return $this->customerPhysicalType;
    }

    /**
     * @param string $customerPhysicalType
     * @return void
     */
    public function setCustomerPhysicalType(string $customerPhysicalType): void
    {
        $this->customerPhysicalType = $customerPhysicalType;
    }

    /**
     * @return array
     */
    public function getJobFor(): array
    {
        return $this->jobFor;
    }

    /**
     * @param array $jobFor
     * @return void
     */
    public function setJobFor(array $jobFor): void
    {
        $this->jobFor = $jobFor;
    }

    /**
     * @return string
     */
    public function getByAdmin(): string
    {
        return $this->byAdmin;
    }

    /**
     * @param string $byAdmin
     * @return void
     */
    public function setByAdmin(string $byAdmin): void
    {
        $this->byAdmin = $byAdmin;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        if (in_array('male', $this->getJobFor())) {
            return 'male';
        }

        if (in_array('female', $this->getJobFor())) {
            return 'female';
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getCertified(): ?string
    {
        $certifieds = [
            'normal'   => ['normal'],
            'yes'      => ['certified'],
            'law'      => ['certified_in_law'],
            'health'   => ['certified_in_helth'],
            'both'     => ['normal', 'certified'],
            'n_law'    => ['normal', 'certified_in_law'],
            'n_health' => ['normal', 'certified_in_helth'],
        ];

        foreach ($certifieds as $key => $value) {
            if (in_array($this->jobFor, $value)) {
                return $key;
            }
        }

        return null;
    }
}