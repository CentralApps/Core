<?php
namespace CentralApps\Core;

interface DAOInterface {
	
	public function findByPrimaryKey($primary_key_value);
	public function insert();
	public function update();
	public function delete();
	
}
