<?php
include_once './src/markov.php';

$markov = new Markov();

$markov->addStates([
    'Today is sunny',
    'Today is rainy',
    'Today is not rainy',
    'The weather is sunny',
    'The weather for today is sunny',
    'The weather for tomorrow might be rainy',
]);


$markov->train();

// Generate an output
$text = $markov->generateRandom(30);
echo $text;

?>