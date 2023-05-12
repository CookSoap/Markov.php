<?php

class Markov {
    private $states = []; // This is an array that will hold all of our states
    private $possibilities = [];  // This is an object which will contain a list of each possible outcome
    private $order = 3; // This variable holds the order
    private $start = []; // This array will keep track of all the possible ways to start a sentence

    public function __construct() {
        echo "Everything works! ...or not \n";
    }

    // Add a single state or states
    public function addStates($state) {
      if (is_array($state)) {
        $this->states = $state;
      } else {
        $this->states[] = $state;
      }
    }

    // Clear the Markov Chain completely
    public function clearChain() {
      $this->states = [];
      $this->start = [];
    
      $this->possibilities = [];
      $this->order = 3;
    }

    // Clear the states
    public function clearState() {
      $this->states = [];
      $this->start = [];
    }

    // Clear the possibilities
    public function clearPossibilities() {
      $this->possibilities = [];
    }

    // Get the states
    public function getStates() {
      return $this->states;
    }

    // Set the order
    public function setOrder($order = 3) { 
      if (gettype($order) !== 'integer') {
        print_r('Markov.setOrder: Order is not a number. Defaulting to 3.');
        $order = 3;
      }

      if ($order <= 0) {
        print_r('Markov.setOrder: Order is not a positive number. Defaulting to 3.');
        $order = 3;
      } 

      $this->order = $order;
    }

    // Get the order
    public function getOrder() {
      return $this->order;
    }

    // Get the whole list of possibilities or a single possibility
    public function getPossibilities($possibility = 'allPossibilities') {
      if($possibility == 'allPossibilities') {
        return $this->possibilities;
      }

      if (isset($this->possibilities[$possibility])) { 
        return $this->possibilities[$possibility];
      } else {
        throw new Exception("There is no such possibility called $possibility");
      }
    }

    // Train the markov chain 
    public function train($order = 3) {
      $this->clearPossibilities();

      if ($order !== 3) {
        $this->order = $order;
      }

      for ($i = 0; $i < count($this->states); $i++) {
      
        $this->start[] = substr($this->states[$i], 0, $this->order);

        for ($j = 0; $j < strlen($this->states[$i]) - $this->order; $j++) { 
          $gram = substr($this->states[$i], $j, $this->order);

          if (!isset($this->possibilities[$gram])) {
            $this->possibilities[$gram] = [];
          }

          $this->possibilities[$gram][] = substr($this->states[$i], $j + $this->order, 1); 
        }
      }
    }

    // Generate output
    public function generateRandom($chars = 15) {
      $startingState = $this->random($this->start);
      $result = $startingState;
      $current = $startingState;
      $next = '';

      for ($i = 0; $i < $chars - $this->order; $i++) {
        if (!isset($this->possibilities[$current])) break;

        $next = $this->random($this->possibilities[$current]);

        $result .= $next; 
        $current = substr($result, strlen($result) - $this->order);
      }
      
      return $result;
    }

    // Generate a random value  
    public function random($arr) {
        $mathRandom = (float)rand()/(float)getrandmax();
        $index = floor($mathRandom * count($arr)); 
        return $arr[$index];
    }
    
}

?>