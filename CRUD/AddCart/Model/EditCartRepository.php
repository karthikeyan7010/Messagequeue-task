<?php

namespace CRUD\AddCart\Model;

use CRUD\AddCart\Api\EditCartInterface;
use CRUD\AddCart\Api\DataInterfaceFactory;
use CRUD\AddCart\Model\AddcartFactory as CartModel;
use CRUD\AddCart\Model\ResourceModel\Addcart as CartResource;
use CRUD\AddCart\Model\ResourceModel\Addcart\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class EditCartRepository implements EditCartInterface
{
    /**
     * @var DataInterfaceFactory
     */

    private $dataInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CartModel
     */
    private $cartmodel;

    /**
     * @var CartResource
     */

    private $cartresource;

    public function __construct(
        CollectionFactory $collectionFactory,
        DataInterfaceFactory $dataInterfaceFactory,
        CartModel $cartmodel,
        CartResource $cartresource
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->dataInterfaceFactory = $dataInterfaceFactory;
        $this->cartmodel = $cartmodel;
        $this->cartresource = $cartresource;
    }

    /**
     * Editing a card item by id
     * @param int $id
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \CRUD\AddCart\Api\DataInterface[]
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function updateCart($id, string $sku = null, int $quoteId = null, int $customerId = null, $createdAt = null)
    {
        $cartmodel = $this->cartmodel->create();
        $this->resource->load($cartmodel, $id, 'id');
        if(!$cartmodel->getData()){
            return ['success' => 'ID is not Available'];
        }
        if ($sku != null) {
            $cartmodel->setSku($sku);
        }

        if ($quoteId != null) {
            $cartmodel->setQuoteId($quoteId);
        }

        if ($customerId != null) {
            $cartmodel->setCustomerId($customerId);
        }

        if ($createdAt != null) {
            $cartmodel->setCreatedAt($createdAt);
        }
        try {
            $this->resource->save($cartmodel);
            return ['success' => 'Updated Successfully'];
        } catch (LocalizedException $e) {
            throw LocalizedException(__('Error during Editing a cart ID'));
        }
    }
}
