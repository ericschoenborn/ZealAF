<?php
class ScheduleData{
	public $id;
	public $event;
	public $scheduleType;
	public $startDate;
	public $endDate;
	public $startTime;
	public $duration;
	public $location;
	public $space;
	public $leaders;
	public $participants;

	function setFromArray($values){
		foreach($values as $key => $value){
			if(property_exists($this, $key)){
				$this->{$key} = $value;
			}
		}
	}
}
?>
