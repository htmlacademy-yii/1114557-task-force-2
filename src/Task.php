<?php

namespace TaskForce;

class Task
{
    const STATUS_NEW      = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK  = 'in_work';
    const STATUS_DONE     = 'done';
    const STATUS_FAIL     = 'fail';

    const ACTION_CANCEL  = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_DONE    = 'done';
    const ACTION_REFUSE  = 'refuse';

    private string $currentStatus;
    private int $customerId;
    private int $executorId;

    public function __construct(int $customerId, int $executorId)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;
        $this->currentStatus = static::STATUS_NEW;
    }

    public function getActionMap(): array
    {
        return [
            static::ACTION_CANCEL  => 'Отменить',
            static::ACTION_RESPOND => 'Откликнуться',
            static::ACTION_DONE    => 'Выполнено',
            static::ACTION_REFUSE  => 'Отказаться',
        ];
    }

    public function getStatusMap(): array
    {
        return [
            static::STATUS_NEW      => 'Новое',
            static::STATUS_CANCELED => 'Отменено',
            static::STATUS_IN_WORK  => 'В работе',
            static::STATUS_DONE     => 'Выполнено',
            static::STATUS_FAIL     => 'Провалено',
        ];
    }

    public function getNextStatus(string $action): ?string
    {
        $statusAfterAction = [
            static::ACTION_CANCEL  => static::STATUS_CANCELED,
            static::ACTION_RESPOND => static::STATUS_IN_WORK,
            static::ACTION_DONE    => static::STATUS_DONE,
            static::ACTION_REFUSE  => static::STATUS_FAIL,
        ];

        return $statusAfterAction[$action] ?? null;
    }

    public function getAvaiableActions(string $status): array
    {
        $statusActions = [
            static::STATUS_NEW => [
                static::ACTION_CANCEL,
                static::ACTION_RESPOND
            ],
            static::STATUS_IN_WORK => [
                static::ACTION_DONE,
                static::ACTION_REFUSE,
            ],
        ];

        return $statusActions[$status] ?? [];
    }
}
