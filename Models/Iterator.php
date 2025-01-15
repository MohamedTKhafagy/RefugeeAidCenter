<?php
interface iIterator {
    public function hasNext(): bool;
    public function next();
    public function remove();
}
?>