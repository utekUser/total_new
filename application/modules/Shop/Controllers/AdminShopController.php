<?php
class Shop_Controllers_AdminShopController extends Core_Controller_Action_Admin {
    protected $_path = array(
        'shop' => 'Магазин'
    );
    /**
     * Редиректор - определен для полноты кода
     *
     * @var Zend_Controller_Action_Helper_Redirector
     */
    protected $_redirector = null;
    
    protected $_form = array(
        'Shop_Form_Order',
        'Shop_Form_OrderCatalogStruct',
        'Shop_Form_OrderComposition',
        'Shop_Form_OrderManager',
        'Shop_Form_OrderPrices',
        'Shop_Form_OrderSale',
        'Shop_Form_OrderStatus',
        'Shop_Form_OrderStock',
        'Shop_Form_OrderTransaction',
        'Shop_Form_OrderGood',
        'Shop_Form_OrderOffer'
    ); 
    
    /**
     * Инициализация
     *
     */
    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');
    }
   
    /**
     * Главная, листинг
     *
     */
    public function indexAction() {
        $module = array(
			'catalog' => 'Загрузить каталог из файла',
			'settings' => 'Настройки магазина',            
            'manager' => 'Менеджеры',
            ''    => '',
            'order'    => 'Заказы', 
			'&nbsp;'    => '',
            'stock'    => 'Склады',
            'cataloggroup'    => 'Структура каталога',
			'&nbsp;&nbsp;'    => '',
            'maker'    => 'Производители',
            'goods'    => 'Товары',
            'offers'    => 'Предложения',
        );
        
        $this->view->module = $module;
    }
        
}