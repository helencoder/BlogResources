<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午2:35
 */
/**
 * The SplHeap class provides the main functionalities of a Heap.
 *
 * abstract SplHeap implements Iterator , Countable {
 * 方法
    public __construct ( void )
    abstract protected int compare ( mixed $value1 , mixed $value2 )
    public int count ( void )
    public mixed current ( void )
    public mixed extract ( void )
    public void insert ( mixed $value )
    public bool isEmpty ( void )
    public mixed key ( void )
    public void next ( void )
    public void recoverFromCorruption ( void )
    public void rewind ( void )
    public mixed top ( void )
    public bool valid ( void )
    }
 *
 * Table of Contents
    SplHeap::compare — Compare elements in order to place them correctly in the heap while sifting up.
    SplHeap::__construct — Constructs a new empty heap
    SplHeap::count — Counts the number of elements in the heap.
    SplHeap::current — Return current node pointed by the iterator
    SplHeap::extract — Extracts a node from top of the heap and sift up.
    SplHeap::insert — Inserts an element in the heap by sifting it up.
    SplHeap::isEmpty — Checks whether the heap is empty.
    SplHeap::key — Return current node index
    SplHeap::next — Move to the next node
    SplHeap::recoverFromCorruption — Recover from the corrupted state and allow further actions on the heap.
    SplHeap::rewind — Rewind iterator back to the start (no-op)
    SplHeap::top — Peeks at the node from the top of the heap
    SplHeap::valid — Check whether the heap contains more nodes
 */

/**
 * The SplMaxHeap class provides the main functionalities of a heap, keeping the maximum on the top.
 *
 * SplMaxHeap extends SplHeap implements Iterator , Countable {
 * 方法
    protected int compare ( mixed $value1 , mixed $value2 )
 * 继承的方法
    abstract protected int SplHeap::compare ( mixed $value1 , mixed $value2 )
    public int SplHeap::count ( void )
    public mixed SplHeap::current ( void )
    public mixed SplHeap::extract ( void )
    public void SplHeap::insert ( mixed $value )
    public bool SplHeap::isEmpty ( void )
    public mixed SplHeap::key ( void )
    public void SplHeap::next ( void )
    public void SplHeap::recoverFromCorruption ( void )
    public void SplHeap::rewind ( void )
    public mixed SplHeap::top ( void )
    public bool SplHeap::valid ( void )
    }
 *
 * Table of Contents
    SplMaxHeap::compare — Compare elements in order to place them correctly in the heap while sifting up.
 */

$heap = new SplMaxHeap();
$heap->insert(1);
$heap->insert(4);
$heap->insert(3);
$heap->insert(2);

/**
 * The SplMinHeap class provides the main functionalities of a heap, keeping the minimum on the top.
 *
 * SplMinHeap extends SplHeap implements Iterator , Countable {
 * 方法
    protected int compare ( mixed $value1 , mixed $value2 )
 * 继承的方法
    abstract protected int SplHeap::compare ( mixed $value1 , mixed $value2 )
    public int SplHeap::count ( void )
    public mixed SplHeap::current ( void )
    public mixed SplHeap::extract ( void )
    public void SplHeap::insert ( mixed $value )
    public bool SplHeap::isEmpty ( void )
    public mixed SplHeap::key ( void )
    public void SplHeap::next ( void )
    public void SplHeap::recoverFromCorruption ( void )
    public void SplHeap::rewind ( void )
    public mixed SplHeap::top ( void )
    public bool SplHeap::valid ( void )
    }
 *
 * Table of Contents
    SplMinHeap::compare — Compare elements in order to place them correctly in the heap while sifting up.
 */

