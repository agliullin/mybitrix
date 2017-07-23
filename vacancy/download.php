<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
function rus2translit($string)
{
	$converter = array(
		'а' => 'a',	'б' => 'b',	'в' => 'v',
		'г' => 'g',	'д' => 'd',	'е' => 'e',
		'ё' => 'e',	'ж' => 'zh', 'з' => 'z',
		'и' => 'i',	'й' => 'y',	'к' => 'k',
		'л' => 'l',	'м' => 'm',	'н' => 'n',
		'о' => 'o',	'п' => 'p',	'р' => 'r',
		'с' => 's',	'т' => 't',	'у' => 'u',
		'ф' => 'f',	'х' => 'h',	'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
		'ь' => "_",	'ы' => 'y',	'ъ' => "_",
		'э' => 'e',	'ю' => 'yu', 'я' => 'ya',
 
		'А' => 'A',	'Б' => 'B',	'В' => 'V',
		'Г' => 'G',	'Д' => 'D',	'Е' => 'E',
		'Ё' => 'E',	'Ж' => 'Zh', 'З' => 'Z',
		'И' => 'I',	'Й' => 'Y',	'К' => 'K',
		'Л' => 'L',	'М' => 'M',	'Н' => 'N',
		'О' => 'O',	'П' => 'P',	'Р' => 'R',
		'С' => 'S',	'Т' => 'T',	'У' => 'U',
		'Ф' => 'F',	'Х' => 'H',	'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
		'Ь' => "_",	'Ы' => 'Y',	'Ъ' => "_",
		'Э' => 'E',	'Ю' => 'Yu', 'Я' => 'Ya',
	);
	return strtr($string, $converter);
}
?>
<?
	if(isset($_GET['file'])){
		if(is_numeric($_GET['file'])) {
			$F_ID=$_GET['file'];
			$rsFile = CFile::GetByID($F_ID);
			$arFile = $rsFile->Fetch();
			$fName = $arFile["ORIGINAL_NAME"];
			
			$fName=rus2translit($fName);
			
			$c_Type=$arFile["CONTENT_TYPE"];
			
			$file = CFile::GetPath($F_ID);
			$file=$_SERVER['DOCUMENT_ROOT'].$file;
			
			if(!file_exists($file))
			 	echo "Ошибка: файл не найден.";
			else
			{
				// Set headers
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=".$fName);
				header("Content-Type: $c_Type");
				header("Content-Transfer-Encoding: binary");
				// Read the file from disk
				ob_clean();
				flush();
				echo file_get_contents($file);
			}
		}
		else echo "Ошибка: файл не найден";
	}
	else echo "Ошибка: Не указан ID файла";
?>