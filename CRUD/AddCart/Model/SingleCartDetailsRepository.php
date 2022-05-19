<?php

namespace CRUD\AddCart\Model;

use CRUD\AddCart\Api\SingleCartDetailsInterface;
use CRUD\AddCart\Api\DataInterfaceFactory;
use CRUD\AddCart\Model\AddcartFactory as CartModel;
use CRUD\AddCart\Model\ResourceModel\Addcart as CartResource;
use CRUD\AddCart\Model\ResourceModel\Addcart\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class SingleCartDetailsRepository implements SingleCartDetailsInterface
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
     * Showing a single product using id
     * @param int $id
     * @return \CRUD\AddCart\Api\DataInterface[]
     */
    public function getCartById(int $id)
    {
        $cartmodel = $this->cartmodel->create();
        $this->resource->load($cartmodel, $id, 'id');
        $cartmodel->getData();

        $dataInterface = $this->dataInterfaceFactory->create();
        $dataInterface->setId($cartmodel->getId());
        $dataInterface->setSku($cartmodel->getSku());
        $dataInterface->setCustomerId($cartmodel->getCustomerId());
        $dataInterface->setQuoteId($cartmodel->getQuoteId());
        $dataInterface->setCreatedAt($cartmodel->getCreatedAt());
        $data[] = $dataInterface;
        return $data;
    }
}