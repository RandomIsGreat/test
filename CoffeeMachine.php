<?php
//вывести константы вместо всего хардкода, разделить вывод ошибок и тд
//процесс заваривания кофе в кофемашине
//

class CoffeeRecepts
{
    const AMERICANO_WATER = 40;
    const AMERICANO_BEANS = 10;
    const AMERICANO_NAME = 'Americano';
    const ESPRESSO_WATER = 20;
    const ESPRESSO_BEANS = 10;
    const ESPRESSO_NAME = 'Espresso';
    const CAPPUCCINO_WATER = 15;
    const CAPPUCCINO_BEANS = 15;
    const CAPPUCCINO_NAME = 'Cappuccino';
}
class MachineErrors
{
    const NOT_ENOUGH_WATER = "Not enough water.";
    const NOT_ENOUGH_BEANS = "Not enough beans." ;
    const POWER_IS_OFF = "Power is off.";
    const NOTHING_SELECTED = "Nothing selected.";
}

class MachineInformation
{
    const COFFEE_READY = "Coffee is ready." . PHP_EOL;
    const POWER_IS_ON = "Power is on. " . PHP_EOL;
    const POWER_IS_OFF = "Power is off." . PHP_EOL;
    const KEY_PRESSED = "Key %s pressed" . PHP_EOL;
}
class UserErrors
{
    const CUP_IS_FULL = "Cup is full";
}
class BodyPositions
{
    const STAND = "stands";
    const SIT = "sits" . PHP_EOL;
    const LIE = "lean" . PHP_EOL;
}

class UserWishes
{
    const COFFE = "coffee.";
    const SLEEP = "sleep.";
}

class House
{
    const ROOM = "room.";
    const KITCHEN = "kitchen.";
    const BATHROOM = "bathroom.";
}

class Location
{
    private $placeName=null;

    public function __construct($placeName)
    {
        $this->placeName = $placeName;

    }
   
    public function getName()
    {
        return $this->placeName;
    }
    
}

class Cup
{
    // private $twoGirlsOneCup=2;
    //пустая ли кружка
    private $isEmpty = null;
    //
    //метод чтоб посмотреть
    public function checkCup()
    {
        return $this->isEmpty;
    }
    //наполнить
    public function refile()
    {
        $this->isEmpty = false;
    }
    //конструк
    public function __construct($isEmpty = true)
    {
        $this->isEmpty = $isEmpty;
    }
}


class InformationOutput
{
    public static function seekError($errorCode)
    {
        switch ($errorCode) {
            case MachineErrors::POWER_IS_OFF:
            {
                echo 'Nothing happened. Maybe you should turn machine on?' . PHP_EOL;
                break;
            }
            case MachineErrors::NOT_ENOUGH_WATER:
            {
                echo 'Not enough water' . PHP_EOL;
                break;
            }
            case MachineErrors::NOT_ENOUGH_BEANS:
            {
                echo 'Not enough water' . PHP_EOL;
                break;
            }
            case MachineErrors::NOTHING_SELECTED:
            {
                echo 'You dont chose your coffee' . PHP_EOL;
                break;
            }
            case UserErrors::CUP_IS_FULL:
            {
                echo "Cup is full" . PHP_EOL;
                break;
            }
            default:
            {

            }
        }
    }
    public static function information($case, $data=null)
    {
        switch ($case) {
            case MachineInformation::COFFEE_READY: {
                $input =  sprintf("%s is ready." . PHP_EOL, $data);
                echo $input;
                break;
            }
            case MachineInformation::POWER_IS_ON: {
                echo "Coffee machine's power is on." . PHP_EOL;
                break;
            }
            case MachineInformation::POWER_IS_OFF: {
                echo "Coffee machine's power is off." . PHP_EOL;
                break;
            }
            case House::KITCHEN: {
                $input = sprintf("%s went into the " . House::KITCHEN . PHP_EOL, $data);
                echo $input;
                break;
            }
            case House::ROOM: {
                $input =  sprintf("%s went into the " . House::ROOM . PHP_EOL, $data);
                echo $input;
                break;
            }
            case UserWishes::COFFE: {
                $input = sprintf("%s wants " . UserWishes::COFFE . PHP_EOL, $data);
                echo $input;
                break;
            }
            case BodyPositions::STAND: {
                $input = sprintf("%s is " . BodyPositions::STAND . " now." . PHP_EOL, $data);
                echo $input;
                break;
            }
            case MachineInformation::KEY_PRESSED: {
                $input = sprintf(MachineInformation::KEY_PRESSED, $data);
                echo $input;
            }
        }
    }
}

class CoffeeMachine
{
    //проверка вклюеннности кофемашины
    private $isPower = false;
    //вес зерен в кофемашине
    private $weightOfBeans = 0;
    //объем воды в кофемашине
    private $waterVolume = 0;

