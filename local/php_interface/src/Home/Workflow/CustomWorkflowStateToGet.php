<?php
namespace Home\Workflow;
use Bitrix\Bizproc\Api\Data\WorkflowStateService\WorkflowStateToGet;

class CustomWorkflowStateToGet extends WorkflowStateToGet
{
	protected array $order = ['MODIFIED' => 'DESC'];

	public function setOrder(array $order): self
	{
		$this->order = $order;
		return $this;
	}

	public function getOrder(): array
	{
		return $this->order;
	}
}