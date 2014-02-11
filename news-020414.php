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
		private $out_index;
		
		function __construct() {
			//create init array and fill with tiles
			$this->init_array = array (
				new Tile("small"), new Tile("medium rectangle"),
				new Tile("medium square"), new Tile("large short"),
				new Tile("large long")
			);
			$this->out_index = 0;
		}
		
		function getRandomTile($start) {
			switch($start) {
				case "all":
					$t = $this->init_array[rand(0,4)];
					return $t;
					break;
				case "short":
					$t = $this->init_array[rand(0,1)];
					return $t;
					break;
				case "320":
					$t = $this->init_array[rand(0,2)];
					return $t;
					break;
				case "160":
					$t = $this->init_array[0];
					return $t;
					break;
				default:
					echo "invalid tile selection";
			}
		}
		
		function selectTile() {
			while($room){
			
			}
		}
		
		
		
		function commitTile($tile, $top, $left) {
			if ($this->out_index == 0){
				$tile->setOrigin(0, 0);
				$this->out_array[0] = $tile;
				$this->out_index += 1;
			}
			else {
				$tile->setOrigin($top, $left);
				$this->out_array[$this->out_index] = $tile;
				$this->out_index += 1;
			}
		}
		
		function displayTiles() {
			foreach ($this->out_array as $tile) {
				$tile->display();
			}
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
		$rtm->commitTile($rtm->getRandomTile("all"), 0, 0);
		$rtm->commitTile($rtm->getRandomTile("all"), 160, 160);
		$rtm->displayTiles();
		
	?>

</div>

</body>
