<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午12:41
 */

/**
 * The SplDoublyLinkedList class provides the main functionalities of a doubly linked list.
 * SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
 * 方法：
    public __construct ( void )
    public void add ( mixed $index , mixed $newval )
    public mixed bottom ( void )
    public int count ( void )
    public mixed current ( void )
    public int getIteratorMode ( void )
    public bool isEmpty ( void )
    public mixed key ( void )
    public void next ( void )
    public bool offsetExists ( mixed $index )
    public mixed offsetGet ( mixed $index )
    public void offsetSet ( mixed $index , mixed $newval )
    public void offsetUnset ( mixed $index )
    public mixed pop ( void )
    public void prev ( void )
    public void push ( mixed $value )
    public void rewind ( void )
    public string serialize ( void )
    public void setIteratorMode ( int $mode )
    public mixed shift ( void )
    public mixed top ( void )
    public void unserialize ( string $serialized )
    public void unshift ( mixed $value )
    public bool valid ( void )
 }
 *
 * Table of Contents
    SplDoublyLinkedList::add — Add/insert a new value at the specified index
    SplDoublyLinkedList::bottom — Peeks at the node from the beginning of the doubly linked list
    SplDoublyLinkedList::__construct — Constructs a new doubly linked list
    SplDoublyLinkedList::count — Counts the number of elements in the doubly linked list.
    SplDoublyLinkedList::current — Return current array entry
    SplDoublyLinkedList::getIteratorMode — Returns the mode of iteration
    SplDoublyLinkedList::isEmpty — Checks whether the doubly linked list is empty.
    SplDoublyLinkedList::key — Return current node index
    SplDoublyLinkedList::next — Move to next entry
    SplDoublyLinkedList::offsetExists — Returns whether the requested $index exists
    SplDoublyLinkedList::offsetGet — Returns the value at the specified $index
    SplDoublyLinkedList::offsetSet — Sets the value at the specified $index to $newval
    SplDoublyLinkedList::offsetUnset — Unsets the value at the specified $index
    SplDoublyLinkedList::pop — Pops a node from the end of the doubly linked list
    SplDoublyLinkedList::prev — Move to previous entry
    SplDoublyLinkedList::push — Pushes an element at the end of the doubly linked list
    SplDoublyLinkedList::rewind — Rewind iterator back to the start
    SplDoublyLinkedList::serialize — Serializes the storage
    SplDoublyLinkedList::setIteratorMode — Sets the mode of iteration
    SplDoublyLinkedList::shift — Shifts a node from the beginning of the doubly linked list
    SplDoublyLinkedList::top — Peeks at the node from the end of the doubly linked list
    SplDoublyLinkedList::unserialize — Unserializes the storage
    SplDoublyLinkedList::unshift — Prepends the doubly linked list with an element
    SplDoublyLinkedList::valid — Check whether the doubly linked list contains more nodes
 */

//FIFO and LIFO in SplDoublyLinkedList

$list = new SplDoublyLinkedList();
$list->push('a');
$list->push('b');
$list->push('c');
$list->push('d');

echo "FIFO (First In First Out) :<br>";
$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
for ($list->rewind(); $list->valid(); $list->next()) {
    echo $list->current()."<br>";
}

//Result :

// FIFO (First In First Out):
// a
// b
// c
// d

echo "LIFO (Last In First Out) :<br>";
$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
for ($list->rewind(); $list->valid(); $list->next()) {
    echo $list->current()."<br>";
}

//Result :

// LIFO (Last In First Out):
// d
// c
// b
// a


/*
php doubly link list is an amazing data structure ,doubly means you can traverse forward as well as backward, it can act as a deque(double ended queue) if you want it to,
here is how it works

*/

//instantiating an object of doubly link list

$dlist=new SplDoublyLinkedList();

//a push inserts data at the end of the list
$dlist->push('hiramariam');
$dlist->push('maaz');
$dlist->push('zafar');

/* the list contains
hiramariam
maaz
zafar
*/

//while an unshift inserts an object at top of the list
$dlist->unshift(1);
$dlist->unshift(2);
$dlist->unshift(3);

/* the list now contains
3
2
1
hiramariam
maaz
zafar
*/

//you can delete an item from the bottom of the list by using pop
$dlist->pop();

/* the list now contains
3
2
1
hiramariam
maaz

*/
//you can delete an item from the top of the list by using shift()
$dlist->shift();

/* the list now contains

2
1
hiramariam
maaz

*/

/* if you want to replace an item at particular index you can use a method named add , note that if you want to replace an item that does not exist , an exception will be thrown*/

$dlist->add(3 , 2.24);

/*
to go through the list we use a simple for loop, the rewind() method shown below point to the initials of the list depending on the iterator, a valid() method checks whether a list is still valid or not , meaning it ensures the loop does not go on and on after we reach the last data in the list , and the next() method simply points to the next data in the list.

*/
for($dlist->rewind();$dlist->valid();$dlist->next()){

    echo $dlist->current()."<br/>";
}
echo "<br/>";
/*

To traverse backward

*/
$dlist->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
for($dlist->rewind();$dlist->valid();$dlist->next()){

    echo $dlist->current()."<br/>";;
}
