<?php

namespace CRUD\AddCart\Model;

use CRUD\AddCart\Api\DeleteCartInterface;
use CRUD\AddCart\Api\DataInterfaceFactory;
use CRUD\AddCart\Model\AddcartFactory as CartModel;
use CRUD\AddCart\Model\ResourceModel\Addcart as CartResource;
use CRUD\AddCart\Model\ResourceModel\Addcart\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class DeleteCartRepository implements DeleteCartInterface
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
     * Deleting a cart item by id
     * 
     * @param int $id
     * @return \CRUD\AddCart\Api\DataInterface[]
     */
    public function deleteCartById(int $id)
    {
        $cartmodel = $this->cartmodel->create();
        $this->resource->load($cartmodel, $id, 'id');

        try {
            $this->resource->delete($cartmodel);
            $response = ['success' => 'Deleted Successfully'];
            return $response;
        }catch (LocalizedException $e) {
            throw LocalizedException(__('Error during deleted a cart ID'));
            
        }
    }
}
