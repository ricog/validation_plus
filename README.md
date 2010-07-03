# Validation Plus Behavior Plugin

This behavior adds extra funtionality to your models for working with validation. Currently it can check and add validation rules.


## Installation

### Using Git

You can clone it from github into your plugin directory (git clone git://github.com/ricog/validation_plus.git)

You can add it as a git submodule (git submodule add git://github.com/ricog/validation_plus.git plugins/validation_plus)

### Downloading the files
You can download the archive from github.com and extract it into plugins/validation_plus


## Setup

### Using $actsAs

Add the behavior to your $actsAs array like this:

	<?php
	class Article extends AppModel {
		var $name = 'Article';
		var $actsAs = array('ValidationPlus.Validatorator');
	}
	?>

### On-the-fly
Or set it up on-the-fly from within a controller (or anywhere):

	$this->Article->Behaviors->attach('ValidationPlus.Validatorator');
	

## Usage

### Checking existing validation rules

The checkValidation() method will check to see if a validation rule exists for a given field. It does not matter what format the rule is setup with (simple, one rule per field, or multiple rules per field).

	$RuleIsSet = $Model->checkValidation('field_name', 'cc');

The method will return true if the rule exists, or false if the rule does not exist.

### Adding new validation rules

New validation rules can be added on the fly without needing to worry about the current format of the $validate array in the model. The addValidation() method will process the $validate array and add the new rule.

Adding a simple rule:

	$Model->addValidation('field_name', 'someSimpleRule');

Adding a new single rule:

	$newRule = array(
		'rule' => 'numeric',
		'message' => 'Invalid amount.',
		'required' => false,
		'allowEmpty' => true
	);

	$Model->addValidation('field_name', $newRule);


Adding an array of one or more rules:

	$newRule = array(
		'numeric' => array(
			'rule' => 'numeric',
			'message' => 'Invalid amount.',
			'required' => false,
			'allowEmpty' => true
		)
	);

	$Model->addValidation('field_name', $newRule);

	
The new rule can be formatted as a simple rule, or a one rule array. See http://book.cakephp.org/view/1145/One-Rule-Per-Field for more details.

_It is important to note that new rules with matching names will overwrite the original of the same name. So, in the second or third examples above, if there was already a 'numeric' rule, it would be overwritten. Any other existing rules would remain._


 