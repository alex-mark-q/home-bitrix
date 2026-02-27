# Кастомизация сортировки в компоненте bizproc.user.processes

### 1. Задача
В стандартном компоненте Битрикс `bizproc.user.processes` необходимо было реализовать рабочую сортировку в гриде(для примера) по следующим полям:
* **ID** (Идентификатор процесса)
* **Дата старта** (Время начала выполнения)

### 2. Реализация
Был переопределен стандартный компонент `bizproc.user.processes` (компонент скопирован в папку local). Для решения задачи был изменен механизм подготовки данных в методе `fetchWorkflows` класса BizprocUserProcesses. 

#### Добавление метода setOrder
Был создан вспомогательный класс `CustomWorkflowStateToGet`. Он расширяет базовый функционал и добавляет метод для установки порядка строк:

```php
class CustomWorkflowStateToGet extends \Bitrix\Bizproc\Api\Data\WorkflowStateService\WorkflowStateToGet 
{
    public function setOrder(array $order): self 
    {
        $this->order = $order;
        return $this;
    }
}
```
### 3. Изменения в fetchWorkflows
В методе получения данных теперь используется созданный класс, в который передаются текущие настройки сортировки из таблицы (Грида):
```
private function fetchWorkflows(int $limit, int $offset, bool $shouldCountTotal = true): GetListResponse
{
    $workflowStateService = new WorkflowStateService();

    // Используем кастомный класс с методом setOrder
    $workflowsRequest = (new CustomWorkflowStateToGet())
        ->setAdditionalSelectFields(static::WORKFLOW_FIELDS_TO_LOAD)
        ->setOrder($this->getGridOrder()) 
        ->setLimit($limit)
        ->setOffset($offset);

    $this->setFilterToRequest($workflowsRequest);

    return $workflowStateService->getList($workflowsRequest);
}
```

###  4. Соответствие полей (Маппинг)
Для корректной работы сортировки на уровне базы данных, идентификаторы колонок из интерфейса (Грида) преобразуются в соответствующие поля системных таблиц:

Поле в Гриде	    Поле в базе данных	    Описание
ID	                WORKFLOW_ID	            Технический ID процесса в таблице связей
WORKFLOW_STARTED	MODIFIED	            Дата изменения (используется для стабильной сортировки по времени)