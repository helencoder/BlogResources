<?php # Script 7.5 - WorkUnit.php
// This page defines a WorkUnit class which uses the Composite pattern.
// This page also defines Team and Employee classes, which extend WorkUnit.

/* The WorkUnit class.
 * The class contains two attributes: $tasks and $name.
 * The class contains five methods: __construct(), getName(), add(), remove(), assignTask(), and completeTask().
 */
abstract class WorkUnit {
    
    // For storing work to be done:
    protected $tasks = array();

    // For storing the employee or team name:
    protected $name = NULL;
    
    // Constructor assigns the name:
    function __construct($name) {
        $this->name = $name;
    }
    
    // Method that returns the name:
    function getName() {
        return $this->name;
    }
    
    // Abstract functions to be implemented:
    abstract function add(Employee $e);
    abstract function remove(Employee $e);
    abstract function assignTask($task);
    abstract function completeTask($task);
    
} // End of WorkUnit class.

/* The Team class extends WorkUnit.
 * The class has one new attribute: $_employees.
 * The class has one new method: getCount().
 */
class Team extends WorkUnit {
    
    // For storing team members:
    private $_employees = array();
    
    // Implement the abstract methods...
    function add(Employee $e) {
        $this->_employees[] = $e;
        echo "<p>{$e->getName()} has been added to team {$this->getName()}.</p>";
    }
    function remove(Employee $e) {
        $index = array_search($e, $this->_employees);
        unset($this->_employees[$index]);
        echo "<p>{$e->getName()} has been removed from team {$this->getName()}.</p>";
    }
    function assignTask($task) {
        $this->tasks[] = $task;
        echo "<p>A new task has been assigned to team {$this->getName()}. It should be easy to do with {$this->getCount()} team member(s).</p>";
    }
     function completeTask($task) {
         $index = array_search($task, $this->tasks);
         unset($this->tasks[$index]);
         echo "<p>The '$task' task has been completed by team {$this->getName()}.</p>";
     }
    
    // Method for returning the number of team members:
    function getCount() {
        return count($this->_employees);
    }
    
} // End of Team class.

/* The Employee class extends WorkUnit.
 * The class has no new attributes or methods.
 */
class Employee extends WorkUnit {
    
    // Empty functions:
    function add(Employee $e) {
        return false;
    }
    function remove(Employee $e) {
        return false;
    }
        
    // Implement the abstract methods...
    function assignTask($task) {
        $this->tasks[] = $task;
        echo "<p>A new task has been assigned to {$this->getName()}. It will be done by {$this->getName()} alone.</p>";
    }
    function completeTask($task) {
        $index = array_search($task, $this->tasks);
        unset($this->tasks[$index]);
        echo "<p>The '$task' task has been completed by employee {$this->getName()}.</p>";
    }

} // End of Employee class.