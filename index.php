<?php

require_once 'vendor/autoload.php';

// Создание объекта
$customerId = 1;
$executorId = 2;
$task = new TaskForce\Task($customerId, $executorId);

// Активация и настройка проверки утверждений
// В php.ini заданы параметры:
// - zend.assertions = 1
// - assert.exception = off
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_CALLBACK, function ($file, $line, $assertion, $desc = null): void {
    echo "Неудачная проверка утверждения в $file:$line";
    if ($assertion) {
        echo ": $assertion";
    }
    if ($desc) {
        echo ": $desc";
    }
    echo "<br>\n";
});

// Выполнение проверок утверждений
assert($task->getActionMap() === [
    'cancel'  => 'Отменить',
    'respond' => 'Откликнуться',
    'done'    => 'Выполнено',
    'refuse'  => 'Отказаться',
]);
assert($task->getStatusMap() === [
    'new'      => 'Новое',
    'canceled' => 'Отменено',
    'in_work'  => 'В работе',
    'done'     => 'Выполнено',
    'fail'     => 'Провалено',
]);

assert($task->getNextStatus('cancel') === 'canceled', 'cancel action');
assert($task->getNextStatus('respond') === 'in_work', 'respond action');
assert($task->getNextStatus('done') === 'done', 'done action');
assert($task->getNextStatus('refuse') === 'fail', 'refuse action');
assert($task->getNextStatus('wrong') === null, 'wrong action');

assert($task->getAvaiableActions('new') === ['cancel', 'respond'], 'new status');
assert($task->getAvaiableActions('in_work') === ['done', 'refuse'], 'in_work status');
assert($task->getAvaiableActions('wrong') === [], 'wrong status');
