<?php
abstract class Core_Plugin_Abstract {
    public function __call($method, array $args) {
        throw new Core_Plugin_Exception(sprintf('Invalid method: %s', $method));
    }
}