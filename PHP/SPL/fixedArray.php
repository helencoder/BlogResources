<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午2:48
 */
/*
 * The SplFixedArray class provides the main functionalities of array.
 * The main differences between a SplFixedArray and a normal PHP array is that the SplFixedArray is of fixed length and allows only integers within the range as indexes.
 * The advantage is that it allows a faster array implementation.
 *
 * SplFixedArray implements Iterator , ArrayAccess , Countable {
 * 方法
    public __construct ([ int $size = 0 ] )
    public int count ( void )
    public mixed current ( void )
    public static SplFixedArray fromArray ( array $array [, bool $save_indexes = true ] )
    public int getSize ( void )
    public int key ( void )
    public void next ( void )
    public bool offsetExists ( int $index )
    public mixed offsetGet ( int $index )
    public void offsetSet ( int $index , mixed $newval )
    public void offsetUnset ( int $index )
    public void rewind ( void )
    public int setSize ( int $size )
    public array toArray ( void )
    public bool valid ( void )
    public void __wakeup ( void )
    }
 *
 * Table of Contents
    SplFixedArray::__construct — Constructs a new fixed array
    SplFixedArray::count — Returns the size of the array
    SplFixedArray::current — Return current array entry
    SplFixedArray::fromArray — Import a PHP array in a SplFixedArray instance
    SplFixedArray::getSize — Gets the size of the array
    SplFixedArray::key — Return current array index
    SplFixedArray::next — Move to next entry
    SplFixedArray::offsetExists — Returns whether the requested index exists
    SplFixedArray::offsetGet — Returns the value at the specified index
    SplFixedArray::offsetSet — Sets a new value at a specified index
    SplFixedArray::offsetUnset — Unsets the value at the specified $index
    SplFixedArray::rewind — Rewind iterator back to the start
    SplFixedArray::setSize — Change the size of an array
    SplFixedArray::toArray — Returns a PHP array from the fixed array
    SplFixedArray::valid — Check whether the array contains more elements
    SplFixedArray::__wakeup — Reinitialises the array after being unserialised
 *
 */
// Initialize the array with a fixed length
$array = new SplFixedArray(5);

$array[1] = 2;
$array[4] = "foo";

var_dump($array[0]); // NULL
var_dump($array[1]); // int(2)

var_dump($array["4"]); // string(3) "foo"

// Increase the size of the array to 10
$array->setSize(10);

$array[9] = "asdf";

// Shrink the array to a size of 2
$array->setSize(2);

// The following lines throw a RuntimeException: Index invalid or out of range
try {
    var_dump($array["non-numeric"]);
} catch(RuntimeException $re) {
    echo "RuntimeException: ".$re->getMessage()."\n";
}

try {
    var_dump($array[-1]);
} catch(RuntimeException $re) {
    echo "RuntimeException: ".$re->getMessage()."\n";
}

try {
    var_dump($array[5]);
} catch(RuntimeException $re) {
    echo "RuntimeException: ".$re->getMessage()."\n";
}

/**
 * Result:
 *
    NULL
    int(2)
    string(3) "foo"
    RuntimeException: Index invalid or out of range
    RuntimeException: Index invalid or out of range
    RuntimeException: Index invalid or out of range
 *
 * */
