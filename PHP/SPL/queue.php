<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午2:30
 */

/*
 * The SplQueue class provides the main functionalities of a queue implemented using a doubly linked list.
 *
 * SplQueue extends SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
 * 方法
    __construct ( void )
    mixed dequeue ( void )
    void enqueue ( mixed $value )
    void setIteratorMode ( int $mode )
 * 继承的方法
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
    SplQueue::__construct — Constructs a new queue implemented using a doubly linked list
    SplQueue::dequeue — Dequeues a node from the queue
    SplQueue::enqueue — Adds an element to the queue.
    SplQueue::setIteratorMode — Sets the mode of iteration
 */

$queue = new SplQueue();
$queue->enqueue('a');
$queue->enqueue('b');
$queue->enqueue('c');
$queue->enqueue('d');
$queue->rewind();
while($queue->valid()){
    print_r($queue->current());
    $queue->next();
}