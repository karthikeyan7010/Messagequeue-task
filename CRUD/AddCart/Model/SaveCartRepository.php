<?php

namespace CRUD\AddCart\Model;

use CRUD\AddCart\Api\SaveCartInterface;
use CRUD\AddCart\Api\DataInterfaceFactory;
use CRUD\AddCart\Model\AddcartFactory as CartModel;
use CRUD\AddCart\Model\ResourceModel\Addcart as CartResource;
use CRUD\AddCart\Model\ResourceModel\Addcart\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class SaveCartRepository implements SaveCartInterface
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
    private $cartmodelel;

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
     * saved a card item by id
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \CRUD\AddCart\Api\DataInterface[]
     */
    public function saveCart(string $sku, int $quoteId, int $customerId = null, $createdAt = null)
    {
        $cartmodel = $this->cartmodel->create();
        $cartmodel->setSku($sku);
        $cartmodel->setQuoteId($quoteId);
        $cartmodel->setCustomerId($customerId);

        if ($createdAt != null) {
            $cartmodel->setCreatedAt($createdAt);
        }
        try {
            $this->resource->save($cartmodel);
            $response = ['success' => 'Saved Successfully'];
            return $response;
        } catch (LocalizedException $e) {
            throw LocalizedException(__('Error during Saved all data'));
        }
    }
}
