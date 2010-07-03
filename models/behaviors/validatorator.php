<?php
/**
 * Validatorator behavior class.
 * 
 * Adds a few handy methods for use with validation.
 */

class ValidatoratorBehavior extends ModelBehavior {

	function checkValidation(&$Model, $field, $rule) {
		if (isset($Model->validate[$field])) {
			$ruleSet = $Model->validate[$field];

			// Wrap in array if simple rule or single rule
			if (!is_array($ruleSet) || (is_array($ruleSet) && isset($ruleSet['rule']))) {
				$ruleSet = array($ruleSet);
			}
			foreach ($ruleSet as $index => $validator) {
				if (!is_array($validator)) {
					$validator = array('rule' => $validator);
				}
				
				if (!empty($validator['rule'])) {
					if (is_array($validator['rule']) && $validator['rule'][0] == $rule) {
						return true;
					} elseif ($validator['rule'] == $rule) {
						return true;
					}
				}
			}
		}
			
		return false;
	}
	
	function addValidation(&$Model, $field, $rules) {
		if (isset($Model->validate[$field])) {
			$ruleSet = $Model->validate[$field];
		
			// Wrap in array if simple rule or single rule
			if (!is_array($ruleSet))  {
				$ruleSet = array($ruleSet => array('rule' => $ruleSet));
			} elseif ((is_array($ruleSet) && isset($ruleSet['rule']))) {
				if (is_array($ruleSet['rule'])) {
					$ruleSet = array($ruleSet['rule'][0] => $ruleSet);
				} else {
					$ruleSet = array($ruleSet['rule'] => $ruleSet);
				}
			}
			if (!is_array($rules)) {
				$rules = array($rules => array('rule' => $rules));
			} elseif ((is_array($rules) && isset($rules['rule']))) {
				if (is_array($rules['rule'])) {
					$rules = array($rules['rule'][0] => $rules);
				} else {
					$rules = array($rules['rule'] => $rules);
				}
			}
			
			$Model->validate[$field] = array_merge($ruleSet, $rules);
		} else {
			$Model->validate[$field] = $rules;
		}
	}
	
}