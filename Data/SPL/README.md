# Standard PHP Library (SPL)
============================
The Standard PHP Library (SPL) is a collection of interfaces and classes that are meant to solve common problems.

No external libraries are needed to build this extension and it is available and compiled by default in PHP 5.0.0.

SPL provides a set of standard datastructure, a set of iterators to traverse over objects, a set of interfaces, a set of standard Exceptions, a number of classes to work with files and it provides a set of functions like spl_autoload_register()

目录结构
-------------------
    Predefined Constants    预定义常量
    Datastructures          数据结构


### Predefined Constants
The constants below are defined by this extension, and will only be available when the extension has either been compiled into PHP or dynamically loaded at runtime.

link：http://php.net/manual/en/reserved.constants.php

### Datastructures
SPL provides a set of standard datastructures. They are grouped here by their underlying implementation which usually defines their general field of application.

        SplDoublyLinkedList     双向链表
        SplStack                堆
        SplQueue                阵列
        SplHeap
        SplMaxHeap
        SplMinHeap
        SplPriorityQueue
        SplFixedArray
        SplObjectStorage        映射


### Iterators
SPL provides a set of iterators to traverse over objects.

        AppendIterator
        ArrayIterator
        CachingIterator
        CallbackFilterIterator
        DirectoryIterator
        EmptyIterator
        FilesystemIterator
        FilterIterator
        GlobIterator
        InfiniteIterator
        IteratorIterator
        LimitIterator
        MultipleIterator
        NoRewindIterator
        ParentIterator
        RecursiveArrayIterator
        RecursiveCachingIterator
        RecursiveCallbackFilterIterator
        RecursiveDirectoryIterator
        RecursiveFilterIterator
        RecursiveIteratorIterator
        RecursiveRegexIterator
        RecursiveTreeIterator
        RegexIterator


### Interfaces
SPL provides a set of interfaces.

        Countable
        OuterIterator
        RecursiveIterator
        SeekableIterator

        Countable
        OuterIterator
        RecursiveIterator
        SeekableIterator
        SplObserver
        SplSubject


### Exceptions
SPL provides a set of standard Exceptions.

    BadFunctionCallException
            BadMethodCallException
            DomainException
            InvalidArgumentException
            LengthException
            LogicException
            OutOfBoundsException
            OutOfRangeException
            OverflowException
            RangeException
            RuntimeException
            UnderflowException
            UnexpectedValueException


    LogicException (extends Exception)
        BadFunctionCallException
            BadMethodCallException
        DomainException
        InvalidArgumentException
        LengthException
        OutOfRangeException
    RuntimeException (extends Exception)
        OutOfBoundsException
        OverflowException
        RangeException
        UnderflowException
        UnexpectedValueException

### SPL Functions

    class_implements — Return the interfaces which are implemented by the given class or interface
    class_parents — Return the parent classes of the given class
    class_uses — Return the traits used by the given class
    iterator_apply — Call a function for every element in an iterator
    iterator_count — Count the elements in an iterator
    iterator_to_array — Copy the iterator into an array
    spl_autoload_call — Try all registered __autoload() function to load the requested class
    spl_autoload_extensions — Register and return default file extensions for spl_autoload
    spl_autoload_functions — Return all registered __autoload() functions
    spl_autoload_register — Register given function as __autoload() implementation
    spl_autoload_unregister — Unregister given function as __autoload() implementation
    spl_autoload — Default implementation for __autoload()
    spl_classes — Return available SPL classes
    spl_object_hash — Return hash id for given object

### File Handling

    SplFileInfo
    SplFileObject
    SplTempFileObject

### Miscellaneous Classes and Interfaces
Classes and interfaces which do not fit into the other SPL categories.
    ArrayObject
    SplObserver
    SplSubject


