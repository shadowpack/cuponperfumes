<?php
class clock{
	private $datetime;
	function clock($datetime){
		date_default_timezone_set('America/Santiago');
		$this->datetime = new DateTime($datetime);
	}
	function getMinutes(){
		$tiempo = $this->datetime->format("i");
		return intval($tiempo);
	}
	function getHours(){
		$tiempo = $this->datetime->format("h");
		return intval($tiempo);
	}
	function getSeconds(){
		$tiempo = $this->datetime->format("s");
		return intval($tiempo);
	}
	function getDays(){
		$tiempo = $this->datetime->format("d");
		return intval($tiempo);
	}
	function getMonth(){
		$tiempo = $this->datetime->format("m");
		return intval($tiempo);
	}
	function getyear(){
		$tiempo = $this->datetime->format("Y");
		return intval($tiempo);
	}
	function getEpoch(){
		$tiempo = mktime($this->getHours(),$this->getMinutes(),$this->getSeconds(),$this->getMonth(),$this->getDays(),2013);
		return $tiempo;
	}
	function getEpochDif($datetime){
		$tiempo = $this->getEpoch();
		return $tiempo-$datetime;
	}
	function getHoursDif($datetime){
		return floor($this->getEpochDif($datetime)/3600);
	}
	function getMinuteDif($datetime){
		return floor(($this->getEpochDif($datetime)%3600)/60);
	}
	function getSecondDif($datetime){
		return (($this->getEpochDif($datetime)%3600)%60);
	}
}
?>