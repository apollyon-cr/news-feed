<?PHP
	class Tile {
		
		private $type;
		private $width;
		private $height;
		private $top;
		private $left;
		
		
		function __construct ($tile) {
			switch($tile) {
				case "large long":
					$this->type = "lrg_ln";
					$this->width = 640;
					$this->height = 320;
					break;
				case "large short":
					$this->type = "lrg_sh";
					$this->width = 480;
					$this->height = 320;
					break;
				case "medium rectangle":
					$this->type = "med_rec";
					$this->width = 320;
					$this->height = 160;
					break;
				case "medium square":
					$this->type = "med_sq";
					$this->width = 320;
					$this->height = 320;
					break;
				case "small":
					$this->type = "small";
					$this->width = 160;
					$this->height = 160;
					break;
				default:
					echo "tile type not found";
			}
		
		}
		
		function getType() {
			return $this->type;
		}
		
		function getWidth() {
			return $this->width;
		}
		
		function getHeight() {
			return $this->height;
		}
		
		function getTop() {
			return $this->top;
		}
		
		function getLeft() {
			return $this->left;
		}
		
		function setOrigin($t, $l) {
			$this->top = $t;
			$this->left = $l;
		}
		
		function display() {
			echo $this->type;
			?>
			<div class="<?PHP echo $this->type;?>" style="top: <?PHP echo $this->top ?>px; left: <?PHP echo $this->left ?>px;" ></div>
			<?PHP	
		}
	
	}
	
	class RandomTileMason {
		const PANEL_WIDTH = 960;
		const PANEL_HEIGHT = 480;
		private $init_array;
		private $out_array;
		private $out_index = 0;
		private $width_used = 0;
		private $height_used = 0;
		//private $row_room = true;

		function __construct() {
			//create init array and fill with tiles
			$this->init_array = array (
				new Tile("small"), new Tile("medium rectangle"),
				new Tile("medium square"), new Tile("large short"),
				new Tile("large long")
			);

			$this->out_index = 0;
			$this->commitTile($this->getRandomTile("all"), 0, 0);
			//while($this->row_room) {
			//	$this->selectTileForRow();
			//}
		}
		
		function getRandomTile($start) {
			switch($start) {
				case "all":
					$t = clone $this->init_array[rand(0,4)];
					return $t;
					break;
				case "short":
					$t = clone $this->init_array[rand(0,1)];
					return $t;
					break;
				case "320":
					$t = clone $this->init_array[rand(0,2)];
					return $t;
					break;
				case "160":
					$t = clone $this->init_array[0];
					return $t;
					break;
				default:
					echo "invalid tile selection";
			}
		}
		
		function masonTiles() {
			//do until area of tiles = area of panel
			
		
			//calcWidth remaining from out_array[beside]
			//getRandomTile based on remaining
			//ifRoom -> commitTile() top: 0, left: beside->getWidth + getLeft
			
			//calcHeight remaining from out_array[n-1]
			//getHeight from out_array[n-1]
			//if height > 160
				//getRandomTile based on remaining
				//ifRoom -> commitTile() top: above->getHeight + getTop, left: 0
			//else getLeft
				//calcWidth remaining from out_array[n-1]
				//ifRoom -> commitTile() top: above->getHeight + getTop, left: 0
		}
		
		
		/*
		function selectTileForRow() {		
			$width_remaining = (self::PANEL_WIDTH - $this->width_used );
			if($width_remaining > 720) {
				//all
				$temp = $this->getRandomTile("all");
				$this->commitTile($temp, 0, $this->width_used);
			}
			else if($width_remaining > 320) {
				//320
				$temp = $this->getRandomTile("320");
				$this->commitTile($temp, 0, $this->width_used);
			}
			else if($width_remaining > 160) {
				//160
				$temp = $this->getRandomTile("160");
				$this->commitTile($temp, 0, $this->width_used);
			}
			else {
				//160
				$temp = $this->getRandomTile("160");
				$this->commitTile($temp, 0, $this->width_used);
				$this->row_room = false;
			}
		}
		*/
				
		function commitTile($tile, $top, $left) {
			$tile->setOrigin($top, $left);
			$this->out_array[$this->out_index] = $tile;
			$this->width_used += $tile->getWidth();
			$this->height_used += $tile->getHeight();
			$this->out_index += 1;
		}
		
		function displayTiles() {
			foreach ($this->out_array as $tile) {
				$tile->display();
			}
		}
		
		function getUsed() {
			return $this->width_used . " " . $this->height_used;
		}	
	}
		
		
?>

<html>
<head>
<link rel="stylesheet" href="news.css" media="screen"/> 
</head>

<body>

<div id="container">
	<?PHP
		$rtm = new randomTileMason();
		$rtm->displayTiles();
		echo $rtm->getUsed();
		
	?>

</div>

</body>
