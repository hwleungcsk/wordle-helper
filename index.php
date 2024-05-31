
<?php
	$l1 = $_GET['l1'] ?? '';
	$l2 = $_GET['l2'] ?? '';
	$l3 = $_GET['l3'] ?? '';
	$l4 = $_GET['l4'] ?? '';
	$l5 = $_GET['l5'] ?? '';
	$lx  = $_GET['lx'] ?? '';
	$ly  = $_GET['ly'] ?? '';

	echo '<title>Wordle Helper</title></head>';
	echo "<h3>Wordle helper</h3>Enter characters you guess in cooresponding boxes.\n";
	echo "<form action=\"\" id=\"myForm\"><input size=1  name=\"l1\" value=\"$l1\"><input size=1  name=\"l2\" value=\"$l2\">";
	echo "<input size=1  name=\"l3\" value=\"$l3\"><input size=1  name=\"l4\" value=\"$l4\"><input size=1  name=\"l5\" value=\"$l5\"><p>\n";
	echo "Include characters: <input size=10  name=\"ly\" value=\"$ly\"><p>";
	echo "Exclude characters: <input size=10  name=\"lx\" value=\"$lx\"><p>";
	echo '<input type="submit"> <input type="button" onclick="myFunction()" value="Reset"> </form>';

		$db = new PDO('sqlite:wordle.db');
		$word = '';

		if ($l1 != '')
			$word .= $l1;
		else
			$word .= '_';
		if ($l2 != '')
			$word .= $l2;
		else
			$word .= '_';
		if ($l3 != '')
			$word .= $l3;
		else
			$word .= '_';
		if ($l4 != '')
			$word .= $l4;
		else
			$word .= '_';
		if ($l5 != '')
			$word .= $l5;
		else
			$word .= '_';

		$sql = 'select distinct word from entries where word like ? ';
		$sql2 = 'select distinct word from entries where word like \'%'.$word.'%\' ';

		for($i = 0; $i < strlen($lx); $i++)
		{
			$sql .= " and word not like '%$lx[$i]%'";
			$sql2 .= " and word not like '%$lx[$i]%'";
		}

		for($i = 0; $i < strlen($ly); $i++)
		{
			$sql .= " and word like '%$ly[$i]%'";
			$sql2 .= " and word like '%$ly[$i]%'";
		}

		echo $sql2.'<br><br><br>';
		$stmt = $db->prepare($sql);
		$stmt-> execute(array($word));

		$result = $stmt->fetchAll();
		if (count($result) > 0)
		{
		    foreach ($result as $word)
				echo $word[0].'<br>';
		}
		else
			echo 'Not match.';
?>

<script>
	function myFunction() {
	document.forms['myForm']['l1'].setAttribute('value','');
	document.forms['myForm']['l2'].setAttribute('value','');
	document.forms['myForm']['l3'].setAttribute('value','');
	document.forms['myForm']['l4'].setAttribute('value','');
	document.forms['myForm']['l5'].setAttribute('value','');
	document.forms['myForm']['lx'].setAttribute('value','');
	document.forms['myForm']['ly'].setAttribute('value','');
	}
</script>
