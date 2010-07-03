<?php
/**
 * ValidatoratorBehaviorTestCase class
 */

class FakeValidatoratorBehaviorModel extends CakeTestModel {
	var $name = 'ValidatoratorTestModel';
	var $useTable = false;
	var $_schema = array();
	var $validate = array(
		'name' => 'justAString',				// Single rule as string
		'name2' => array(						// Single rule as complex array
			'rule' => 'singleString',
			'message' => 'Must be alphanumeric',
		),
		'name3' => array(						// Single rule as complex array
			'rule' => array('singleArray', 2),
			'message' => 'Must be alphanumeric',
		),
		'name4' => array(						// Multiple array with string rule
			'someRule' => array(
				'rule' => 'multipleString',
				'message' => 'This name must be at leat 3 characters long',
			),
		),
		'name5' => array(						// Multiple array with array rule
			'anyRule' => array(
				'rule' => array('multipleArray', 'fast'),
				'message' => 'Invalid credit card number',
				'required' => true,
			),
		),
	);
}


class ValidatoratorBehaviorTestCase extends CakeTestCase {

	
	function startCase() {
		$this->model = new FakeValidatoratorBehaviorModel();
		$this->model->Behaviors->attach('ValidationPlus.Validatorator');
	}
	
	function endTest() {
	}
	
	function testCheckValidation() {
		// Test each type of validation
		$this->assertTrue($this->model->checkValidation('name', 'justAString'));
		$this->assertTrue($this->model->checkValidation('name2', 'singleString'));
		$this->assertTrue($this->model->checkValidation('name3', 'singleArray'));
		$this->assertTrue($this->model->checkValidation('name4', 'multipleString'));
		$this->assertTrue($this->model->checkValidation('name5', 'multipleArray'));
		
		// Confirm that return false does work
		$this->assertFalse($this->model->checkValidation('name', 'singleString'));
	}
	
	function testAddValidation() {
		$this->model->addValidation('name', array(
			'rule' => 'singleString',
			'message' => 'Must be alphanumeric',
		));
		$this->assertTrue($this->model->checkValidation('name', 'justAString'));
		$this->assertTrue($this->model->checkValidation('name', 'singleString'));
		
		$this->model->addValidation('name2', array(
			'rule' => array('singleArray', 2),
			'message' => 'Must be alphanumeric',
		));
		$this->assertTrue($this->model->checkValidation('name2', 'singleString'));
		$this->assertTrue($this->model->checkValidation('name2', 'singleArray'));
		
		$this->model->addValidation('name3', array(
			'someRule' => array(
				'rule' => 'multipleString',
				'message' => 'This name must be at leat 3 characters long',
			)
		));
		$this->assertTrue($this->model->checkValidation('name3', 'singleArray'));
		$this->assertTrue($this->model->checkValidation('name3', 'multipleString'));
				
		$this->model->addValidation('name4', array(
			'anyRule' => array(
				'rule' => array('multipleArray', 'fast'),
				'message' => 'Invalid credit card number',
				'required' => true,
			),
		));
		$this->assertTrue($this->model->checkValidation('name4', 'multipleString'));
		$this->assertTrue($this->model->checkValidation('name4', 'multipleArray'));
		
		$this->model->addValidation('name5', 'justAString');
		$this->assertTrue($this->model->checkValidation('name5', 'multipleArray'));
		$this->assertTrue($this->model->checkValidation('name5', 'justAString'));

		$this->model->addValidation('name6', 'justAString');
		$this->assertTrue($this->model->checkValidation('name6', 'justAString'));
	}
}