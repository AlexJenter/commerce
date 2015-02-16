<?php

namespace Craft;

/**
 * Class Market_VariantRecord
 *
 * @property int      id
 * @property int      productId
 * @property bool     isMaster
 * @property string   sku
 * @property float    price
 * @property float    width
 * @property float    height
 * @property float    length
 * @property float    weight
 * @property float    stock
 * @property DateTime deletedAt
 * @package Craft
 */
class Market_VariantRecord extends BaseRecord
{

	public function getTableName()
	{
		return 'market_variants';
	}

	public function defaultScope()
	{
		return array(
			'condition' => 'deletedAt IS NULL',
		);
	}

	public function defineIndexes()
	{
		return array(
			array('columns' => array('sku'), 'unique' => true),
		);
	}

	public function defineRelations()
	{
		return array(
			'product' => array(self::BELONGS_TO, 'Market_ProductRecord', 'onDelete' => self::SET_NULL, 'onUpdate' => self::CASCADE),
		);
	}

	protected function defineAttributes()
	{
		return array(
			'isMaster'  => array(AttributeType::Bool, 'default' => 0, 'required' => true),
			'sku'       => array(AttributeType::String, 'required' => true),
			'price'     => array(AttributeType::Number, 'decimals' => 4, 'required' => true),
			'width'     => array(AttributeType::Number, 'decimals' => 4),
			'height'    => array(AttributeType::Number, 'decimals' => 4),
			'length'    => array(AttributeType::Number, 'decimals' => 4),
			'weight'    => array(AttributeType::Number, 'decimals' => 4),
			'stock'     => array(AttributeType::Number),
			'deletedAt' => array(AttributeType::DateTime, 'default' => NULL)
		);
	}

}