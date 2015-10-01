<?php
interface DataBase{

	public function setPerPage();
	public function getRows();
	public function getRows($date,$from);
	public function getTotalPage();

}