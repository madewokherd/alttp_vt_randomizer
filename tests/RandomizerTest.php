<?php

use ALttP\Randomizer;
use ALttP\Item;

/**
 * These test may have to be updated on any Logic change that adjusts the pooling of the RNG
 */
class RandomizerTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->randomizer = new Randomizer('test_rules');
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->randomizer);
	}

	public function testGetSeedIsNullBeforeRandomization() {
		$this->assertNull($this->randomizer->getSeed());
	}

	public function testGetSeedIsNotNullAfterRandomization() {
		$this->randomizer->makeSeed();

		$this->assertNotNull($this->randomizer->getSeed());
	}

	/**
	 * @group crystals
	 */
	public function testCrystalsNotRandomizedByConfigCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', true);
		Config::set('alttp.test_rules.prize.shuffleCrystals', false);

		$this->randomizer->makeSeed(1337);
		$this->assertEquals([
			Item::get('Crystal1'),
			Item::get('Crystal2'),
			Item::get('Crystal3'),
			Item::get('Crystal4'),
			Item::get('Crystal5'),
			Item::get('Crystal6'),
			Item::get('Crystal7'),
		], [
			$this->randomizer->getWorld()->getLocation("Palace of Darkness - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Swamp Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Skull Woods - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Thieves' Town - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Ice Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Misery Mire - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Turtle Rock - Prize")->getItem(),
		]);
	}

	/**
	 * @group crystals
	 */
	public function testCrystalsNotRandomizedByConfigNoCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', false);
		Config::set('alttp.test_rules.prize.shuffleCrystals', false);

		$this->randomizer->makeSeed(1337);

		$this->assertEquals([
			Item::get('Crystal1'),
			Item::get('Crystal2'),
			Item::get('Crystal3'),
			Item::get('Crystal4'),
			Item::get('Crystal5'),
			Item::get('Crystal6'),
			Item::get('Crystal7'),
		], [
			$this->randomizer->getWorld()->getLocation("Palace of Darkness - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Swamp Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Skull Woods - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Thieves' Town - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Ice Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Misery Mire - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Turtle Rock - Prize")->getItem(),
		]);
	}


	/**
	 * @group pendants
	 */
	public function testPendantsNotRandomizedByConfigNoCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', false);
		Config::set('alttp.test_rules.prize.shufflePendants', false);

		$this->randomizer->makeSeed(1337);

		$this->assertEquals([
			Item::get('PendantOfCourage'),
			Item::get('PendantOfPower'),
			Item::get('PendantOfWisdom'),
		], [
			$this->randomizer->getWorld()->getLocation("Eastern Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Desert Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Tower of Hera - Prize")->getItem(),
		]);
	}

	/**
	 * @group pendants
	 */
	public function testPendantsNotRandomizedByConfigCrossWorld() {
		Config::set('alttp.test_rules.prize.crossWorld', true);
		Config::set('alttp.test_rules.prize.shufflePendants', false);

		$this->randomizer->makeSeed(1337);

		$this->assertEquals([
			Item::get('PendantOfCourage'),
			Item::get('PendantOfPower'),
			Item::get('PendantOfWisdom'),
		], [
			$this->randomizer->getWorld()->getLocation("Eastern Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Desert Palace - Prize")->getItem(),
			$this->randomizer->getWorld()->getLocation("Tower of Hera - Prize")->getItem(),
		]);
	}

	/**
	 * Adjust this test and increment Logic on Randomizer if this fails.
	 *
	 * @group logic
	 */
	public function testLogicHasntChangedNoMajorGlitches() {
		$this->randomizer->makeSeed(1337);
		$loc_item_array = $this->randomizer->getWorld()->getLocations()->map(function($loc){
			return $loc->getItem()->getName();
		});

		$this->assertEquals([
			"Master Sword Pedestal" => "FiveRupees",
			"Link's Uncle" => "ProgressiveSword",
			"Secret Passage" => "PieceOfHeart",
			"King's Tomb" => "PieceOfHeart",
			"Floodgate Chest" => "ArrowUpgrade5",
			"Link's House" => "Flippers",
			"Kakariko Tavern" => "ThreeHundredRupees",
			"Chicken House" => "ThreeBombs",
			"Aginah's Cave" => "TenArrows",
			"Sahasrahla's Hut - Left" => "TwentyRupees",
			"Sahasrahla's Hut - Middle" => "TwentyRupees",
			"Sahasrahla's Hut - Right" => "PieceOfHeart",
			"Kakriko Well - Top" => "ThreeBombs",
			"Kakriko Well - Left" => "FiftyRupees",
			"Kakriko Well - Middle" => "PieceOfHeart",
			"Kakriko Well - Right" => "PieceOfHeart",
			"Kakriko Well - Bottom" => "TwentyRupees",
			"Blind's Hideout - Top" => "ThreeBombs",
			"Blind's Hideout - Left" => "RedBoomerang",
			"Blind's Hideout - Right" => "Bombos",
			"Blind's Hideout - Far Left" => "BossHeartContainer",
			"Blind's Hideout - Far Right" => "Quake",
			"Pegasus Rocks" => "ProgressiveShield",
			"Mini Moldorm Cave - Far Left" => "BottleWithGoldBee",
			"Mini Moldorm Cave - Left" => "ArrowUpgrade5",
			"Mini Moldorm Cave - Right" => "TwentyRupees",
			"Mini Moldorm Cave - Far Right" => "BombUpgrade5",
			"Ice Rod Cave" => "HalfMagic",
			"Bottle Merchant" => "MoonPearl",
			"Sahasrahla" => "PieceOfHeart",
			"Magic Bat" => "BossHeartContainer",
			"Sick Kid" => "OneRupee",
			"Hobo" => "FiftyRupees",
			"Bombos Tablet" => "TwentyRupees",
			"King Zora" => "TwentyRupees",
			"Lost Woods Hideout" => "TwentyRupees",
			"Lumberjack Tree" => "PieceOfHeart",
			"Cave 45" => "Lamp",
			"Graveyard Ledge" => "ThreeBombs",
			"Checkerboard Cave" => "PieceOfHeart",
			"Mini Moldorm Cave - NPC" => "HeartContainer",
			"Library" => "ThreeBombs",
			"Mushroom" => "TwentyRupees",
			"Potion Shop" => "ProgressiveShield",
			"Maze Race" => "TwentyRupees",
			"Desert Ledge" => "ThreeBombs",
			"Lake Hylia Island" => "Ether",
			"Sunken Treasure" => "ProgressiveGlove",
			"Zora's Ledge" => "ThreeBombs",
			"Flute Spot" => "BombUpgrade5",
			"Waterfall Fairy - Left" => "PieceOfHeart",
			"Waterfall Fairy - Right" => "PieceOfHeart",
			"Sanctuary" => "MapH2",
			"Sewers - Secret Room - Left" => "ProgressiveSword",
			"Sewers - Secret Room - Middle" => "TenArrows",
			"Sewers - Secret Room - Right" => "PieceOfHeart",
			"Sewers - Dark Cross" => "KeyH2",
			"Hyrule Castle - Boomerang Chest" => "Hammer",
			"Hyrule Castle - Map Chest" => "TwentyRupees",
			"Hyrule Castle - Zelda's Cell" => "PieceOfHeart",
			"Eastern Palace - Compass Chest" => "CompassP1",
			"Eastern Palace - Big Chest" => "PieceOfHeart",
			"Eastern Palace - Cannonball Chest" => "MapP1",
			"Eastern Palace - Big Key Chest" => "BigKeyP1",
			"Eastern Palace - Map Chest" => "TwentyRupees",
			"Eastern Palace - Armos Knights" => "TwentyRupees",
			"Eastern Palace - Prize" => "Crystal4",
			"Desert Palace - Big Chest" => "KeyP2",
			"Desert Palace - Map Chest" => "CompassP2",
			"Desert Palace - Torch" => "BigKeyP2",
			"Desert Palace - Big Key Chest" => "BossHeartContainer",
			"Desert Palace - Compass Chest" => "Boomerang",
			"Desert Palace - Lanmolas'" => "MapP2",
			"Desert Palace - Prize" => "PendantOfPower",
			"Old Man" => "FiftyRupees",
			"Spectacle Rock Cave" => "PieceOfHeart",
			"Ether Tablet" => "ProgressiveShield",
			"Spectacle Rock" => "TwentyRupees",
			"Spiral Cave" => "TwentyRupees",
			"Mimic Cave" => "IceRod",
			"Paradox Cave Lower - Far Left" => "TwentyRupees",
			"Paradox Cave Lower - Left" => "Mushroom",
			"Paradox Cave Lower - Right" => "CaneOfSomaria",
			"Paradox Cave Lower - Far Right" => "FiftyRupees",
			"Paradox Cave Lower - Middle" => "BossHeartContainer",
			"Paradox Cave Upper - Left" => "FiftyRupees",
			"Paradox Cave Upper - Right" => "TwentyRupees",
			"Floating Island" => "BossHeartContainer",
			"Tower of Hera - Big Key Chest" => "TwentyRupees",
			"Tower of Hera - Basement Cage" => "MagicMirror",
			"Tower of Hera - Map Chest" => "BigKeyP3",
			"Tower of Hera - Compass Chest" => "MapP3",
			"Tower of Hera - Big Chest" => "CompassP3",
			"Tower of Hera - Moldorm" => "KeyP3",
			"Tower of Hera - Prize" => "Crystal2",
			"Castle Tower - Room 03" => "KeyA1",
			"Castle Tower - Dark Maze" => "KeyA1",
			"Agahnim" => "DefeatAgahnim",
			"Superbunny Cave - Top" => "PieceOfHeart",
			"Superbunny Cave - Bottom" => "ThreeBombs",
			"Hookshot Cave - Top Right" => "BugCatchingNet",
			"Hookshot Cave - Top Left" => "BossHeartContainer",
			"Hookshot Cave - Bottom Left" => "PieceOfHeart",
			"Hookshot Cave - Bottom Right" => "FireRod",
			"Spike Cave" => "TwentyRupees",
			"Catfish" => "PieceOfHeart",
			"Pyramid" => "TenArrows",
			"Pyramid Fairy - Sword" => "L1Sword",
			"Pyramid Fairy - Bow" => "BowAndArrows",
			"Ganon" => "DefeatGanon",
			"Pyramid Fairy - Left" => "BossHeartContainer",
			"Pyramid Fairy - Right" => "ArrowUpgrade5",
			"Brewery" => "TenArrows",
			"C-Shaped House" => "Cape",
			"Chest Game" => "BottleWithFairy",
			"Hammer Pegs" => "PieceOfHeart",
			"Bumper Cave" => "ProgressiveGlove",
			"Blacksmith" => "SilverArrowUpgrade",
			"Purple Chest" => "TwentyRupees",
			"Hype Cave - Top" => "ThreeBombs",
			"Hype Cave - Middle Right" => "ProgressiveArmor",
			"Hype Cave - Middle Left" => "TwentyRupees",
			"Hype Cave - Bottom" => "ArrowUpgrade10",
			"Stumpy" => "PieceOfHeart",
			"Hype Cave - NPC" => "TwentyRupees",
			"Digging Game" => "ThreeHundredRupees",
			"Mire Shed - Left" => "OneRupee",
			"Mire Shed - Right" => "BombUpgrade10",
			"Palace of Darkness - Shooter Room" => "PegasusBoots",
			"Palace of Darkness - Big Key Chest" => "KeyD1",
			"Palace of Darkness - The Arena - Ledge" => "KeyD1",
			"Palace of Darkness - The Arena - Bridge" => "ArrowUpgrade5",
			"Palace of Darkness - Stalfos Basement" => "KeyD1",
			"Palace of Darkness - Map Chest" => "KeyD1",
			"Palace of Darkness - Big Chest" => "MapD1",
			"Palace of Darkness - Compass Chest" => "KeyD1",
			"Palace of Darkness - Harmless Hellway" => "BottleWithBluePotion",
			"Palace of Darkness - Dark Basement - Left" => "KeyD1",
			"Palace of Darkness - Dark Basement - Right" => "CompassD1",
			"Palace of Darkness - Dark Maze - Top" => "BigKeyD1",
			"Palace of Darkness - Dark Maze - Bottom" => "CaneOfByrna",
			"Palace of Darkness - Helmasaur King" => "Powder",
			"Palace of Darkness - Prize" => "PendantOfCourage",
			"Swamp Palace - Entrance" => "KeyD2",
			"Swamp Palace - Big Chest" => "TenArrows",
			"Swamp Palace - Big Key Chest" => "PieceOfHeart",
			"Swamp Palace - Map Chest" => "FiftyRupees",
			"Swamp Palace - West Chest" => "OneHundredRupees",
			"Swamp Palace - Compass Chest" => "TwentyRupees",
			"Swamp Palace - Flooded Room - Left" => "BigKeyD2",
			"Swamp Palace - Flooded Room - Right" => "CompassD2",
			"Swamp Palace - Waterfall Room" => "MapD2",
			"Swamp Palace - Arrghus" => "FiveRupees",
			"Swamp Palace - Prize" => "Crystal3",
			"Skull Woods - Big Chest" => "Shovel",
			"Skull Woods - Big Key Chest" => "KeyD3",
			"Skull Woods - Compass Chest" => "CompassD3",
			"Skull Woods - Map Chest" => "KeyD3",
			"Skull Woods - Bridge Room" => "ArrowUpgrade5",
			"Skull Woods - Pot Prison" => "MapD3",
			"Skull Woods - Pinball Room" => "KeyD3",
			"Skull Woods - Mothula" => "BigKeyD3",
			"Skull Woods - Prize" => "Crystal1",
			"Thieves' Town - Attic" => "MapD4",
			"Thieves' Town - Big Key Chest" => "TwentyRupees",
			"Thieves' Town - Map Chest" => "BombUpgrade5",
			"Thieves' Town - Compass Chest" => "BigKeyD4",
			"Thieves' Town - Ambush Chest" => "CompassD4",
			"Thieves' Town - Big Chest" => "Arrow",
			"Thieves' Town - Blind's Cell" => "KeyD4",
			"Thieves' Town - Blind" => "BottleWithFairy",
			"Thieves' Town - Prize" => "Crystal7",
			"Ice Palace - Big Key Chest" => "KeyD5",
			"Ice Palace - Compass Chest" => "BossHeartContainer",
			"Ice Palace - Map Chest" => "MapD5",
			"Ice Palace - Spike Room" => "BigKeyD5",
			"Ice Palace - Freezor Chest" => "KeyD5",
			"Ice Palace - Iced T Room" => "CompassD5",
			"Ice Palace - Big Chest" => "OcarinaInactive",
			"Ice Palace - Kholdstare" => "TwentyRupees",
			"Ice Palace - Prize" => "PendantOfWisdom",
			"Misery Mire - Big Chest" => "KeyD6",
			"Misery Mire - Main Lobby" => "CompassD6",
			"Misery Mire - Big Key Chest" => "MapD6",
			"Misery Mire - Compass Chest" => "PieceOfHeart",
			"Misery Mire - Bridge Chest" => "Hookshot",
			"Misery Mire - Map Chest" => "BigKeyD6",
			"Misery Mire - Spike Chest" => "KeyD6",
			"Misery Mire - Vitreous" => "KeyD6",
			"Misery Mire - Prize" => "Crystal5",
			"Turtle Rock - Chain Chomps" => "BossHeartContainer",
			"Turtle Rock - Compass Chest" => "KeyD7",
			"Turtle Rock - Roller Room - Left" => "Bow",
			"Turtle Rock - Roller Room - Right" => "KeyD7",
			"Turtle Rock - Big Chest" => "CompassD7",
			"Turtle Rock - Big Key Chest" => "BigKeyD7",
			"Turtle Rock - Crystaroller Room" => "KeyD7",
			"Turtle Rock - Eye Bridge - Bottom Left" => "FiveRupees",
			"Turtle Rock - Eye Bridge - Bottom Right" => "KeyD7",
			"Turtle Rock - Eye Bridge - Top Left" => "ThreeHundredRupees",
			"Turtle Rock - Eye Bridge - Top Right" => "MapD7",
			"Turtle Rock - Trinexx" => "BossHeartContainer",
			"Turtle Rock - Prize" => "Crystal6",
			"Ganon's Tower - Bob's Torch" => "ArrowUpgrade5",
			"Ganon's Tower - DMs Room - Top Left" => "ProgressiveSword",
			"Ganon's Tower - DMs Room - Top Right" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Right" => "ProgressiveArmor",
			"Ganon's Tower - Randomizer Room - Top Left" => "ThreeBombs",
			"Ganon's Tower - Randomizer Room - Top Right" => "CompassA2",
			"Ganon's Tower - Randomizer Room - Bottom Left" => "ThreeHundredRupees",
			"Ganon's Tower - Randomizer Room - Bottom Right" => "ThreeHundredRupees",
			"Ganon's Tower - Firesnake Room" => "TwentyRupees",
			"Ganon's Tower - Map Chest" => "PieceOfHeart",
			"Ganon's Tower - Big Chest" => "TwentyRupees",
			"Ganon's Tower - Hope Room - Left" => "BombUpgrade5",
			"Ganon's Tower - Hope Room - Right" => "FiftyRupees",
			"Ganon's Tower - Bob's Chest" => "TwentyRupees",
			"Ganon's Tower - Tile Room" => "KeyA2",
			"Ganon's Tower - Compass Room - Top Left" => "BombUpgrade5",
			"Ganon's Tower - Compass Room - Top Right" => "BookOfMudora",
			"Ganon's Tower - Compass Room - Bottom Left" => "BigKeyA2",
			"Ganon's Tower - Compass Room - Bottom Right" => "ProgressiveSword",
			"Ganon's Tower - Big Key Chest" => "BombUpgrade5",
			"Ganon's Tower - Big Key Room - Left" => "KeyA2",
			"Ganon's Tower - Big Key Room - Right" => "TwentyRupees",
			"Ganon's Tower - Mini Helmasaur Room - Left" => "PieceOfHeart",
			"Ganon's Tower - Mini Helmasaur Room - Right" => "MapA2",
			"Ganon's Tower - Pre-Moldorm Chest" => "FiveRupees",
			"Ganon's Tower - Moldorm Chest" => "PieceOfHeart",
			"Agahnim 2" => "DefeatAgahnim2",
			"Turtle Rock Medallion" => "Quake",
			"Misery Mire Medallion" => "Bombos",
			"Waterfall Bottle" => "BottleWithBluePotion",
			"Pyramid Bottle" => "BottleWithGreenPotion",
		], $loc_item_array);
	}

	/**
	 * Adjust this test and increment Logic on Randomizer if this fails.
	 *
	 * @group logic
	 */
	public function testLogicHasntChangedOverworldGlitches() {
		$this->randomizer = new Randomizer('test_rules', 'OverworldGlitches');
		$this->randomizer->makeSeed(1337);
		$loc_item_array = $this->randomizer->getWorld()->getLocations()->map(function($loc){
			return $loc->getItem()->getName();
		});

		$this->assertEquals([
			"Master Sword Pedestal" => "FiveRupees",
			"Link's Uncle" => "ProgressiveSword",
			"Secret Passage" => "PieceOfHeart",
			"King's Tomb" => "PieceOfHeart",
			"Floodgate Chest" => "ArrowUpgrade5",
			"Link's House" => "Flippers",
			"Kakariko Tavern" => "ThreeHundredRupees",
			"Chicken House" => "ThreeBombs",
			"Aginah's Cave" => "TenArrows",
			"Sahasrahla's Hut - Left" => "TwentyRupees",
			"Sahasrahla's Hut - Middle" => "TwentyRupees",
			"Sahasrahla's Hut - Right" => "PieceOfHeart",
			"Kakriko Well - Top" => "ThreeBombs",
			"Kakriko Well - Left" => "FiftyRupees",
			"Kakriko Well - Middle" => "PieceOfHeart",
			"Kakriko Well - Right" => "PieceOfHeart",
			"Kakriko Well - Bottom" => "TwentyRupees",
			"Blind's Hideout - Top" => "ThreeBombs",
			"Blind's Hideout - Left" => "RedBoomerang",
			"Blind's Hideout - Right" => "IceRod",
			"Blind's Hideout - Far Left" => "BossHeartContainer",
			"Blind's Hideout - Far Right" => "Quake",
			"Pegasus Rocks" => "ProgressiveShield",
			"Mini Moldorm Cave - Far Left" => "BottleWithGoldBee",
			"Mini Moldorm Cave - Left" => "ArrowUpgrade5",
			"Mini Moldorm Cave - Right" => "TwentyRupees",
			"Mini Moldorm Cave - Far Right" => "BombUpgrade5",
			"Ice Rod Cave" => "HalfMagic",
			"Bottle Merchant" => "MoonPearl",
			"Sahasrahla" => "PieceOfHeart",
			"Magic Bat" => "BossHeartContainer",
			"Sick Kid" => "OneRupee",
			"Hobo" => "FiftyRupees",
			"Bombos Tablet" => "TwentyRupees",
			"King Zora" => "TwentyRupees",
			"Lost Woods Hideout" => "TwentyRupees",
			"Lumberjack Tree" => "PieceOfHeart",
			"Cave 45" => "Hammer",
			"Graveyard Ledge" => "ThreeBombs",
			"Checkerboard Cave" => "PieceOfHeart",
			"Mini Moldorm Cave - NPC" => "HeartContainer",
			"Library" => "ThreeBombs",
			"Mushroom" => "TwentyRupees",
			"Potion Shop" => "ProgressiveShield",
			"Maze Race" => "TwentyRupees",
			"Desert Ledge" => "ThreeBombs",
			"Lake Hylia Island" => "Ether",
			"Sunken Treasure" => "ProgressiveShield",
			"Zora's Ledge" => "ThreeBombs",
			"Flute Spot" => "BombUpgrade5",
			"Waterfall Fairy - Left" => "PieceOfHeart",
			"Waterfall Fairy - Right" => "PieceOfHeart",
			"Sanctuary" => "MapH2",
			"Sewers - Secret Room - Left" => "ProgressiveSword",
			"Sewers - Secret Room - Middle" => "TenArrows",
			"Sewers - Secret Room - Right" => "PieceOfHeart",
			"Sewers - Dark Cross" => "KeyH2",
			"Hyrule Castle - Boomerang Chest" => "BookOfMudora",
			"Hyrule Castle - Map Chest" => "TwentyRupees",
			"Hyrule Castle - Zelda's Cell" => "PieceOfHeart",
			"Eastern Palace - Compass Chest" => "CompassP1",
			"Eastern Palace - Big Chest" => "PieceOfHeart",
			"Eastern Palace - Cannonball Chest" => "MapP1",
			"Eastern Palace - Big Key Chest" => "BigKeyP1",
			"Eastern Palace - Map Chest" => "TwentyRupees",
			"Eastern Palace - Armos Knights" => "TwentyRupees",
			"Eastern Palace - Prize" => "Crystal4",
			"Desert Palace - Big Chest" => "KeyP2",
			"Desert Palace - Map Chest" => "CompassP2",
			"Desert Palace - Torch" => "BigKeyP2",
			"Desert Palace - Big Key Chest" => "BossHeartContainer",
			"Desert Palace - Compass Chest" => "Boomerang",
			"Desert Palace - Lanmolas'" => "MapP2",
			"Desert Palace - Prize" => "PendantOfPower",
			"Old Man" => "FiftyRupees",
			"Spectacle Rock Cave" => "PieceOfHeart",
			"Ether Tablet" => "ProgressiveGlove",
			"Spectacle Rock" => "TwentyRupees",
			"Spiral Cave" => "TwentyRupees",
			"Mimic Cave" => "Bombos",
			"Paradox Cave Lower - Far Left" => "TwentyRupees",
			"Paradox Cave Lower - Left" => "Mushroom",
			"Paradox Cave Lower - Right" => "CaneOfSomaria",
			"Paradox Cave Lower - Far Right" => "PegasusBoots",
			"Paradox Cave Lower - Middle" => "BossHeartContainer",
			"Paradox Cave Upper - Left" => "FiftyRupees",
			"Paradox Cave Upper - Right" => "TwentyRupees",
			"Floating Island" => "BossHeartContainer",
			"Tower of Hera - Big Key Chest" => "TwentyRupees",
			"Tower of Hera - Basement Cage" => "MagicMirror",
			"Tower of Hera - Map Chest" => "BigKeyP3",
			"Tower of Hera - Compass Chest" => "MapP3",
			"Tower of Hera - Big Chest" => "CompassP3",
			"Tower of Hera - Moldorm" => "KeyP3",
			"Tower of Hera - Prize" => "Crystal2",
			"Castle Tower - Room 03" => "KeyA1",
			"Castle Tower - Dark Maze" => "KeyA1",
			"Agahnim" => "DefeatAgahnim",
			"Superbunny Cave - Top" => "PieceOfHeart",
			"Superbunny Cave - Bottom" => "ThreeBombs",
			"Hookshot Cave - Top Right" => "BugCatchingNet",
			"Hookshot Cave - Top Left" => "BossHeartContainer",
			"Hookshot Cave - Bottom Left" => "PieceOfHeart",
			"Hookshot Cave - Bottom Right" => "FireRod",
			"Spike Cave" => "TwentyRupees",
			"Catfish" => "PieceOfHeart",
			"Pyramid" => "TenArrows",
			"Pyramid Fairy - Sword" => "L1Sword",
			"Pyramid Fairy - Bow" => "BowAndArrows",
			"Ganon" => "DefeatGanon",
			"Pyramid Fairy - Left" => "BossHeartContainer",
			"Pyramid Fairy - Right" => "ArrowUpgrade5",
			"Brewery" => "TenArrows",
			"C-Shaped House" => "Cape",
			"Chest Game" => "BottleWithFairy",
			"Hammer Pegs" => "PieceOfHeart",
			"Bumper Cave" => "ProgressiveGlove",
			"Blacksmith" => "SilverArrowUpgrade",
			"Purple Chest" => "TwentyRupees",
			"Hype Cave - Top" => "ThreeBombs",
			"Hype Cave - Middle Right" => "ProgressiveArmor",
			"Hype Cave - Middle Left" => "TwentyRupees",
			"Hype Cave - Bottom" => "ArrowUpgrade10",
			"Stumpy" => "PieceOfHeart",
			"Hype Cave - NPC" => "TwentyRupees",
			"Digging Game" => "ThreeHundredRupees",
			"Mire Shed - Left" => "OneRupee",
			"Mire Shed - Right" => "BombUpgrade10",
			"Palace of Darkness - Shooter Room" => "FiftyRupees",
			"Palace of Darkness - Big Key Chest" => "KeyD1",
			"Palace of Darkness - The Arena - Ledge" => "KeyD1",
			"Palace of Darkness - The Arena - Bridge" => "ArrowUpgrade5",
			"Palace of Darkness - Stalfos Basement" => "KeyD1",
			"Palace of Darkness - Map Chest" => "KeyD1",
			"Palace of Darkness - Big Chest" => "MapD1",
			"Palace of Darkness - Compass Chest" => "KeyD1",
			"Palace of Darkness - Harmless Hellway" => "BottleWithBluePotion",
			"Palace of Darkness - Dark Basement - Left" => "KeyD1",
			"Palace of Darkness - Dark Basement - Right" => "CompassD1",
			"Palace of Darkness - Dark Maze - Top" => "BigKeyD1",
			"Palace of Darkness - Dark Maze - Bottom" => "Hookshot",
			"Palace of Darkness - Helmasaur King" => "Powder",
			"Palace of Darkness - Prize" => "PendantOfCourage",
			"Swamp Palace - Entrance" => "KeyD2",
			"Swamp Palace - Big Chest" => "TenArrows",
			"Swamp Palace - Big Key Chest" => "PieceOfHeart",
			"Swamp Palace - Map Chest" => "FiftyRupees",
			"Swamp Palace - West Chest" => "OneHundredRupees",
			"Swamp Palace - Compass Chest" => "TwentyRupees",
			"Swamp Palace - Flooded Room - Left" => "BigKeyD2",
			"Swamp Palace - Flooded Room - Right" => "CompassD2",
			"Swamp Palace - Waterfall Room" => "MapD2",
			"Swamp Palace - Arrghus" => "FiveRupees",
			"Swamp Palace - Prize" => "Crystal3",
			"Skull Woods - Big Chest" => "Shovel",
			"Skull Woods - Big Key Chest" => "KeyD3",
			"Skull Woods - Compass Chest" => "CompassD3",
			"Skull Woods - Map Chest" => "KeyD3",
			"Skull Woods - Bridge Room" => "ArrowUpgrade5",
			"Skull Woods - Pot Prison" => "MapD3",
			"Skull Woods - Pinball Room" => "KeyD3",
			"Skull Woods - Mothula" => "BigKeyD3",
			"Skull Woods - Prize" => "Crystal1",
			"Thieves' Town - Attic" => "MapD4",
			"Thieves' Town - Big Key Chest" => "TwentyRupees",
			"Thieves' Town - Map Chest" => "BombUpgrade5",
			"Thieves' Town - Compass Chest" => "BigKeyD4",
			"Thieves' Town - Ambush Chest" => "CompassD4",
			"Thieves' Town - Big Chest" => "Arrow",
			"Thieves' Town - Blind's Cell" => "KeyD4",
			"Thieves' Town - Blind" => "BottleWithFairy",
			"Thieves' Town - Prize" => "Crystal7",
			"Ice Palace - Big Key Chest" => "KeyD5",
			"Ice Palace - Compass Chest" => "BossHeartContainer",
			"Ice Palace - Map Chest" => "MapD5",
			"Ice Palace - Spike Room" => "BigKeyD5",
			"Ice Palace - Freezor Chest" => "KeyD5",
			"Ice Palace - Iced T Room" => "CompassD5",
			"Ice Palace - Big Chest" => "OcarinaInactive",
			"Ice Palace - Kholdstare" => "TwentyRupees",
			"Ice Palace - Prize" => "PendantOfWisdom",
			"Misery Mire - Big Chest" => "KeyD6",
			"Misery Mire - Main Lobby" => "CompassD6",
			"Misery Mire - Big Key Chest" => "MapD6",
			"Misery Mire - Compass Chest" => "PieceOfHeart",
			"Misery Mire - Bridge Chest" => "Lamp",
			"Misery Mire - Map Chest" => "BigKeyD6",
			"Misery Mire - Spike Chest" => "KeyD6",
			"Misery Mire - Vitreous" => "KeyD6",
			"Misery Mire - Prize" => "Crystal5",
			"Turtle Rock - Chain Chomps" => "BossHeartContainer",
			"Turtle Rock - Compass Chest" => "KeyD7",
			"Turtle Rock - Roller Room - Left" => "Bow",
			"Turtle Rock - Roller Room - Right" => "KeyD7",
			"Turtle Rock - Big Chest" => "CompassD7",
			"Turtle Rock - Big Key Chest" => "BigKeyD7",
			"Turtle Rock - Crystaroller Room" => "KeyD7",
			"Turtle Rock - Eye Bridge - Bottom Left" => "FiveRupees",
			"Turtle Rock - Eye Bridge - Bottom Right" => "KeyD7",
			"Turtle Rock - Eye Bridge - Top Left" => "ThreeHundredRupees",
			"Turtle Rock - Eye Bridge - Top Right" => "MapD7",
			"Turtle Rock - Trinexx" => "BossHeartContainer",
			"Turtle Rock - Prize" => "Crystal6",
			"Ganon's Tower - Bob's Torch" => "ArrowUpgrade5",
			"Ganon's Tower - DMs Room - Top Left" => "ProgressiveSword",
			"Ganon's Tower - DMs Room - Top Right" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Right" => "ProgressiveArmor",
			"Ganon's Tower - Randomizer Room - Top Left" => "ThreeBombs",
			"Ganon's Tower - Randomizer Room - Top Right" => "CompassA2",
			"Ganon's Tower - Randomizer Room - Bottom Left" => "ThreeHundredRupees",
			"Ganon's Tower - Randomizer Room - Bottom Right" => "ThreeHundredRupees",
			"Ganon's Tower - Firesnake Room" => "TwentyRupees",
			"Ganon's Tower - Map Chest" => "PieceOfHeart",
			"Ganon's Tower - Big Chest" => "TwentyRupees",
			"Ganon's Tower - Hope Room - Left" => "BombUpgrade5",
			"Ganon's Tower - Hope Room - Right" => "FiftyRupees",
			"Ganon's Tower - Bob's Chest" => "TwentyRupees",
			"Ganon's Tower - Tile Room" => "KeyA2",
			"Ganon's Tower - Compass Room - Top Left" => "BombUpgrade5",
			"Ganon's Tower - Compass Room - Top Right" => "CaneOfByrna",
			"Ganon's Tower - Compass Room - Bottom Left" => "BigKeyA2",
			"Ganon's Tower - Compass Room - Bottom Right" => "ProgressiveSword",
			"Ganon's Tower - Big Key Chest" => "BombUpgrade5",
			"Ganon's Tower - Big Key Room - Left" => "KeyA2",
			"Ganon's Tower - Big Key Room - Right" => "TwentyRupees",
			"Ganon's Tower - Mini Helmasaur Room - Left" => "PieceOfHeart",
			"Ganon's Tower - Mini Helmasaur Room - Right" => "MapA2",
			"Ganon's Tower - Pre-Moldorm Chest" => "FiveRupees",
			"Ganon's Tower - Moldorm Chest" => "PieceOfHeart",
			"Agahnim 2" => "DefeatAgahnim2",
			"Turtle Rock Medallion" => "Quake",
			"Misery Mire Medallion" => "Bombos",
			"Waterfall Bottle" => "BottleWithBluePotion",
			"Pyramid Bottle" => "BottleWithGreenPotion",
		], $loc_item_array);
	}

	/**
	 * Adjust this test and increment Logic on Randomizer if this fails.
	 *
	 * @group logic
	 */
	public function testLogicHasntChangedMajorGlitches() {
		$this->randomizer = new Randomizer('test_rules', 'MajorGlitches');
		$this->randomizer->makeSeed(1337);
		$loc_item_array = $this->randomizer->getWorld()->getLocations()->map(function($loc){
			return $loc->getItem()->getName();
		});

		$this->assertEquals([
			"Master Sword Pedestal" => "FiveRupees",
			"Link's Uncle" => "ProgressiveSword",
			"Secret Passage" => "PieceOfHeart",
			"King's Tomb" => "PieceOfHeart",
			"Floodgate Chest" => "ArrowUpgrade5",
			"Link's House" => "Flippers",
			"Kakariko Tavern" => "ThreeHundredRupees",
			"Chicken House" => "ThreeBombs",
			"Aginah's Cave" => "TenArrows",
			"Sahasrahla's Hut - Left" => "TwentyRupees",
			"Sahasrahla's Hut - Middle" => "TwentyRupees",
			"Sahasrahla's Hut - Right" => "PieceOfHeart",
			"Kakriko Well - Top" => "PieceOfHeart",
			"Kakriko Well - Left" => "FiftyRupees",
			"Kakriko Well - Middle" => "PieceOfHeart",
			"Kakriko Well - Right" => "HeartContainer",
			"Kakriko Well - Bottom" => "BombUpgrade5",
			"Blind's Hideout - Top" => "PieceOfHeart",
			"Blind's Hideout - Left" => "FiveRupees",
			"Blind's Hideout - Right" => "IceRod",
			"Blind's Hideout - Far Left" => "BossHeartContainer",
			"Blind's Hideout - Far Right" => "Quake",
			"Pegasus Rocks" => "ProgressiveShield",
			"Mini Moldorm Cave - Far Left" => "BombUpgrade5",
			"Mini Moldorm Cave - Left" => "TwentyRupees",
			"Mini Moldorm Cave - Right" => "TwentyRupees",
			"Mini Moldorm Cave - Far Right" => "ThreeBombs",
			"Ice Rod Cave" => "HalfMagic",
			"Bottle Merchant" => "MoonPearl",
			"Sahasrahla" => "ThreeBombs",
			"Magic Bat" => "BossHeartContainer",
			"Sick Kid" => "ArrowUpgrade5",
			"Hobo" => "ArrowUpgrade5",
			"Bombos Tablet" => "TwentyRupees",
			"King Zora" => "ThreeHundredRupees",
			"Lost Woods Hideout" => "TwentyRupees",
			"Lumberjack Tree" => "ProgressiveSword",
			"Cave 45" => "Hammer",
			"Graveyard Ledge" => "BottleWithGoldBee",
			"Checkerboard Cave" => "PieceOfHeart",
			"Mini Moldorm Cave - NPC" => "PieceOfHeart",
			"Library" => "ThreeBombs",
			"Mushroom" => "TwentyRupees",
			"Potion Shop" => "ProgressiveShield",
			"Maze Race" => "TwentyRupees",
			"Desert Ledge" => "ThreeBombs",
			"Lake Hylia Island" => "Ether",
			"Sunken Treasure" => "ProgressiveShield",
			"Zora's Ledge" => "BottleWithBluePotion",
			"Flute Spot" => "BombUpgrade5",
			"Waterfall Fairy - Left" => "BossHeartContainer",
			"Waterfall Fairy - Right" => "PieceOfHeart",
			"Sanctuary" => "MapH2",
			"Sewers - Secret Room - Left" => "ThreeBombs",
			"Sewers - Secret Room - Middle" => "TenArrows",
			"Sewers - Secret Room - Right" => "PieceOfHeart",
			"Sewers - Dark Cross" => "KeyH2",
			"Hyrule Castle - Boomerang Chest" => "BookOfMudora",
			"Hyrule Castle - Map Chest" => "TwentyRupees",
			"Hyrule Castle - Zelda's Cell" => "PieceOfHeart",
			"Eastern Palace - Compass Chest" => "CompassP1",
			"Eastern Palace - Big Chest" => "PieceOfHeart",
			"Eastern Palace - Cannonball Chest" => "MapP1",
			"Eastern Palace - Big Key Chest" => "BigKeyP1",
			"Eastern Palace - Map Chest" => "Boomerang",
			"Eastern Palace - Armos Knights" => "FiftyRupees",
			"Eastern Palace - Prize" => "Crystal4",
			"Desert Palace - Big Chest" => "KeyP2",
			"Desert Palace - Map Chest" => "CompassP2",
			"Desert Palace - Torch" => "BigKeyP2",
			"Desert Palace - Big Key Chest" => "TwentyRupees",
			"Desert Palace - Compass Chest" => "TwentyRupees",
			"Desert Palace - Lanmolas'" => "MapP2",
			"Desert Palace - Prize" => "PendantOfPower",
			"Old Man" => "FiftyRupees",
			"Spectacle Rock Cave" => "PieceOfHeart",
			"Ether Tablet" => "ProgressiveGlove",
			"Spectacle Rock" => "TwentyRupees",
			"Spiral Cave" => "TwentyRupees",
			"Mimic Cave" => "Bombos",
			"Paradox Cave Lower - Far Left" => "TwentyRupees",
			"Paradox Cave Lower - Left" => "Mushroom",
			"Paradox Cave Lower - Right" => "CaneOfSomaria",
			"Paradox Cave Lower - Far Right" => "PegasusBoots",
			"Paradox Cave Lower - Middle" => "BossHeartContainer",
			"Paradox Cave Upper - Left" => "FiftyRupees",
			"Paradox Cave Upper - Right" => "TwentyRupees",
			"Floating Island" => "BossHeartContainer",
			"Tower of Hera - Big Key Chest" => "TwentyRupees",
			"Tower of Hera - Basement Cage" => "MagicMirror",
			"Tower of Hera - Map Chest" => "KeyP3",
			"Tower of Hera - Compass Chest" => "MapP3",
			"Tower of Hera - Big Chest" => "CompassP3",
			"Tower of Hera - Moldorm" => "BigKeyP3",
			"Tower of Hera - Prize" => "Crystal2",
			"Castle Tower - Room 03" => "KeyA1",
			"Castle Tower - Dark Maze" => "KeyA1",
			"Agahnim" => "DefeatAgahnim",
			"Superbunny Cave - Top" => "PieceOfHeart",
			"Superbunny Cave - Bottom" => "BossHeartContainer",
			"Hookshot Cave - Top Right" => "BugCatchingNet",
			"Hookshot Cave - Top Left" => "BossHeartContainer",
			"Hookshot Cave - Bottom Left" => "PieceOfHeart",
			"Hookshot Cave - Bottom Right" => "FireRod",
			"Spike Cave" => "TwentyRupees",
			"Catfish" => "PieceOfHeart",
			"Pyramid" => "TenArrows",
			"Pyramid Fairy - Sword" => "L1Sword",
			"Pyramid Fairy - Bow" => "BowAndArrows",
			"Ganon" => "DefeatGanon",
			"Pyramid Fairy - Left" => "BossHeartContainer",
			"Pyramid Fairy - Right" => "ArrowUpgrade5",
			"Brewery" => "TenArrows",
			"C-Shaped House" => "Cape",
			"Chest Game" => "BottleWithFairy",
			"Hammer Pegs" => "PieceOfHeart",
			"Bumper Cave" => "ProgressiveGlove",
			"Blacksmith" => "SilverArrowUpgrade",
			"Purple Chest" => "TwentyRupees",
			"Hype Cave - Top" => "ThreeBombs",
			"Hype Cave - Middle Right" => "ProgressiveArmor",
			"Hype Cave - Middle Left" => "TwentyRupees",
			"Hype Cave - Bottom" => "ArrowUpgrade10",
			"Stumpy" => "PieceOfHeart",
			"Hype Cave - NPC" => "TwentyRupees",
			"Digging Game" => "ArrowUpgrade5",
			"Mire Shed - Left" => "FiftyRupees",
			"Mire Shed - Right" => "RedBoomerang",
			"Palace of Darkness - Shooter Room" => "FiftyRupees",
			"Palace of Darkness - Big Key Chest" => "KeyD1",
			"Palace of Darkness - The Arena - Ledge" => "KeyD1",
			"Palace of Darkness - The Arena - Bridge" => "BombUpgrade10",
			"Palace of Darkness - Stalfos Basement" => "KeyD1",
			"Palace of Darkness - Map Chest" => "KeyD1",
			"Palace of Darkness - Big Chest" => "MapD1",
			"Palace of Darkness - Compass Chest" => "KeyD1",
			"Palace of Darkness - Harmless Hellway" => "FiveRupees",
			"Palace of Darkness - Dark Basement - Left" => "KeyD1",
			"Palace of Darkness - Dark Basement - Right" => "CompassD1",
			"Palace of Darkness - Dark Maze - Top" => "BigKeyD1",
			"Palace of Darkness - Dark Maze - Bottom" => "Hookshot",
			"Palace of Darkness - Helmasaur King" => "Powder",
			"Palace of Darkness - Prize" => "PendantOfCourage",
			"Swamp Palace - Entrance" => "KeyD2",
			"Swamp Palace - Big Chest" => "TenArrows",
			"Swamp Palace - Big Key Chest" => "PieceOfHeart",
			"Swamp Palace - Map Chest" => "TwentyRupees",
			"Swamp Palace - West Chest" => "OneHundredRupees",
			"Swamp Palace - Compass Chest" => "TwentyRupees",
			"Swamp Palace - Flooded Room - Left" => "BigKeyD2",
			"Swamp Palace - Flooded Room - Right" => "CompassD2",
			"Swamp Palace - Waterfall Room" => "MapD2",
			"Swamp Palace - Arrghus" => "ThreeHundredRupees",
			"Swamp Palace - Prize" => "Crystal3",
			"Skull Woods - Big Chest" => "Shovel",
			"Skull Woods - Big Key Chest" => "KeyD3",
			"Skull Woods - Compass Chest" => "CompassD3",
			"Skull Woods - Map Chest" => "KeyD3",
			"Skull Woods - Bridge Room" => "ProgressiveSword",
			"Skull Woods - Pot Prison" => "MapD3",
			"Skull Woods - Pinball Room" => "KeyD3",
			"Skull Woods - Mothula" => "BigKeyD3",
			"Skull Woods - Prize" => "Crystal1",
			"Thieves' Town - Attic" => "MapD4",
			"Thieves' Town - Big Key Chest" => "TwentyRupees",
			"Thieves' Town - Map Chest" => "ThreeBombs",
			"Thieves' Town - Compass Chest" => "BigKeyD4",
			"Thieves' Town - Ambush Chest" => "CompassD4",
			"Thieves' Town - Big Chest" => "Arrow",
			"Thieves' Town - Blind's Cell" => "KeyD4",
			"Thieves' Town - Blind" => "BottleWithFairy",
			"Thieves' Town - Prize" => "Crystal7",
			"Ice Palace - Big Key Chest" => "KeyD5",
			"Ice Palace - Compass Chest" => "TwentyRupees",
			"Ice Palace - Map Chest" => "MapD5",
			"Ice Palace - Spike Room" => "BigKeyD5",
			"Ice Palace - Freezor Chest" => "KeyD5",
			"Ice Palace - Iced T Room" => "CompassD5",
			"Ice Palace - Big Chest" => "OcarinaInactive",
			"Ice Palace - Kholdstare" => "BossHeartContainer",
			"Ice Palace - Prize" => "PendantOfWisdom",
			"Misery Mire - Big Chest" => "KeyD6",
			"Misery Mire - Main Lobby" => "CompassD6",
			"Misery Mire - Big Key Chest" => "MapD6",
			"Misery Mire - Compass Chest" => "PieceOfHeart",
			"Misery Mire - Bridge Chest" => "Lamp",
			"Misery Mire - Map Chest" => "BigKeyD6",
			"Misery Mire - Spike Chest" => "KeyD6",
			"Misery Mire - Vitreous" => "KeyD6",
			"Misery Mire - Prize" => "Crystal5",
			"Turtle Rock - Chain Chomps" => "BossHeartContainer",
			"Turtle Rock - Compass Chest" => "OneRupee",
			"Turtle Rock - Roller Room - Left" => "Bow",
			"Turtle Rock - Roller Room - Right" => "KeyD7",
			"Turtle Rock - Big Chest" => "MapD7",
			"Turtle Rock - Big Key Chest" => "BigKeyD7",
			"Turtle Rock - Crystaroller Room" => "KeyD7",
			"Turtle Rock - Eye Bridge - Bottom Left" => "ThreeBombs",
			"Turtle Rock - Eye Bridge - Bottom Right" => "KeyD7",
			"Turtle Rock - Eye Bridge - Top Left" => "CompassD7",
			"Turtle Rock - Eye Bridge - Top Right" => "KeyD7",
			"Turtle Rock - Trinexx" => "PieceOfHeart",
			"Turtle Rock - Prize" => "Crystal6",
			"Ganon's Tower - Bob's Torch" => "ArrowUpgrade5",
			"Ganon's Tower - DMs Room - Top Left" => "ProgressiveSword",
			"Ganon's Tower - DMs Room - Top Right" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Left" => "KeyA2",
			"Ganon's Tower - DMs Room - Bottom Right" => "ProgressiveArmor",
			"Ganon's Tower - Randomizer Room - Top Left" => "ThreeBombs",
			"Ganon's Tower - Randomizer Room - Top Right" => "CompassA2",
			"Ganon's Tower - Randomizer Room - Bottom Left" => "ThreeHundredRupees",
			"Ganon's Tower - Randomizer Room - Bottom Right" => "ThreeHundredRupees",
			"Ganon's Tower - Firesnake Room" => "TwentyRupees",
			"Ganon's Tower - Map Chest" => "PieceOfHeart",
			"Ganon's Tower - Big Chest" => "TwentyRupees",
			"Ganon's Tower - Hope Room - Left" => "BombUpgrade5",
			"Ganon's Tower - Hope Room - Right" => "FiftyRupees",
			"Ganon's Tower - Bob's Chest" => "TwentyRupees",
			"Ganon's Tower - Tile Room" => "KeyA2",
			"Ganon's Tower - Compass Room - Top Left" => "BombUpgrade5",
			"Ganon's Tower - Compass Room - Top Right" => "CaneOfByrna",
			"Ganon's Tower - Compass Room - Bottom Left" => "BigKeyA2",
			"Ganon's Tower - Compass Room - Bottom Right" => "OneRupee",
			"Ganon's Tower - Big Key Chest" => "BombUpgrade5",
			"Ganon's Tower - Big Key Room - Left" => "KeyA2",
			"Ganon's Tower - Big Key Room - Right" => "TwentyRupees",
			"Ganon's Tower - Mini Helmasaur Room - Left" => "PieceOfHeart",
			"Ganon's Tower - Mini Helmasaur Room - Right" => "MapA2",
			"Ganon's Tower - Pre-Moldorm Chest" => "FiveRupees",
			"Ganon's Tower - Moldorm Chest" => "PieceOfHeart",
			"Agahnim 2" => "DefeatAgahnim2",
			"Turtle Rock Medallion" => "Quake",
			"Misery Mire Medallion" => "Bombos",
			"Waterfall Bottle" => "BottleWithBluePotion",
			"Pyramid Bottle" => "BottleWithGreenPotion",
		], $loc_item_array);
	}
}
