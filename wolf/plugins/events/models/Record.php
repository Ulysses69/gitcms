<?php

abstract class EventsRecord extends Record
{

	public static function nuller($data)
	{
		foreach ($data as $k => $d) {
			if ($d === '') {
				$data[$k] = null;
			} elseif (is_array($d)) {
				$data[$k] = self::nuller($d);
			}
		}
		return $data;
	}

	public function getColumns()
	{
		$columns = array_keys(get_object_vars($this));
		return array_diff($columns, array('_misc'));
	}

	public function setFromData($data)
	{
		foreach ($data as $key => $value) {
			if ($this->columnExists($key)) {
				$this->$key = $value;
			} else {
				$this->_misc[$key] = $value;
			}
		}
	}

	public static function findByNameFrom($class_name, $name)
	{
		return self::findOneFrom($class_name, 'name=?', array($name));
	}

	/**
	 * This is an overriden version of the Record.save() method to add support for NULL values.
	 *
	 * @return boolean
	 */
	public function save()
	{
		if ( ! $this->beforeSave()) return false;

		$value_of = array();

		if (empty($this->id)) {

			if ( ! $this->beforeInsert()) return false;

			$columns = $this->getColumns();


			// Escape and format for SQL insert query
			foreach ($columns as $column) {
				if ($this->columnExists($column)) {
					if (empty($this->$column)) {
						$value_of[$column] = 'NULL';
					} else {
						$value_of[$column] = self::$__CONN__->quote($this->$column);
					}
				}
			}

			$sql = 'INSERT INTO '.self::tableNameFromClassName(get_class($this)).' ('
				 . implode(', ', array_keys($value_of)).') VALUES ('.implode(', ', array_values($value_of)).')';
			$return = self::$__CONN__->exec($sql) !== false;
			$this->id = self::lastInsertId();

			if ( ! $this->afterInsert()) return false;

		} else {

			if ( ! $this->beforeUpdate()) return false;

			$columns = $this->getColumns();

			// Escape and format for SQL update query
			foreach ($columns as $column) {
				if ($this->columnExists($column)) {
					if (empty($this->$column)) {
						$value_of[$column] = $column.'=NULL';
					} else {
						$value_of[$column] = $column.'='.self::$__CONN__->quote($this->$column);
					}
				}
			}

			unset($value_of['id']);

			$sql = 'UPDATE '.self::tableNameFromClassName(get_class($this)).' SET '
				 . implode(', ', $value_of).' WHERE id = '.$this->id;
			$return = self::$__CONN__->exec($sql) !== false;

			if ( ! $this->afterUpdate()) return false;
		}

		self::logQuery($sql);

		// Run it !!...
		return $return;
	}

	private function columnExists($column)
	{
		$reflect = new ReflectionObject($this);
		$cols = $reflect->getProperties();
		foreach ($cols as $col) {
			if ($col->name == $column) {
				return true;
			}
		}
		return false;
	}

}
