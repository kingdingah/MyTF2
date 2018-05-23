 <?php

  function list_inventory()
  {
  	 $APIkey = '51D6B75B0C89A45B519D3C4AF258EEFB';
  	 $profile = '76561198064278068';

     $backpackURL = "http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key=" . $APIkey . "&SteamID=" . $profile . "&format=json";
     $schemaURL = "http://api.steampowered.com/IEconItems_440/GetSchemaItems/v0001/?key=" . $APIkey . "&language=en";

     $userBackpack = json_decode(file_get_contents($backpackURL), true);
     $jsonBackpack = json_encode($userBackpack);

     $itemSchema = json_decode(file_get_contents($schemaURL), true);
     $jsonSchema = json_encode($itemSchema);

	   $backpack_items = $userBackpack['result'];
	   $schema_items = $itemSchema['result'];


     echo '{"backpack": [{';

       $numItems = count($backpack_items);
       $i = 0;

    	foreach($backpack_items['items'] as $ind=>$backpack_items)
      {
    		    $id =  $backpack_items['id'];
    		    $defindex = $backpack_items['defindex'];
            $image_url = "";
            $name = getItemName($schema_items, $defindex, $image_url);
    		    $level = $backpack_items['level'];
    		    $quantity = $backpack_items['quantity'];
    		    $flag_cannot_trade = (array_key_exists('flag_cannot_trade', $backpack_items) ? $backpack_items['flag_cannot_trade'] : false);
    		    $inventory = $backpack_items['inventory'];
    		    $position = $inventory & 65535;
    		    $equipped = ($inventory >> 16) & 1023;
    		    $equippedString = getEquipped($equipped);
    		    $quality = $backpack_items['quality'];
            $quality = getQuality($quality);

            if(++$i === $numItems)
            {
              echo ('"name": "' . $name . '"');
            }
            else
            {
                echo ('"name": "' . $name . '", ');
            }
      }

      echo '}]}';
}

  function list_mywep()
  {
  	 $APIkey = '51D6B75B0C89A45B519D3C4AF258EEFB';
  	 $profile = '76561198064278068';

     $backpackURL = "http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key=" . $APIkey . "&SteamID=" . $profile . "&format=json";

	   $userBackpack = json_decode(file_get_contents($backpackURL), true);
     $jsonBackpack = json_encode($userBackpack);

     echo $jsonBackpack;
  }

  function list_schema()
  {
    $APIkey = '51D6B75B0C89A45B519D3C4AF258EEFB';

    $schemaURL = "http://api.steampowered.com/IEconItems_440/GetSchemaItems/v0001/?key=" . $APIkey . "&language=en";

    $itemSchema = json_decode(file_get_contents($schemaURL), true);
    $jsonSchema = json_encode($itemSchema);
    echo $jsonSchema;
  }

  function getQuality($quality)
    {
        if ($quality == 1)
            return "Genuine";
        if ($quality == 3)
            return "Vintage";
        if ($quality == 5)
            return "Unusual";
        if ($quality == 6)
            return "Unique";
        if ($quality == 7)
            return "Community";
        if ($quality == 9)
            return "Self-Made";
        if ($quality == 11)
            return "Strange";
        if ($quality == 13)
            return "Haunted";
        return "";
    }

    function getItemName($schema, $defindex, $image_url)
    {
        $itemName = "";
        foreach($schema['items'] as $ind=>$schema) {
            // Store all of the item's information in separate variables
            $schema_defindex = $schema['defindex'];
            if ($defindex == $schema_defindex)
            {
                $itemName = $schema['item_name'];
                // we pass in image_url variable as a reference so we can make changes to it while we look up the item name
                $image_url = $schema['image_url'];
            }
        }
        return $itemName;
    }

	function getEquipped($equipNumber) {
		// Create an array with all of the classes in the proper order
		$classList = array(0=>'Scout', 'Sniper', 'Soldier', 'Demoman', 'Medic', 'Heavy', 'Pyro', 'Spy', 'Engineer');
		// Start with an empty string
		$equippedString = '';
		for ($i = 0; $i < 10; $i++) {
			if ((1<<$i) & $equipNumber) { // Check that the class's bit appears in the number
				if ($equippedString)
					$equippedString .= ', '; // If the string is not empty, add a comma

				$equippedString .= $classList[$i]; // Add the name of the class to the string if it is equipped by that class
			}
		}
		if (!$equippedString)
			$equippedString = 'None'; // The string is "None" if no one has it equipped
		return $equippedString;
	}
?>
