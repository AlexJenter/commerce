<?php

namespace Craft;

class Market_SettingsModel extends BaseModel
{

	protected function defineAttributes()
	{
		return array(
			'secretKey'       => AttributeType::String,
			'publishableKey'  => AttributeType::String,
			'defaultCurrency' => AttributeType::String
		);
	}

	public function rules()
	{
		return array(
			array('secretKey', 'required'),
			array('publishableKey', 'required'),
			array('defaultCurrency', 'required')
		);
	}
} 