<?php

namespace CRUD\AddCart\Consumer;

use Magento\Framework\Serialize\SerializerInterface;
use CRUD\AddCart\Model\AddcartFactory as CartModel;
use CRUD\AddCart\Model\ResourceModel\Addcart as CartResource;
use Magento\Framework\Exception\LocalizedException;
class Addcart
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var CartModel
     */
    protected $cart;

    /**
     * @var CartResource
     */
    protected $cartdata;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer,
        CartModel $cart,
        CartResource $cartdata
    ) {
        $this->serializer = $serializer;
        $this->cart = $cart;
        $this->cartdata = $cartdata;
    }

    /**
     * @param $data
     * @return void
     */
    public function consume($data)
    {
        $cart = $this->cart->create();
        $publisher = $this->serializer->unserialize($data);
        $cart->setData($publisher);
        try {
            $this->cartdata->save($cart);
        } 
         catch (LocalizedException $e) {
            throw LocalizedException(__('Error during add a cart'));
        }
    }
}