    //готовка кофе
    public function makeCoffee($whatCoffe)
    {
        InformationOutput::information(MachineInformation::KEY_PRESSED, $whatCoffe);
        switch ($whatCoffe) {
            case CoffeeRecepts::ESPRESSO_NAME: {
                $this -> toMakeOneCup(CoffeeRecepts::ESPRESSO_NAME,CoffeeRecepts::ESPRESSO_WATER,CoffeeRecepts::ESPRESSO_BEANS);
                break;
            }
            case CoffeeRecepts::AMERICANO_NAME: {
                $this -> toMakeOneCup(CoffeeRecepts::AMERICANO_NAME,CoffeeRecepts::AMERICANO_WATER,CoffeeRecepts::AMERICANO_BEANS);
                break;
            }
            case CoffeeRecepts::CAPPUCCINO_NAME: {
                $this -> toMakeOneCup(CoffeeRecepts::CAPPUCCINO_NAME,CoffeeRecepts::CAPPUCCINO_WATER,CoffeeRecepts::CAPPUCCINO_BEANS);
                break;
            }
            default: {
                InformationOutput::seekError(MachineErrors::NOTHING_SELECTED);
                break;
            }
        }
    }
    //
    private function toMakeOneCup($coffeeName , $water , $beans)
    {
        if (!$this->isPower)
        {
            InformationOutput::seekError(MachineErrors::POWER_IS_OFF);
        } else {
            if ($this->weightOfBeans >= $beans && $this -> waterVolume >= $water) {
                $this->waterVolume -= $water;
                $this->weightOfBeans -= $beans;
                InformationOutput::information(MachineInformation::COFFEE_READY , $coffeeName);
            } else {
                if ($this->weightOfBeans < $beans) {
                    InformationOutput::seekError(MachineErrors::NOT_ENOUGH_BEANS);
                }
                if ($this->waterVolume < $water) {
                    InformationOutput::seekError(MachineErrors::NOT_ENOUGH_WATER);
                }
            }
        }
    }
    //включение и выключение кофемашины
    public function turning()
    {
        if($this->isPower) {
            $this->isPower = false;
            InformationOutput::information(MachineInformation::POWER_IS_OFF);
            //echo "Machine turned off" . PHP_EOL;
        } else {
            $this->isPower = true;
            InformationOutput::information(MachineInformation::POWER_IS_ON);
            //echo "Machine turned on" . PHP_EOL;
        }
    }
    //показать количество воды и бобов
    public function showBeansAndWater()
    {
            echo "Water: {$this->waterVolume}".PHP_EOL."Beans: {$this->weightOfBeans}".PHP_EOL;
    }
    //долить воды
    public function addWater($water)
    {
        $this->waterVolume+=$water;
        echo "Added {$water} water".PHP_EOL;
    }
    //досыпать кофе
    public function addBeans($beans)
    {
        $this -> weightOfBeans += $beans;
        echo "Added {$beans} beans". PHP_EOL;
    }
    //конструктор
    public function __construct($weigh , $volume)
    {
        $this->weightOfBeans = $weigh;
        $this->waterVolume = $volume;
    }

}

class User
{
    //имя
    private $name = null;
    //фамилия
    private $secondName = null;
    //положение тела (сидит/лежит/стоит)
    private $bodyPosition = null;
    //желание
    private $wish = null;
    //где находится
    private $location = null;
    //конструктор
    public function __construct($name , $secondName , $bodyPosition , $wish , $location)
    {
        $this->name = $name;
        $this->secondName = $secondName;
        $this->bodyPosition = $bodyPosition;
        $this->wish = $wish;
        $this->location = $location;
    }
    public function getName()
    {
        return $this->name;
    }
    //шагаем
    public function walkTo($location)
    {
        if ($this->bodyPosition == BodyPositions::STAND) {

            $this->location = $location;
            InformationOutput::information($location->getName(), $this->name);
            //echo $this->location->getName();
        } else {
            //отображение ошибки (человек не встал, чтобы пойти)
        }
    }

    public function switchBodyPosition($bodyPosition)
    {
        $this->bodyPosition = $bodyPosition;
        InformationOutput::information($this->bodyPosition, $this->name);
    }

    public function getBodyPosition()
    {
        return $this->bodyPosition;
    }

    public function getWish()
    {
        InformationOutput::information($this->wish, $this->name);
        return $this->wish;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function useCoffeeMachine($cup, $CoffeeMachine, $whatCoffee)
    {
        if (!$cup->checkCup()) {
            InformationOutput::seekError(UserErrors::CUP_IS_FULL);
        } else {
            $CoffeeMachine->makeCoffee($whatCoffee);
            $cup->refile();
        }
    }
}
//Машинка
/*
$boshy = new CoffeeMachine(100,100);      // может сделать не просто количество, а максимальное количество?
$boshy->turning();                                     //просто тест функционала
$boshy->showBeansAndWater();                          //просто тест функционала
$boshy->makeCoffe(CoffeeRecepts::AMERICANO_NAME);             //просто тест функционала
$boshy->showBeansAndWater();                        //просто тест функционала
$boshy->addBeans(100);                       //просто тест функционала
$boshy->addWater(200);                      //просто тест функционала
$boshy->showBeansAndWater();                     //просто тест функционала
$boshy->turning();                              //просто тест функционала
*/
//васян
// далее идет просто проверка работоспособности этой дичи


$room = new Location(House::ROOM);

$kitchen = new Location(House::KITCHEN);

$cup = new Cup(true);

$boshy = new CoffeeMachine(100,100);

$vasyan = new User('Васян' , 'Жмых' , BodyPositions::SIT, UserWishes::COFFE,  $room);

if ($vasyan->getWish() == UserWishes::COFFE) {
    if ($vasyan->getBodyPosition() != BodyPositions::STAND) {
        $vasyan->switchBodyPosition(BodyPositions::STAND);
    }
    if ($vasyan->getLocation() != House::KITCHEN) {
        $vasyan->walkTo($kitchen);
    }
    $boshy->turning();
    $randCoffee = [CoffeeRecepts::AMERICANO_NAME , CoffeeRecepts::CAPPUCCINO_NAME , CoffeeRecepts::ESPRESSO_NAME];//
    $vasyan->useCoffeeMachine($cup, $boshy, $randCoffee[array_rand($randCoffee, 1)]);
    $boshy->turning();
    $vasyan->walkTo($room);
}



?>