<?php

class Table {
	
	public $table_name;

	function add($row) {
		$this->table[$row->field] = $row->getData();
	}
	
	function get() {
		return $this->table;
	}
}

class Row {
	
	private $row_t = array();
	private $temp = array();
	public $field ;
	
	function __construct($field) {
		$this->field = $field;
	}

	function addData($key, $value) {
		$this->temp[$key] = $value;
	}
	
	function setData() {
		$this->row_t[] = $this->temp;
	}
	
	function getData() {
		return $this->row_t;
	}
}

?>
