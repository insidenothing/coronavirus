<?PHP
$page_description = "Recovery Data from Wikipedia";
include_once('menu.php');

$wiki = wikidata();

echo str_replace('" data-section="26" class="">','',$wiki['chart']);
//echo $wiki['changes'];

echo $wiki['graph'];



include_once('footer.php');
