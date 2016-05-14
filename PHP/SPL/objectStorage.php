<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 下午2:52
 */
/**
 * The SplObjectStorage class provides a map from objects to data or, by ignoring data, an object set.
 * This dual purpose can be useful in many cases involving the need to uniquely identify objects.
 *
 * SplObjectStorage implements Countable , Iterator , Serializable , ArrayAccess {
 * 方法
    public void addAll ( SplObjectStorage $storage )
    public void attach ( object $object [, mixed $data = NULL ] )
    public bool contains ( object $object )
    public int count ( void )
    public object current ( void )
    public void detach ( object $object )
    public string getHash ( object $object )
    public mixed getInfo ( void )
    public int key ( void )
    public void next ( void )
    public bool offsetExists ( object $object )
    public mixed offsetGet ( object $object )
    public void offsetSet ( object $object [, mixed $data = NULL ] )
    public void offsetUnset ( object $object )
    public void removeAll ( SplObjectStorage $storage )
    public void removeAllExcept ( SplObjectStorage $storage )
    public void rewind ( void )
    public string serialize ( void )
    public void setInfo ( mixed $data )
    public void unserialize ( string $serialized )
    public bool valid ( void )
    }
 *
 * Table of Contents
    SplObjectStorage::addAll — Adds all objects from another storage
    SplObjectStorage::attach — Adds an object in the storage
    SplObjectStorage::contains — Checks if the storage contains a specific object
    SplObjectStorage::count — Returns the number of objects in the storage
    SplObjectStorage::current — Returns the current storage entry
    SplObjectStorage::detach — Removes an object from the storage
    SplObjectStorage::getHash — Calculate a unique identifier for the contained objects
    SplObjectStorage::getInfo — Returns the data associated with the current iterator entry
    SplObjectStorage::key — Returns the index at which the iterator currently is
    SplObjectStorage::next — Move to the next entry
    SplObjectStorage::offsetExists — Checks whether an object exists in the storage
    SplObjectStorage::offsetGet — Returns the data associated with an object
    SplObjectStorage::offsetSet — Associates data to an object in the storage
    SplObjectStorage::offsetUnset — Removes an object from the storage
    SplObjectStorage::removeAll — Removes objects contained in another storage from the current storage
    SplObjectStorage::removeAllExcept — Removes all objects except for those contained in another storage from the current storage
    SplObjectStorage::rewind — Rewind the iterator to the first storage element
    SplObjectStorage::serialize — Serializes the storage
    SplObjectStorage::setInfo — Sets the data associated with the current iterator entry
    SplObjectStorage::unserialize — Unserializes a storage from its string representation
    SplObjectStorage::valid — Returns if the current iterator entry is valid
 *
 * */

