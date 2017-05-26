<?php


abstract class Person {

    protected $name;
    protected $musicalPreference;
    protected $favoriteFootballer;

    abstract function getMusicalPreference();
    abstract function getFavoriteFootballer();

    function getName() {
        return $this->name;
    }

    function setFavoriteFootballer(string $preference)
    {
        $this->favoriteFootballer = $preference;

        return $this;
    }

    function setMusicalPreference(string $preference)
    {
        $this->musicalPreference = $preference;

        return $this;
    }

    function displayMusicalPref() {
        echo("I'm \033[00;32m". $this->getName() ."\033[0m, and I love listening to \033[01;31m". $this->getMusicalPreference() ."\033[0m \n");
    }

    function displayFavoriteFootballer() {
        echo("I'm \033[00;32m". $this->getName() ."\033[0m, and I enjoy watching \033[01;31m". $this->getFavoriteFootballer() ."\033[0m \n");
    }

}


Class GrandPa extends Person {

    function __construct(string $name)
    {
        $this->name               = $name;
        $this->favoriteFootballer = null;
        $this->musicalPreference  = null;
    }

    function getName() {
        return $this->name;
    }

    function getFavoriteFootballer() {
        return $this->favoriteFootballer ?? '';
    }

    function getMusicalPreference() {
        return $this->musicalPreference ?? '';
    }
}


class Father extends Person {

    protected $parent;

    function __construct(string $name, GrandPa $parent)
    {
        $this->name               = $name;
        $this->favoriteFootballer = null;
        $this->musicalPreference  = null;

        $this->parent = $parent;
    }


    function getFavoriteFootballer() {
        return $this->favoriteFootballer ?? $this->parent->getFavoriteFootballer();
    }

    function getMusicalPreference() {
        return $this->musicalPreference ?? $this->parent->getMusicalPreference();
    }
}

class Kid extends Person {

    protected $parent;

    function __construct(string $name, Father $parent)
    {
        $this->name               = $name;
        $this->favoriteFootballer = null;
        $this->musicalPreference  = null;

        $this->parent = $parent;
    }


    function getFavoriteFootballer() {
        return $this->favoriteFootballer ?? $this->parent->getFavoriteFootballer();
    }

    function getMusicalPreference() {
        return $this->musicalPreference ?? $this->parent->getMusicalPreference();
    }
}


//////////// DISPLAY ///////////


echo("\n***** GrandPa *****\n\n");

$grandPa = new GrandPa('GrandDad');

$grandPa->setMusicalPreference('James Brow, Ray Charles, ect...');
$grandPa->setFavoriteFootballer('Pele, Maradona, et consort... ');

$grandPa->displayFavoriteFootballer();
$grandPa->displayMusicalPref();

echo("\n***** GrandPa *****\n\n");





echo("\n***** The God Father *****\n\n");

$father = new Father('The God Father', $grandPa);

$father->setMusicalPreference("Micheal Jackson, Jackson Bros... ");
$father->displayFavoriteFootballer();
$father->displayMusicalPref();

echo("\n***** The God Father ***** \n\n");





echo("\n***** Kid *****\n\n");

$kid = new Kid('Willy the kid', $father);

$kid->setMusicalPreference('Jules, wesh alors ???');

$kid->displayFavoriteFootballer();
$kid->displayMusicalPref();

echo("\n***** Kid *****\n\n");
