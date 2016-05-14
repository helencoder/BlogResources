<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午2:23
 */

/**
 * The SplStack class provides the main functionalities of a stack implemented using a doubly linked list.
 *
 * SplStack extends SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
 * 方法
    __construct ( void )
    void setIteratorMode ( int $mode )
 *
    继承的方法
    public void SplDoublyLinkedList::add ( mixed $index , mixed $newval )
    public mixed SplDoublyLinkedList::bottom ( void )
    public int SplDoublyLinkedList::count ( void )
    public mixed SplDoublyLinkedList::current ( void )
    public int SplDoublyLinkedList::getIteratorMode ( void )
    public bool SplDoublyLinkedList::isEmpty ( void )
    public mixed SplDoublyLinkedList::key ( void )
    public void SplDoublyLinkedList::next ( void )
    public bool SplDoublyLinkedList::offsetExists ( mixed $index )
    public mixed SplDoublyLinkedList::offsetGet ( mixed $index )
    public void SplDoublyLinkedList::offsetSet ( mixed $index , mixed $newval )
    public void SplDoublyLinkedList::offsetUnset ( mixed $index )
    public mixed SplDoublyLinkedList::pop ( void )
    public void SplDoublyLinkedList::prev ( void )
    public void SplDoublyLinkedList::push ( mixed $value )
    public void SplDoublyLinkedList::rewind ( void )
    public string SplDoublyLinkedList::serialize ( void )
    public void SplDoublyLinkedList::setIteratorMode ( int $mode )
    public mixed SplDoublyLinkedList::shift ( void )
    public mixed SplDoublyLinkedList::top ( void )
    public void SplDoublyLinkedList::unserialize ( string $serialized )
    public void SplDoublyLinkedList::unshift ( mixed $value )
    public bool SplDoublyLinkedList::valid ( void )
    }
 *
 * Table of Contents
    SplStack::__construct — Constructs a new stack implemented using a doubly linked list
    SplStack::setIteratorMode — Sets the mode of iteration
 */

# Think of the stack as an array reversed, where the last element has index zero

$stack = new SplStack();
$stack->push('a');
$stack->push('b');
$stack->push('c');

$stack->offsetSet(0, 'C'); # the last element has index zero

$stack->rewind();

while( $stack->valid() )
{
    echo $stack->current(), PHP_EOL;
    $stack->next();
}
