<?php
namespace Craft;

/**
 * @author    Make with Morph. <support@makewithmorph.com>
 * @copyright Copyright (c) 2015, Luke Holder.
 * @license   http://makewithmorph.com/market/license Market License Agreement
 * @see       http://makewithmorph.com
 * @package   craft.plugins.market.controllers
 * @since     0.1
 */
class Market_AddressController extends Market_BaseController
{
	/**
	 * Edit Address
	 *
	 * @param array $variables
	 * @throws HttpException
	 */
	public function actionEdit(array $variables = [])
	{
		if (empty($variables['address'])) {
			if (empty($variables['id'])) {
				throw new HttpException(404);
			}

			$id = $variables['id'];
			$variables['address'] = craft()->market_address->getById($id);

			if (!$variables['address']->id) {
				throw new HttpException(404);
			}
		}

		$variables['title'] = Craft::t('Address #{id}', ['id' => $variables['id']]);

		$this->renderTemplate('market/addresses/_edit', $variables);
	}

	/**
	 * @throws HttpException
	 */
	public function actionSave()
	{
		$this->requirePostRequest();

		$id = craft()->request->getRequiredPost('id');
		$address = craft()->market_address->getById($id);

		if(!$address->id) {
			throw new HttpException(400);
		}

		// Shared attributes
		$address->email = craft()->request->getPost('email');

		// Save it
		if (craft()->market_address->save($address)) {
			craft()->userSession->setNotice(Craft::t('Address saved.'));
			$this->redirectToPostedUrl();
		} else {
			craft()->userSession->setError(Craft::t('Couldn’t save address.'));
		}

		// Send the model back to the template
		craft()->urlManager->setRouteVariables(['address' => $address]);
	}
}
