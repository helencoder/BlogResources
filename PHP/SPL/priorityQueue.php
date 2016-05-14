<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午2:44
 */
/**
 * The SplPriorityQueue class provides the main functionalities of a prioritized queue, implemented using a max heap.
 *
 * SplPriorityQueue implements Iterator , Countable {
 * 方法
    public __construct ( void )
    public int compare ( mixed $priority1 , mixed $priority2 )
    public int count ( void )
    public mixed current ( void )
    public mixed extract ( void )
    public void insert ( mixed $value , mixed $priority )
    public bool isEmpty ( void )
    public mixed key ( void )
    public void next ( void )
    public void recoverFromCorruption ( void )
    public void rewind ( void )
    public void setExtractFlags ( int $flags )
    public mixed top ( void )
    public bool valid ( void )
    }
 *
 * Table of Contents
    SplPriorityQueue::compare — Compare priorities in order to place elements correctly in the heap while sifting up.
    SplPriorityQueue::__construct — Constructs a new empty queue
    SplPriorityQueue::count — Counts the number of elements in the queue.
    SplPriorityQueue::current — Return current node pointed by the iterator
    SplPriorityQueue::extract — Extracts a node from top of the heap and sift up.
    SplPriorityQueue::insert — Inserts an element in the queue by sifting it up.
    SplPriorityQueue::isEmpty — Checks whether the queue is empty.
    SplPriorityQueue::key — Return current node index
    SplPriorityQueue::next — Move to the next node
    SplPriorityQueue::recoverFromCorruption — Recover from the corrupted state and allow further actions on the queue.
    SplPriorityQueue::rewind — Rewind iterator back to the start (no-op)
    SplPriorityQueue::setExtractFlags — Sets the mode of extraction
    SplPriorityQueue::top — Peeks at the node from the top of the queue
    SplPriorityQueue::valid — Check whether the queue contains more nodes
 */

$q = new SplPriorityQueue();

$q->insert('foo',0);
$q->insert('bar',0);
$q->insert('baz',0);

var_dump($q->extract());
var_dump($q->extract());
var_dump($q->extract());