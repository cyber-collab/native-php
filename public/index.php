<?php
require_once __DIR__ . '/../vendor/autoload.php'; // include autoload

use App\Exception\EmptyStringException;
use App\Helper\FieldValidator;
use App\Helper\LetterSymbolsReverser;
use App\Helper\UniqueCharacters;
use App\Service\CacheStored;

$dataString = htmlspecialchars($_POST['string'] ?? '');
$validatorField = new FieldValidator();
$reverseWords = new LetterSymbolsReverser($validatorField);
$arrayWords = str_split($dataString);
$collection = new UniqueCharacters($arrayWords);
$cache = new CacheStored($dataString);
?>
<form method="post">
    <label for="string"><?php echo "Please, enter words" ?></label>
    <input id="string" type="text" name="string" />
    <input type="submit" name="submit"/>
</form>
<?php
try {
    if (isset($_POST['submit'])) {
        if ($cache->isHit()){
           $array = $cache->get();
           echo "From cache: ";
           echo '<br>';
        }
        else {
            $array = array($reverseWords->reverse($dataString), $collection->numberUniqueCharacters());
            $cache->set($array);
        }
        echo "Result reverse: " . $array[0];
        echo '<br>';
        echo "Counting Unique Characters:\n";
        echo $array[1];
    }
} catch (EmptyStringException $exception) {
    echo $exception->getMessage();
}
?>
