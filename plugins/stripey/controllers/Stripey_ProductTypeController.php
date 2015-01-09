<?php
namespace Craft;

class Stripey_ProductTypeController extends Stripey_BaseController
{
    protected $allowAnonymous = false;

    public function actionIndex()
    {
        $productTypes = craft()->stripey_productType->getAllProductTypes();
        $this->renderTemplate('stripey/settings/producttypes/index', compact('productTypes'));

    }

    public function actionEditProductType(array $variables = array())
    {
        $variables['brandNewProductType'] = false;

        if (!empty($variables['productTypeId'])) {

            $productTypeId = $variables['productTypeId'];

            $variables['productType'] = craft()->stripey_productType->getProductTypeById($productTypeId);

            if (!$variables['productType'])
            {
                throw new HttpException(404);
            }

            $variables['title'] = $variables['productType']->name;

        }else{
            if (empty($variables['productType'])){
                $variables['productType'] = new Stripey_ProductTypeModel();
                $variables['brandNewProductType'] = true;
            }

            $variables['title'] = Craft::t('Create a Product Type');

        };

        $this->renderTemplate('stripey/settings/producttypes/_edit', $variables);
    }

    public function actionSaveProductType()
    {
        $this->requirePostRequest();

        $productType = new Stripey_ProductTypeModel();

        // Shared attributes
        $productType->id         = craft()->request->getPost('productTypeId');
        $productType->name       = craft()->request->getPost('name');
        $productType->handle     = craft()->request->getPost('handle');

        // Set the field layout
        $fieldLayout = craft()->fields->assembleLayoutFromPost();
        $fieldLayout->type = 'Stripey_Product';
        $productType->setFieldLayout($fieldLayout);

        // Save it
        if (craft()->stripey_productType->saveProductType($productType))
        {
            craft()->userSession->setNotice(Craft::t('Product type saved.'));
            $this->redirectToPostedUrl($productType);
        }
        else
        {
            craft()->userSession->setError(Craft::t('Couldn’t save product type.'));
        }

        // Send the calendar back to the template
        craft()->urlManager->setRouteVariables(array(
            'productType' => $productType
        ));
    }



    public function actionDeleteProductType()
    {
        $this->requirePostRequest();
        $this->requireAjaxRequest();

        $productTypeId = craft()->request->getRequiredPost('id');

        craft()->stripey_productType->deleteProductTypeById($productTypeId);
        $this->returnJson(array('success' => true));
    }

} 